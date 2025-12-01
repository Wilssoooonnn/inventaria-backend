<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;
    protected $unit;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup user dan master data
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->category = Category::factory()->create();
        $this->unit = Unit::factory()->create(['symbol' => 'kg']);
    }

    // ----------------------------------------------------
    // TEST CASE 1: SUCCESSFUL CREATION OF INGREDIENT
    // ----------------------------------------------------

    #[Test]
    public function creation_of_valid_ingredient_succeeds()
    {
        // Kriteria: Logika perhitungan (set 0 price)
        $payload = [
            'type' => 'ingredient',
            'sku' => 'KODE001',
            'name' => 'Biji Kopi Arabika',
            'unit_id' => $this->unit->id,
            'category_id' => $this->category->id,
            'purchase_price' => 150000.00,
            'sale_price' => 0, // Diharapkan 0 karena ini ingredient
            'stock_minimum' => 10,
        ];

        $response = $this->actingAs($this->admin, 'sanctum')->postJson('/api/products', $payload);

        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('products', ['sku' => 'KODE001', 'sale_price' => 0]);
    }

    // ----------------------------------------------------
    // TEST CASE 2: FAILURE - SKU UNIK & VALIDASI BARCODE
    // ----------------------------------------------------

    #[Test]
    public function creation_fails_on_duplicate_sku()
    {
        // 1. Buat produk awal
        Product::factory()->create([
            'type' => 'ingredient',
            'sku' => 'KODE001',
            'unit_id' => $this->unit->id,
            'category_id' => $this->category->id,
        ]);

        // 2. Coba buat produk kedua dengan SKU yang sama
        $response = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/products', [
                'type' => 'ingredient',
                'sku' => 'KODE001', // SKU duplikat
                'name' => 'Kopi Kedua',
                'unit_id' => $this->unit->id,
                'category_id' => $this->category->id,
                'purchase_price' => 100,
            ]);

        // ASSERT: Diharapkan 422 Validation Error
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['sku']); // Kriteria: Validasi input (barcode)
    }

    // ----------------------------------------------------
    // TEST CASE 3: FAILURE - MISSING FOREIGN KEY (UNIT ID)
    // ----------------------------------------------------

    #[Test]
    public function ingredient_creation_fails_if_unit_id_is_missing()
    {
        // Kriteria: Validasi input (penanganan null/FK)
        // Coba buat Ingredient tanpa mengisi unit_id (padahal wajib)
        $response = $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/products', [
                'type' => 'ingredient',
                'sku' => 'KODE-BARU',
                'name' => 'Gula',
                'category_id' => $this->category->id,
                'purchase_price' => 100,
                'unit_id' => null, // <-- Gagal disini karena rule wajib
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['unit_id']);
    }
}