<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $mainLocation = Location::where('name', 'Gudang Utama')->first();

        User::firstOrCreate(
            ['email' => 'admin@inventara.com'],
            [
                'name' => 'Admin Sistem Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'location_id' => $mainLocation ? $mainLocation->id : null,
            ]
        );

        User::firstOrCreate(
            ['email' => 'staff@inventara.com'],
            [
                'name' => 'Staff Kasir',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'location_id' => $mainLocation ? $mainLocation->id : null,
            ]
        );
    }
}