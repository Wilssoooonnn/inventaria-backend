<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LocationSeeder::class,
            UserSeeder::class,
            UnitSeeder::class,
            CategorySeeder::class,

            ProductSeeder::class,
            RecipeSeeder::class,
            StockSeeder::class,

            SaleSeeder::class,
            SaleItemSeeder::class,
        ]);
    }
}