<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $units = ['Gram', 'Kilogram', 'Mililiter', 'Liter', 'Pieces', 'Butir'];
        $symbols = ['g', 'kg', 'ml', 'l', 'pcs', 'btr'];
        $index = $this->faker->numberBetween(0, 5);

        return [
            'name' => $units[$index],
            'symbol' => $symbols[$index],
        ];
    }

    // State khusus untuk Unit yang sering digunakan
    public function gram()
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Gram',
            'symbol' => 'g',
        ]);
    }
}