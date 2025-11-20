<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
                // --- MASTER DATA ---
            LocationSeeder::class,
            UserSeeder::class,
            UnitSeeder::class,
            CategorySeeder::class,

                // --- DATA LOGIC ---
            ProductSeeder::class,
            RecipeSeeder::class,
            StockSeeder::class,
        ]);
    }
}