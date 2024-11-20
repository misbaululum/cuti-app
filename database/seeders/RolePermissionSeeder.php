<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'read konfigurasi'])->assignRole(['hrd']);
        Permission::create(['name' => 'read users'])->assignRole(['hrd']);
        Permission::create(['name' => 'read divisi'])->assignRole(['hrd']);
        Permission::create(['name' => 'read hari-libur'])->assignRole(['hrd']);
        Permission::create(['name' => 'update hari-libur'])->assignRole(['hrd']);
        Permission::create(['name' => 'read cuti-tahunan'])->assignRole(['hrd']);
        Permission::create(['name' => 'read setup-aplikasi'])->assignRole(['hrd']);
        Permission::create(['name' => 'read laporan'])->assignRole(['hrd']);
        Permission::create(['name' => 'read laporan/cuti'])->assignRole(['hrd']);
        Permission::create(['name' => 'read laporan/izin'])->assignRole(['hrd']);
    }
}
