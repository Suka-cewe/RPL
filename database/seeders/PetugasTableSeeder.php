<?php

namespace Database\Seeders;

use App\Models\Petugas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user to associate with petugas
        $adminUser = User::where('email', 'admin@libzone.com')->first();

        // Petugas 1
        Petugas::create([
            'nama_petugas' => 'Siti Nurhaliza',
            'jabatan' => 'Kepala Perpustakaan',
            'kontak' => '081234567890',
            'user_id' => $adminUser->id,
        ]);

        // Petugas 2
        Petugas::create([
            'nama_petugas' => 'Ahmad Dhani',
            'jabatan' => 'Staff Perpustakaan',
            'kontak' => '082345678901',
            'user_id' => null,
        ]);
    }
}
