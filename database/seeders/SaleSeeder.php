<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Dependencies Wajib (Asumsi sudah dibuat di Seeder lain)
        $staffUser = User::where('role', 'staff')->first();
        $location = Location::where('name', 'Kasir Toko')->first();
        $menuItemIds = Product::where('type', 'menu')->pluck('id');

        if ($staffUser === null || $location === null || $menuItemIds->isEmpty()) {
            echo "Skipping SaleSeeder: Dependencies (User, Location, Menu) not found.\n";
            return;
        }

        // 2. Gunakan Factory untuk membuat 15 transaksi (Sales Header)
        Sale::factory()
            ->count(15)
            // PERBAIKAN KRITIS: Tambahkan argument 'items' 
            ->has(
                SaleItem::factory()
                    ->count(rand(2, 4))
                    ->state(function (array $attributes, Sale $sale) use ($menuItemIds) {

                        // Menentukan produk ID untuk SaleItem
                        $productId = $menuItemIds->random();
                        $product = Product::find($productId);

                        // Kalkulasi harga dan subtotal dinamis
                        $qty = rand(1, 3);
                        $price = $product->sale_price;

                        return [
                            'product_id' => $productId,
                            'quantity' => $qty,
                            'price_at_sale' => $price,
                            'subtotal' => $qty * $price,
                        ];
                    }),
                'items' // <-- ARGUMEN KRITIS: Sesuai dengan method relasi di Model Sale.php
            )
            ->create([
                'user_id' => $staffUser->id,
                'location_id' => $location->id,
            ]);

        echo "Sales history created successfully.\n";
    }
}