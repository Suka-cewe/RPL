<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@libzone.com',
            'nip' => '123456789',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Siswa user
        User::create([
            'name' => 'Siswa 1',
            'email' => 'siswa@libzone.com',
            'username' => 'siswa1',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
            'nomor_induk_siswa' => '123456',
        ]);
    }
}
