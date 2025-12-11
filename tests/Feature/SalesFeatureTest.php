<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Location;
use App\Models\Stock;
use App\Models\Recipe;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SalesFeatureTest extends TestCase
{
    use RefreshDatabase; // Memastikan database bersih untuk setiap test

    protected $staff;
    protected $location;
    protected $menuId;
    protected $kopiId;
    protected $initialStockQty = 5.0000;

    protected function setUp(): void
    {
        parent::setUp();

        // --- SETUP DATA MASTER F&B ---
        $this->location = Location::factory()->create(['id' => 1, 'name' => 'Main Outlet']);
        $this->staff = User::factory()->create(['role' => 'staff', 'location_id' => $this->location->id]);
        $unitKg = Unit::factory()->create(['symbol' => 'kg']); // Asumsi Unit::id 1 sudah ada

        // 1. Buat Ingredient Kopi
        $kopi = Product::factory()->ingredient()->create(['name' => 'Biji Kopi', 'unit_id' => $unitKg->id]);
        $this->kopiId = $kopi->id;

        // 2. Buat Menu
        $menu = Product::factory()->menu()->create(['name' => 'Es Kopi Susu', 'sale_price' => 25000]);
        $this->menuId = $menu->id;

        // 3. Buat Resep: 1 Menu butuh 0.010 kg Kopi
        Recipe::create(['menu_product_id' => $this->menuId, 'ingredient_product_id' => $this->kopiId, 'quantity_used' => 0.0100]);

        // 4. Beri Stok Awal: 5 KG Kopi
        Stock::create(['product_id' => $this->kopiId, 'location_id' => $this->location->id, 'quantity' => $this->initialStockQty]);
    }

    // ----------------------------------------------------
    // TEST CASE 1: TRANSAKSI SUKSES (Atomic Stock Deduction)
    // ----------------------------------------------------

    #[Test]
    public function it_successfully_creates_sale_and_deducts_stock()
    {
        // Jual 100 porsi (0.010 kg * 100 = 1.0 kg dibutuhkan)
        $quantitySold = 100;
        $totalDeduction = 1.0000;
        $expectedFinalStock = $this->initialStockQty - $totalDeduction; // 5.0000 - 1.0000 = 4.0000

        $salePayload = [
            'invoice_number' => 'POS-' . time() . 'S',
            'location_id' => $this->location->id,
            'total_amount' => 25000 * $quantitySold,
            'items' => [
                [
                    'product_id' => $this->menuId,
                    'quantity' => $quantitySold,
                    'unit_price' => 25000,
                    'subtotal' => 25000 * $quantitySold,
                ]
            ],
        ];

        // ACT: Panggil endpoint sales sebagai Staff
        $response = $this->actingAs($this->staff, 'sanctum')
            ->postJson('/api/sales', $salePayload);

        // ASSERT 1: Verifikasi Status 201 Created
        $response->assertStatus(201);

        // ASSERT 2: Verifikasi record penjualan dibuat
        $this->assertDatabaseHas('sales', ['invoice_number' => $salePayload['invoice_number']]);

        // ASSERT 3: Verifikasi Stok BERKURANG (Logika deduction service berhasil)
        $finalStock = Stock::where('product_id', $this->kopiId)->first()->quantity;
        $this->assertEquals($expectedFinalStock, $finalStock);

        // ASSERT 4: Verifikasi Log Pergerakan (Audit)
        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $this->kopiId,
            'quantity_change' => -$totalDeduction,
            'type' => 'outbound_recipe',
        ]);
    }

    // ----------------------------------------------------
    // TEST CASE 2: KEGAGALAN (ATOMIC ROLLBACK CHECK)
    // ----------------------------------------------------

    #[Test]
    public function sales_must_rollback_if_stock_is_insufficient()
    {
        // ARRANGE: Coba jual 1000 porsi (membutuhkan 10 kg Kopi). Stok hanya 5 kg.
        $salePayload = [
            'invoice_number' => 'FAIL-' . time() . 'R',
            'location_id' => $this->location->id,
            'total_amount' => 20000000,
            'items' => [
                [
                    'product_id' => $this->menuId,
                    'quantity' => 1000, // Kuantitas Fatal
                    'unit_price' => 25000,
                    'subtotal' => 25000000,
                ]
            ],
        ];

        // ACT: Panggil endpoint sales (sebagai Staff)
        $response = $this->actingAs($this->staff, 'sanctum')
            ->postJson('/api/sales', $salePayload);

        // ASSERT 1: Transaksi harus gagal (500 karena service membuang Exception)
        $response->assertStatus(500);

        // ASSERT 2: Verifikasi Integritas Database (HARUS DI-ROLLBACK)
        // Record penjualan TIDAK BOLEH dibuat
        $this->assertDatabaseMissing('sales', ['invoice_number' => $salePayload['invoice_number']]);

        // ASSERT 3: Verifikasi Stok TIDAK BERUBAH (Rollback berhasil)
        $finalStock = Stock::where('product_id', $this->kopiId)->first()->quantity;
        $this->assertEquals($this->initialStockQty, $finalStock);
    }
}