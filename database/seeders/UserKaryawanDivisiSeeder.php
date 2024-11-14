<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserKaryawanDivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $it = Divisi::create([
            'nama' => 'it',
            'active' => 1
        ]);
        $finance = Divisi::create([
            'nama' => 'finance',
            'active' => 1
        ]);
        $kabag_finance = User::factory()->create([
            'nama' => 'kabag_finance',
            'email' => 'kabag_finance@example.com',
        ]);

        $kabag_finance->karyawan()->create([
            'nama' => $kabag_finance->nama,
            'divisi_id' => $finance->id,
            'nama_divisi' => $finance->nama,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => now(),
            'jenis_kelamin' => 'L',
        ]);

        $staff_finance = User::factory()->create([
            'nama' => 'staff_finance',
            'email' => 'staff_finance@example.com',
        ]);

        $staff_finance->karyawan()->create([
            'nama' => $staff_finance->nama,
            'divisi_id' => $finance->id,
            'nama_divisi' => $finance->nama,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => now(),
            'jenis_kelamin' => 'L',
        ]);

        $staff_finance->atasan()->attach([
            $kabag_finance->id => ['level' => 1],
        ]);
        
        $hrd = Divisi::create([
            'nama' => 'hrd',
            'active' => 1
        ]);

        Role::create(['name' => 'hrd']);

        $staff_it = User::factory()->create([
            'nama' => 'staff_it',
            'email' => 'staff_it@example.com',
        ]);

        $supervisor_it = User::factory()->create([
            'nama' => 'supervisor_it',
            'email' => 'supervisor_it@example.com',
        ]);

        $supervisor_it->karyawan()->create([
            'nama' => $supervisor_it->nama,
            'divisi_id' => $it->id,
            'nama_divisi' => $it->nama,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => now(),
            'jenis_kelamin' => 'L',
        ]);

        $kabag_it = User::factory()->create([
            'nama' => 'kabag_it',
            'email' => 'kabag_it@example.com',
        ]);

        $kabag_it->karyawan()->create([
            'nama' => $kabag_it->nama,
            'divisi_id' => $it->id,
            'nama_divisi' => $it->nama,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => now(),
            'jenis_kelamin' => 'L',
        ]);

        $staff_it->atasan()->attach([
            $supervisor_it->id => ['level' => '1'],
            $kabag_it->id => ['level' => '2'],
        ]);
        
        $staff_it->karyawan()->create([
            'nama' => $staff_it->nama,
            'divisi_id' => $it->id,
            'nama_divisi' => $it->nama,
            'status_karyawan' => 'tetap',
            'tanggal_masuk' => now(),
            'jenis_kelamin' => 'L',
        ]);

        $userHrd = User::factory()->create([
            'nama' => 'hrd',
            'email' => 'hrd@example.com',
        ])->assignRole('hrd');

        $userHrd->karyawan()->create([
           'nama' => $userHrd->nama,
           'divisi_id' => $hrd->id,
           'nama_divisi' => $hrd->nama,
           'status_karyawan' => 'tetap',
           'tanggal_masuk' => now(),
           'jenis_kelamin' => 'L', 
        ]);
    }
}
