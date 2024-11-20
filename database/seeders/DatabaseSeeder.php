<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserKaryawanDivisiSeeder::class,
            CutiTahunanSeeder::class,
            RolePermissionSeeder::class,
            SetupAplikasiSeeder::class,
            HariLiburSeeder::class,
        ]);
        
    }
}
