<?php

namespace Database\Seeders;

use App\Models\SettingSistem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SettingSistem::create([
            'nama_sekolah' => 'SMPN 2 Saronggi',
            'semester_aktif' => 'Genap',
            'tahun_ajaran_aktif' => '2025/2026',
        ]);
    }
}
