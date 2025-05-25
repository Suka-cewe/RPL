<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BukuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukus = [
            [
                'judul_buku' => 'Matematika Kelas 6 SD',
                'penulis' => 'Tim Penyusun',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2022,
                'isbn' => '978-602-241-422-1',
                'kategori' => 'Pelajaran',
                'jumlah_stok' => 10,
                'lokasi_rak' => 'A1-01',
            ],
            [
                'judul_buku' => 'Bahasa Indonesia Kelas 6 SD',
                'penulis' => 'Tim Penyusun',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2022,
                'isbn' => '978-602-241-423-8',
                'kategori' => 'Pelajaran',
                'jumlah_stok' => 8,
                'lokasi_rak' => 'A1-02',
            ],
            [
                'judul_buku' => 'IPA Kelas 6 SD',
                'penulis' => 'Tim Penyusun',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2022,
                'isbn' => '978-602-241-424-5',
                'kategori' => 'Pelajaran',
                'jumlah_stok' => 5,
                'lokasi_rak' => 'A1-03',
            ],
            [
                'judul_buku' => 'Kamus Besar Bahasa Indonesia',
                'penulis' => 'Pusat Bahasa',
                'penerbit' => 'Balai Pustaka',
                'tahun_terbit' => 2020,
                'isbn' => '978-979-407-999-3',
                'kategori' => 'Referensi',
                'jumlah_stok' => 3,
                'lokasi_rak' => 'B1-01',
            ],
            [
                'judul_buku' => 'Petualangan Si Kancil',
                'penulis' => 'Dian K',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2019,
                'isbn' => '978-602-06-3123-1',
                'kategori' => 'Cerita Anak',
                'jumlah_stok' => 12,
                'lokasi_rak' => 'C1-01',
            ],
            [
                'judul_buku' => 'Atlas Dunia',
                'penulis' => 'Tim National Geographic',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2021,
                'isbn' => '978-602-412-777-5',
                'kategori' => 'Referensi',
                'jumlah_stok' => 2,
                'lokasi_rak' => 'B1-02',
            ],
            [
                'judul_buku' => 'Kisah Nabi dan Rasul',
                'penulis' => 'KH. Muhammad Sanusi',
                'penerbit' => 'Mizan',
                'tahun_terbit' => 2018,
                'isbn' => '978-602-18-1234-5',
                'kategori' => 'Agama',
                'jumlah_stok' => 7,
                'lokasi_rak' => 'D1-01',
            ],
            [
                'judul_buku' => 'Ensiklopedia Sains untuk Anak',
                'penulis' => 'Tim Penyusun',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2020,
                'isbn' => '978-602-241-800-2',
                'kategori' => 'Pelajaran',
                'jumlah_stok' => 5,
                'lokasi_rak' => 'A2-01',
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}
