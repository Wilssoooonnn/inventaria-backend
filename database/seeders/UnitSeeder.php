<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Gram', 'symbol' => 'g'],
            ['name' => 'Kilogram', 'symbol' => 'kg'],
            ['name' => 'Mililiter', 'symbol' => 'ml'],
            ['name' => 'Liter', 'symbol' => 'l'],
            ['name' => 'Pieces', 'symbol' => 'pcs'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['name' => $unit['name']], $unit);
        }
    }
}