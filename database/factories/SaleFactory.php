<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $total = $this->faker->numberBetween(50000, 500000);
        return [
            'user_id' => UserFactory::new(),
            'location_id' => LocationFactory::new(),
            'invoice_number' => 'INV-' . time() . $this->faker->unique()->randomNumber(4),
            'total_amount' => $total,
        ];
    }
}