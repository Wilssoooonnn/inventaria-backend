<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Location;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil semua produk yang bertipe 'ingredient'
        $ingredients = Product::where('type', 'ingredient')->get();

        // 2. Ambil lokasi utama (Asumsi LocationSeeder sudah dijalankan)
        $location = Location::where('name', 'Gudang Utama')->first();

        if ($location) {
            foreach ($ingredients as $ingredient) {
                // Hapus stok lama di lokasi ini (jika ada)
                Stock::where('product_id', $ingredient->id)
                    ->where('location_id', $location->id)
                    ->delete();

                // Tentukan kuantitas stok awal yang besar dan spesifik
                $initialQuantity = $this->getInitialStockQuantity($ingredient->name);

                // Isi stok awal (Quantity menggunakan presisi desimal 4 digit)
                Stock::create([
                    'product_id' => $ingredient->id,
                    'location_id' => $location->id,
                    'quantity' => $initialQuantity, // Kuatitas awal yang besar
                ]);
            }
            echo "Initial stock created successfully for all 8 ingredients.\n";
        } else {
            echo "Skipping StockSeeder: Location 'Gudang Utama' not found.\n";
        }
    }

    /**
     * Helper untuk menentukan kuantitas stok awal berdasarkan nama bahan baku.
     */
    private function getInitialStockQuantity(string $name): float
    {
        // Berikan stok yang cukup besar (misal: 100x porsi jual)
        return match ($name) {
            'Biji Kopi Arabika House Blend' => 20.0000, // 20 kg
            'Susu UHT Full Cream' => 50.0000,          // 50 liter
            'Sirup Vanila Premium' => 10.0000,         // 10 liter
            'Cokelat Bubuk Murni' => 15.0000,          // 15 kg
            'Teh Hijau Matcha Powder' => 10.0000,      // 10 kg
            'Roti Tawar Tebal' => 500.0000,            // 500 lembar
            'Keju Mozzarella Curah' => 10.0000,        // 10 kg
            'Butter/Margarine' => 5.0000,              // 5 kg
            default => 50.0000,                        // Default kuantitas
        };
    }
}