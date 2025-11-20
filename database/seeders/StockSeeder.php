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
        // Ambil semua produk yang bertipe 'ingredient'
        $ingredients = Product::where('type', 'ingredient')->get();
        // Ambil lokasi utama (Asumsi LocationSeeder sudah jalan)
        $location = Location::where('name', 'Gudang Utama')->first();

        if ($location) {
            foreach ($ingredients as $ingredient) {
                // Hapus stok lama (jika ada)
                Stock::where('product_id', $ingredient->id)->delete();

                // Isi stok awal (Quantity random, desimal 4 digit)
                Stock::create([
                    'product_id' => $ingredient->id,
                    'location_id' => $location->id,
                    // Stok awal yang cukup untuk diuji (misal: 10 kg, 20 liter)
                    'quantity' => $ingredient->name === 'Biji Kopi Arabika' ? 10.0000 : 20.0000
                ]);
            }
        }
    }
}