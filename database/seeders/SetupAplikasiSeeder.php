<?php

namespace Database\Seeders;

use App\Models\SetupAplikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SetupAplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SetupAplikasi::create(['hmin_cuti' => 7, 'hari_kerja' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']]);
    }
}
