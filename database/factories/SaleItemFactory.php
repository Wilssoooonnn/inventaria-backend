<?php

namespace Database\Factories;

use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleItemFactory extends Factory
{
    protected $model = SaleItem::class;

    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 5);
        $price = $this->faker->numberBetween(10000, 25000);

        return [
            'sale_id' => SaleFactory::new(),
            'product_id' => ProductFactory::new()->menu(), // Pastikan hanya Menu yang dijual
            'quantity' => $qty,
            'price_at_sale' => $price,
            'subtotal' => $qty * $price,
        ];
    }
}