<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * Nama model yang sesuai dengan factory ini.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Definisikan state default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Ambil Menu Item secara acak (Product dengan type 'menu')
        // Pastikan Anda memiliki setidaknya satu Menu item dan satu Ingredient yang sudah ada di database,
        // atau gunakan ProductFactory::new()->menu() dan ProductFactory::new()->ingredient().

        // Contoh implementasi menggunakan Factory states:
        $menuProduct = ProductFactory::new()->menu()->create();
        $ingredientProduct = ProductFactory::new()->ingredient()->create();

        return [
            // Menu: Product yang dijual dan membutuhkan resep.
            'menu_product_id' => $menuProduct->id,

            // Ingredient: Product yang digunakan sebagai bahan baku.
            'ingredient_product_id' => $ingredientProduct->id,

            // Quantity Used: Jumlah bahan baku (dengan presisi desimal 4 digit) yang dibutuhkan 
            // untuk membuat SATU porsi Menu.
            'quantity_used' => $this->faker->randomFloat(4, 0.0050, 0.5000),
        ];
    }

    /**
     * State untuk mengikat Resep ke Menu spesifik.
     * * @param \App\Models\Product $menu
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forMenu(Product $menu)
    {
        return $this->state(fn(array $attributes) => [
            'menu_product_id' => $menu->id,
        ]);
    }

    /**
     * State untuk mengikat Resep ke Ingredient spesifik.
     * * @param \App\Models\Product $ingredient
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function usesIngredient(Product $ingredient)
    {
        return $this->state(fn(array $attributes) => [
            'ingredient_product_id' => $ingredient->id,
        ]);
    }
}