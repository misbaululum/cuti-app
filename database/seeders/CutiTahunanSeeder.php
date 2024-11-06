<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CutiTahunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
           $user->cutiTahunan()->create([
               'tahun' => date('Y'),
               'total' => 12
           ]); 
        });
    }
}
