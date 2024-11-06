<?php

namespace Database\Seeders;

use App\Models\HariLibur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HariLiburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HariLibur::insert([
           ['tanggal_awal' => now()->addDays(8), 'tanggal_akhir' => now()->addDays(8), 'nama' => 'Hari Raya 1'],
           ['tanggal_awal' => now()->addDays(10), 'tanggal_akhir' => now()->addDays(11), 'nama' => 'Hari Raya 2'],
           ['tanggal_awal' => now()->addDays(14), 'tanggal_akhir' => now()->addDays(14), 'nama' => 'Hari Raya 3'], 
        ]);
    }
}
