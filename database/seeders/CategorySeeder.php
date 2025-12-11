<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Minuman Kopi',
            'Minuman Non-Kopi',
            'Bahan Baku Cair',
            'Bahan Baku Kering',
            'Makanan Utama'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category], ['description' => "Kategori untuk {$category}"]);
        }
    }
}