<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = ['Minuman Kopi', 'Bahan Baku Kering', 'Makanan Utama', 'Dessert'];

        return [
            'name' => $this->faker->randomElement($categories),
            'description' => $this->faker->sentence(),
        ];
    }
}