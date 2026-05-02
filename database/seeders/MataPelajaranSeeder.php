<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataPelajaran = [
            ['nama_mata_pelajaran' => 'Matematika'],
            ['nama_mata_pelajaran' => 'Bahasa Indonesia'],
            ['nama_mata_pelajaran' => 'Bahasa Inggris'],
            ['nama_mata_pelajaran' => 'Ilmu Pengetahuan Alam'],
            ['nama_mata_pelajaran' => 'Ilmu Pengetahuan Sosial'],
            ['nama_mata_pelajaran' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['nama_mata_pelajaran' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan'],
            ['nama_mata_pelajaran' => 'Seni Budaya dan Prakarya'],
        ];

        foreach ($mataPelajaran as $mapel) {
            \App\Models\MataPelajaran::create($mapel);
        }
    }
}
