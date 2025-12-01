<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $isMenu = $this->faker->boolean();

        return [
            'category_id' => CategoryFactory::new(),
            'type' => $isMenu ? 'menu' : 'ingredient',

            // Kolom kondisional
            'unit_id' => $isMenu ? null : UnitFactory::new(), // Hanya ingredient yang punya unit
            'sku' => $isMenu ? null : $this->faker->unique()->uuid(),
            'name' => $this->faker->unique()->words(3, true),

            // Harga
            'sale_price' => $isMenu ? $this->faker->numberBetween(15000, 45000) : 0,
            'purchase_price' => $isMenu ? 0 : $this->faker->numberBetween(50000, 200000),
            'stock_minimum' => $isMenu ? 0 : $this->faker->numberBetween(5, 20),
        ];
    }

    // State eksplisit untuk Menu Item
    public function menu()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'menu',
            'unit_id' => null,
            'purchase_price' => 0,
            'stock_minimum' => 0,
        ]);
    }

    // State eksplisit untuk Bahan Baku
    public function ingredient()
    {
        return $this->state(fn(array $attributes) => [
            'type' => 'ingredient',
            'unit_id' => UnitFactory::new(), // <-- Gunakan Factory::new() (Callable)
            'sale_price' => 0,
        ]);
    }
}