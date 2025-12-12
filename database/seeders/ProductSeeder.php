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
        $catKopi = Category::where('name', 'Minuman Kopi')->first()->id ?? 1;
        $catNonKopi = Category::firstOrCreate(['name' => 'Minuman Non-Kopi'])->id;
        $catSnack = Category::firstOrCreate(['name' => 'Makanan Ringan'])->id;
        $catBahanCair = Category::where('name', 'Bahan Baku Cair')->first()->id ?? 1;
        $catBahanKering = Category::firstOrCreate(['name' => 'Bahan Baku Kering'])->id;

        $unitKg = Unit::where('symbol', 'kg')->first()->id;
        $unitLiter = Unit::where('symbol', 'l')->first()->id;
        $unitPcs = Unit::firstOrCreate(['name' => 'Pcs', 'symbol' => 'pcs'])->id;

        // =========================================================
        // 1. BAHAN BAKU (INGREDIENT) - 8 ITEM
        // =========================================================

        Product::firstOrCreate(['name' => 'Biji Kopi Arabika House Blend'], [
            'category_id' => $catBahanKering,
            'unit_id' => $unitKg,
            'type' => 'ingredient',
            'sku' => 'ING001',
            'purchase_price' => 140000, // Rp140.000 per kg
            'stock_minimum' => 5,
        ]);
        Product::firstOrCreate(['name' => 'Susu UHT Full Cream'], [
            'category_id' => $catBahanCair,
            'unit_id' => $unitLiter,
            'type' => 'ingredient',
            'sku' => 'ING002',
            'purchase_price' => 18000, // Rp18.000 per liter
            'stock_minimum' => 10,
        ]);
        Product::firstOrCreate(['name' => 'Sirup Vanila Premium'], [
            'category_id' => $catBahanCair,
            'unit_id' => $unitLiter,
            'type' => 'ingredient',
            'sku' => 'ING004',
            'purchase_price' => 80000, // Rp80.000 per liter
            'stock_minimum' => 5,
        ]);
        Product::firstOrCreate(['name' => 'Cokelat Bubuk Murni'], [
            'category_id' => $catBahanKering,
            'unit_id' => $unitKg,
            'type' => 'ingredient',
            'sku' => 'ING005',
            'purchase_price' => 90000, // Rp90.000 per kg
            'stock_minimum' => 3,
        ]);
        Product::firstOrCreate(['name' => 'Teh Hijau Matcha Powder'], [
            'category_id' => $catBahanKering,
            'unit_id' => $unitKg,
            'type' => 'ingredient',
            'sku' => 'ING006',
            'purchase_price' => 120000, // Rp120.000 per kg
            'stock_minimum' => 2,
        ]);
        Product::firstOrCreate(['name' => 'Roti Tawar Tebal'], [
            'category_id' => $catBahanKering,
            'unit_id' => $unitPcs,
            'type' => 'ingredient',
            'sku' => 'ING007',
            'purchase_price' => 4000, // Rp4.000 per lembar
            'stock_minimum' => 50,
        ]);
        Product::firstOrCreate(['name' => 'Keju Mozzarella Curah'], [
            'category_id' => $catBahanKering,
            'unit_id' => $unitKg,
            'type' => 'ingredient',
            'sku' => 'ING008',
            'purchase_price' => 75000, // Rp75.000 per kg
            'stock_minimum' => 5,
        ]);
        Product::firstOrCreate(['name' => 'Butter/Margarine'], [
            'category_id' => $catBahanCair,
            'unit_id' => $unitKg,
            'type' => 'ingredient',
            'sku' => 'ING009',
            'purchase_price' => 30000, // Rp30.000 per kg
            'stock_minimum' => 10,
        ]);

        // =========================================================
        // 2. MENU (DIJUAL) - 10 ITEM
        // =========================================================

        // Kopi
        Product::firstOrCreate(['name' => 'Es Kopi Susu Signature'], ['category_id' => $catKopi, 'type' => 'menu', 'sale_price' => 25000,]);
        Product::firstOrCreate(['name' => 'Espresso Shot'], ['category_id' => $catKopi, 'type' => 'menu', 'sale_price' => 15000,]);
        Product::firstOrCreate(['name' => 'Cappuccino Panas'], ['category_id' => $catKopi, 'type' => 'menu', 'sale_price' => 28000,]);
        Product::firstOrCreate(['name' => 'Iced Vanilla Latte'], ['category_id' => $catKopi, 'type' => 'menu', 'sale_price' => 32000,]);
        Product::firstOrCreate(['name' => 'Caramel Macchiato'], ['category_id' => $catKopi, 'type' => 'menu', 'sale_price' => 35000,]);

        // Non-Kopi
        Product::firstOrCreate(['name' => 'Hot Chocolate'], ['category_id' => $catNonKopi, 'type' => 'menu', 'sale_price' => 28000,]);
        Product::firstOrCreate(['name' => 'Iced Matcha Latte'], ['category_id' => $catNonKopi, 'type' => 'menu', 'sale_price' => 30000,]);
        Product::firstOrCreate(['name' => 'Teh Lemon Dingin'], ['category_id' => $catNonKopi, 'type' => 'menu', 'sale_price' => 18000,]);

        // Makanan
        Product::firstOrCreate(['name' => 'Roti Bakar Keju'], ['category_id' => $catSnack, 'type' => 'menu', 'sale_price' => 22000,]);
        Product::firstOrCreate(['name' => 'Butter Croissant'], ['category_id' => $catSnack, 'type' => 'menu', 'sale_price' => 15000,]);
    }
}