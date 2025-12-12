<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. Ambil ID Menu ---
        $menuSignatureId = Product::where('name', 'Es Kopi Susu Signature')->first()->id;
        $menuEspressoId = Product::where('name', 'Espresso Shot')->first()->id;
        $menuCapuccinoId = Product::where('name', 'Cappuccino Panas')->first()->id;
        $menuVanillaId = Product::where('name', 'Iced Vanilla Latte')->first()->id;
        $menuCaramelId = Product::where('name', 'Caramel Macchiato')->first()->id;
        $menuChocoId = Product::where('name', 'Hot Chocolate')->first()->id;
        $menuMatchaId = Product::where('name', 'Iced Matcha Latte')->first()->id;
        $menuLemonId = Product::where('name', 'Teh Lemon Dingin')->first()->id;
        $menuRotiId = Product::where('name', 'Roti Bakar Keju')->first()->id;
        $menuCroissantId = Product::where('name', 'Butter Croissant')->first()->id;


        // --- 2. Ambil ID Bahan Baku ---
        $kopiId = Product::where('name', 'Biji Kopi Arabika House Blend')->first()->id;
        $susuId = Product::where('name', 'Susu UHT Full Cream')->first()->id;
        $sirupVanilaId = Product::where('name', 'Sirup Vanila Premium')->first()->id;
        $cokelatId = Product::where('name', 'Cokelat Bubuk Murni')->first()->id;
        $matchaId = Product::where('name', 'Teh Hijau Matcha Powder')->first()->id;
        $rotiId = Product::where('name', 'Roti Tawar Tebal')->first()->id;
        $kejuId = Product::where('name', 'Keju Mozzarella Curah')->first()->id;
        $butterId = Product::where('name', 'Butter/Margarine')->first()->id;

        // Hapus resep lama
        Recipe::whereNotNull('id')->delete();


        // =========================================================
        // RESEP KOPI
        // =========================================================

        // RESEP 1: Es Kopi Susu Signature (Jual: 25k, HPP ~4.350)
        $this->createRecipe($menuSignatureId, $kopiId, 0.012); // 12 gram
        $this->createRecipe($menuSignatureId, $susuId, 0.100); // 100 ml

        // RESEP 2: Espresso Shot (Jual: 15k, HPP ~1.260)
        $this->createRecipe($menuEspressoId, $kopiId, 0.009); // 9 gram

        // RESEP 3: Cappuccino Panas (Jual: 28k, HPP ~4.380)
        $this->createRecipe($menuCapuccinoId, $kopiId, 0.012); // 12 gram
        $this->createRecipe($menuCapuccinoId, $susuId, 0.150); // 150 ml

        // RESEP 4: Iced Vanilla Latte (Jual: 32k, HPP ~6.300)
        $this->createRecipe($menuVanillaId, $kopiId, 0.015); // 15 gram
        $this->createRecipe($menuVanillaId, $susuId, 0.100); // 100 ml
        $this->createRecipe($menuVanillaId, $sirupVanilaId, 0.030); // 30 ml

        // RESEP 5: Caramel Macchiato (Jual: 35k, HPP ~6.000)
        $this->createRecipe($menuCaramelId, $kopiId, 0.018); // 18 gram
        $this->createRecipe($menuCaramelId, $susuId, 0.120); // 120 ml
        // Asumsi Sirup Caramel dan Gula Aren sudah ada/dianggap kecil HPPnya


        // =========================================================
        // RESEP NON-KOPI
        // =========================================================

        // RESEP 6: Hot Chocolate (Jual: 28k, HPP ~7.200)
        $this->createRecipe($menuChocoId, $cokelatId, 0.040); // 40 gram
        $this->createRecipe($menuChocoId, $susuId, 0.200); // 200 ml

        // RESEP 7: Iced Matcha Latte (Jual: 30k, HPP ~6.000)
        $this->createRecipe($menuMatchaId, $matchaId, 0.050); // 50 gram
        $this->createRecipe($menuMatchaId, $susuId, 0.150); // 150 ml

        // RESEP 8: Teh Lemon Dingin (Jual: 18k, HPP ~1.000)
        // Asumsi: Hanya butuh gula/teh celup yang HPPnya sangat kecil.
        // Kita hanya catat 1 bahan baku utama: Air Lemon (diwakili Sirup Vanila)
        $this->createRecipe($menuLemonId, $sirupVanilaId, 0.010); // 10 ml sirup/konsentrat


        // =========================================================
        // RESEP MAKANAN
        // =========================================================

        // RESEP 9: Roti Bakar Keju (Jual: 22k, HPP ~12.050)
        $this->createRecipe($menuRotiId, $rotiId, 2.000); // 2 Lembar Roti
        $this->createRecipe($menuRotiId, $kejuId, 0.050); // 50 gram Keju
        $this->createRecipe($menuRotiId, $butterId, 0.010); // 10 gram Butter

        // RESEP 10: Butter Croissant (Jual: 15k, HPP ~5.000)
        // Karena ini dibeli sudah jadi, anggap HPP adalah Harga Beli Roti Tawar yang sudah dikonversi
        $this->createRecipe($menuCroissantId, $rotiId, 1.000); // 1 Pcs Roti (Proxy untuk 1 pcs Croissant)

        echo "Recipes (HPP definitions) created successfully for 10 menu items.\n";
    }

    protected function createRecipe($menuId, $ingredientId, $quantity)
    {
        if ($menuId && $ingredientId) {
            Recipe::create([
                'menu_product_id' => $menuId,
                'ingredient_product_id' => $ingredientId,
                'quantity_used' => $quantity,
            ]);
        }
    }
}