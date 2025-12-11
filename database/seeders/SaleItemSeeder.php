<?php

namespace Database\Seeders;

use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data Sale Headers dan Menu Products yang sudah ada
        $sales = Sale::all();
        $menuItems = Product::where('type', 'menu')->get();

        if ($sales->isEmpty() || $menuItems->isEmpty()) {
            echo "Skipping SaleItemSeeder: No sales headers or menu items found.\n";
            return;
        }

        // 2. Buat detail item untuk setiap header penjualan
        foreach ($sales as $sale) {

            // Tentukan berapa banyak item yang akan dijual (misal: 1 hingga 3 item per struk)
            $numberOfItems = rand(1, 3);
            $itemsAlreadyAdded = [];

            for ($i = 0; $i < $numberOfItems; $i++) {

                // Ambil menu item unik secara acak untuk struk ini
                $product = $menuItems->except($itemsAlreadyAdded)->random();
                $itemsAlreadyAdded[] = $product->id;

                $quantity = rand(1, 3);
                $price = $product->sale_price;
                $subtotal = $quantity * $price;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price_at_sale' => $price,
                    'subtotal' => $subtotal,
                ]);
            }
        }

        echo "Sale item details successfully created.\n";
    }
}