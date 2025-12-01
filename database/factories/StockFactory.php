<?php
// database/factories/StockFactory.php (Setelah Perbaikan)

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Product; // Pastikan ini di-import
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        // PENTING: Gunakan Product::factory() untuk mendapatkan ID yang valid.
        // Asumsi Model/Factory Product sudah memiliki state 'ingredient()'.
        return [
            // Gunakan callables untuk memastikan Product/Location dibuat
            'product_id' => Product::factory()->ingredient(),
            'location_id' => LocationFactory::new(),
            // Quantity harus desimal (4 digit presisi) untuk F&B
            'quantity' => $this->faker->randomFloat(4, 100, 10000),
        ];
    }
}