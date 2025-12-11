<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil FK yang dibutuhkan (Asumsi seeder Category dan Unit sudah jalan)
        $catKopi = Category::where('name', 'Minuman Kopi')->first()->id;
        $catBahan = Category::where('name', 'Bahan Baku Cair')->first()->id;
        $unitKg = Unit::where('symbol', 'kg')->first()->id;
        $unitLiter = Unit::where('symbol', 'l')->first()->id;

        // --- 1. BAHAN BAKU (INGREDIENT) ---
        Product::firstOrCreate(['name' => 'Biji Kopi Arabika'], [
            'category_id' => $catBahan,
            'unit_id' => $unitKg,
            'type' => 'ingredient',
            'sku' => 'ING001',
            'purchase_price' => 150000,
            'stock_minimum' => 5,
        ]);
        Product::firstOrCreate(['name' => 'Susu UHT Full Cream'], [
            'category_id' => $catBahan,
            'unit_id' => $unitLiter,
            'type' => 'ingredient',
            'sku' => 'ING002',
            'purchase_price' => 18000,
            'stock_minimum' => 10,
        ]);
        Product::firstOrCreate(['name' => 'Gula Aren Cair'], [
            'category_id' => $catBahan,
            'unit_id' => $unitLiter,
            'type' => 'ingredient',
            'sku' => 'ING003',
            'purchase_price' => 25000,
            'stock_minimum' => 8,
        ]);

        // --- 2. MENU (DIJUAL) ---
        Product::firstOrCreate(['name' => 'Es Kopi Susu Signature'], [
            'category_id' => $catKopi,
            'type' => 'menu',
            'sale_price' => 25000,
            'sku' => null,
            'stock_minimum' => 0,
        ]);
        Product::firstOrCreate(['name' => 'Latte Panas'], [
            'category_id' => $catKopi,
            'type' => 'menu',
            'sale_price' => 28000,
            'sku' => null,
            'stock_minimum' => 0,
        ]);
    }
}