<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Location;
use App\Models\Stock;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Unit;
use App\Services\RecipeDeductionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;
use PHPUnit\Framework\Attributes\Test; // Menggunakan PHP Attributes

class RecipeDeductionServiceTest extends TestCase
{
    use RefreshDatabase; // Memastikan database bersih sebelum setiap test

    protected RecipeDeductionService $service;
    protected $location;
    protected $kopi; // Model Ingredient (Biji Kopi)
    protected $menu; // Model Menu Item (Es Kopi Susu)
    protected $userId;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new RecipeDeductionService();

        // --- SETUP DATA MASTER UTAMA ---
        // 1. Buat Dependencies (Location, User, Unit)
        $this->location = Location::factory()->create();
        $user = User::factory()->create(['role' => 'admin']);
        $this->userId = $user->id;
        $unitKg = Unit::factory()->create(['name' => 'Kilogram', 'symbol' => 'kg']);

        // 2. Buat Ingredient Kopi dan Menu
        $this->kopi = Product::factory()->create(['type' => 'ingredient', 'name' => 'Biji Kopi', 'unit_id' => $unitKg->id]);
        $this->menu = Product::factory()->create(['type' => 'menu', 'name' => 'Es Kopi Susu']);

        // 3. Buat Resep: 1 Menu membutuhkan 0.0120 KG Kopi
        Recipe::create([
            'menu_product_id' => $this->menu->id,
            'ingredient_product_id' => $this->kopi->id,
            'quantity_used' => 0.0120,
        ]);

        // 4. Beri Stok Awal: 1 KG Kopi (1.0000)
        Stock::create([
            'product_id' => $this->kopi->id,
            'location_id' => $this->location->id,
            'quantity' => 1.0000,
        ]);
    }

    // ----------------------------------------------------
    // TEST CASE 1: SUCCESS - AKURASI DECIMAL DEDUCTION
    // Kriteria: Logika perhitungan & Presisi Desimal
    // ----------------------------------------------------

    #[Test]
    public function it_successfully_deducts_ingredients_with_precision()
    {
        $quantitySold = 50; // Jual 50 porsi
        $expectedFinalStock = 1.0000 - (0.0120 * 50); // Hasil: 0.4000 kg

        // ACT: Panggil service deduct
        $this->service->deduct($this->menu->id, $quantitySold, 1, $this->location->id, $this->userId);

        // ASSERT: Verifikasi stok berkurang tepat
        $finalStock = Stock::where('product_id', $this->kopi->id)->first()->quantity;

        // Memastikan presisi desimal terjaga
        $this->assertEquals($expectedFinalStock, $finalStock);
        $this->assertDatabaseCount('stock_movements', 1);
    }

    // ----------------------------------------------------
    // TEST CASE 2: FAILURE - PENANGANAN STOK KURANG (ROLLBACK)
    // Kriteria: Penanganan null atau data kosong
    // ----------------------------------------------------

    #[Test]
    public function it_throws_exception_if_stock_is_insufficient()
    {
        $quantitySold = 100; // Jual 100 porsi (1.2 kg dibutuhkan)

        // ASSERT: Diharapkan terjadi Exception (memverifikasi penanganan stok kurang)
        $this->expectException(Exception::class);

        // ACT: Panggil service deduct
        $this->service->deduct($this->menu->id, $quantitySold, 1, $this->location->id, $this->userId);

        // ASSERT: Verifikasi stok TIDAK BERUBAH (Rollback Logic)
        $currentStock = Stock::where('product_id', $this->kopi->id)->first()->quantity;
        $this->assertEquals(1.0000, $currentStock);
        $this->assertDatabaseCount('stock_movements', 0);
    }
}