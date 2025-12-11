<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        Location::firstOrCreate(['name' => 'Gudang Utama'], [
            'address' => 'Jl. Inventara No. 1, Pusat Stok'
        ]);

        Location::firstOrCreate(['name' => 'Kasir Toko'], [
            'address' => 'Jl. Inventara No. 1, Area Kasir'
        ]);
    }
}