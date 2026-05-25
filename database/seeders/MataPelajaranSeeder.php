<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mata_pelajaran')->insert([
            // KELAS 7
            [
                'kode_mapel' => 'MTK-7',
                'nama_mata_pelajaran' => 'Matematika Kelas 7',
            ],
            [
                'kode_mapel' => 'BIN-7',
                'nama_mata_pelajaran' => 'Bahasa Indonesia Kelas 7',
            ],
            [
                'kode_mapel' => 'BIG-7',
                'nama_mata_pelajaran' => 'Bahasa Inggris Kelas 7',
            ],
            [
                'kode_mapel' => 'IPA-7',
                'nama_mata_pelajaran' => 'Ilmu Pengetahuan Alam Kelas 7',
            ],
            [
                'kode_mapel' => 'IPS-7',
                'nama_mata_pelajaran' => 'Ilmu Pengetahuan Sosial Kelas 7',
            ],
            [
                'kode_mapel' => 'PAI-7',
                'nama_mata_pelajaran' => 'Pendidikan Agama Islam Kelas 7',
            ],
            [
                'kode_mapel' => 'PJOK-7',
                'nama_mata_pelajaran' => 'Pendidikan Jasmani Kelas 7',
            ],
            [
                'kode_mapel' => 'PKN-7',
                'nama_mata_pelajaran' => 'Pendidikan Kewarganegaraan Kelas 7',
            ],
            [
                'kode_mapel' => 'SENI-7',
                'nama_mata_pelajaran' => 'Seni Budaya Kelas 7',
            ],
            [
                'kode_mapel' => 'TIK-7',
                'nama_mata_pelajaran' => 'Teknologi Informasi Kelas 7',
            ],

            // KELAS 8
            [
                'kode_mapel' => 'MTK-8',
                'nama_mata_pelajaran' => 'Matematika Kelas 8',
            ],
            [
                'kode_mapel' => 'BIN-8',
                'nama_mata_pelajaran' => 'Bahasa Indonesia Kelas 8',
            ],
            [
                'kode_mapel' => 'BIG-8',
                'nama_mata_pelajaran' => 'Bahasa Inggris Kelas 8',
            ],
            [
                'kode_mapel' => 'IPA-8',
                'nama_mata_pelajaran' => 'Ilmu Pengetahuan Alam Kelas 8',
            ],
            [
                'kode_mapel' => 'IPS-8',
                'nama_mata_pelajaran' => 'Ilmu Pengetahuan Sosial Kelas 8',
            ],
            [
                'kode_mapel' => 'PAI-8',
                'nama_mata_pelajaran' => 'Pendidikan Agama Islam Kelas 8',
            ],
            [
                'kode_mapel' => 'PJOK-8',
                'nama_mata_pelajaran' => 'Pendidikan Jasmani Kelas 8',
            ],
            [
                'kode_mapel' => 'PKN-8',
                'nama_mata_pelajaran' => 'Pendidikan Kewarganegaraan Kelas 8',
            ],

            // KELAS 9
            [
                'kode_mapel' => 'MTK-9',
                'nama_mata_pelajaran' => 'Matematika Kelas 9',
            ],
            [
                'kode_mapel' => 'BIN-9',
                'nama_mata_pelajaran' => 'Bahasa Indonesia Kelas 9',
            ],
            [
                'kode_mapel' => 'BIG-9',
                'nama_mata_pelajaran' => 'Bahasa Inggris Kelas 9',
            ],
            [
                'kode_mapel' => 'IPA-9',
                'nama_mata_pelajaran' => 'Ilmu Pengetahuan Alam Kelas 9',
            ],
            [
                'kode_mapel' => 'IPS-9',
                'nama_mata_pelajaran' => 'Ilmu Pengetahuan Sosial Kelas 9',
            ],
            [
                'kode_mapel' => 'PAI-9',
                'nama_mata_pelajaran' => 'Pendidikan Agama Islam Kelas 9',
            ],
            [
                'kode_mapel' => 'PJOK-9',
                'nama_mata_pelajaran' => 'Pendidikan Jasmani Kelas 9',
            ],
            [
                'kode_mapel' => 'PKN-9',
                'nama_mata_pelajaran' => 'Pendidikan Kewarganegaraan Kelas 9',
            ],
        ]);
    }
}
