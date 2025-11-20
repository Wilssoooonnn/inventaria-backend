<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID Produk & Bahan Baku yang sudah dibuat
        $menuId = Product::where('name', 'Es Kopi Susu Signature')->first()->id;
        $latteId = Product::where('name', 'Latte Panas')->first()->id;
        $kopiId = Product::where('name', 'Biji Kopi Arabika')->first()->id;
        $susuId = Product::where('name', 'Susu UHT Full Cream')->first()->id;
        $gulaId = Product::where('name', 'Gula Aren Cair')->first()->id;

        // Pastikan Menu dan Bahan Baku ada
        if ($menuId && $kopiId && $susuId && $gulaId) {

            // Hapus resep lama untuk Menu ini
            Recipe::where('menu_product_id', $menuId)->delete();
            Recipe::where('menu_product_id', $latteId)->delete();

            // --- RESEP 1: Es Kopi Susu Signature ---
            // 1. Kopi: Butuh 0.012 kg (12 gram)
            Recipe::create([
                'menu_product_id' => $menuId,
                'ingredient_product_id' => $kopiId,
                'quantity_used' => 0.012,
            ]);
            // 2. Susu: Butuh 0.100 liter (100 ml)
            Recipe::create([
                'menu_product_id' => $menuId,
                'ingredient_product_id' => $susuId,
                'quantity_used' => 0.100,
            ]);
            // 3. Gula: Butuh 0.030 liter (30 ml)
            Recipe::create([
                'menu_product_id' => $menuId,
                'ingredient_product_id' => $gulaId,
                'quantity_used' => 0.030,
            ]);

            // --- RESEP 2: Latte Panas ---
            // 1. Kopi: Butuh 0.015 kg (15 gram)
            Recipe::create([
                'menu_product_id' => $latteId,
                'ingredient_product_id' => $kopiId,
                'quantity_used' => 0.015,
            ]);
            // 2. Susu: Butuh 0.200 liter (200 ml)
            Recipe::create([
                'menu_product_id' => $latteId,
                'ingredient_product_id' => $susuId,
                'quantity_used' => 0.200,
            ]);
        }
    }
}