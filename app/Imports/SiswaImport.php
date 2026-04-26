<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // 🔥 HANDLE KELAS
        $namaKelas = trim($row['kelas']);
        $kelas = Kelas::whereRaw('LOWER(nama_kelas) = ?', [strtolower($namaKelas)])->first();

        if (!$kelas) {
            return null;
        }

        // 🔥 HANDLE ORANG TUA
        $idOrtu = null;

        if (!empty($row['nama_orang_tua'])) {
            $namaOrtu = trim($row['nama_orang_tua']);

            // cek apakah sudah ada
            $ortu = OrangTua::whereRaw('LOWER(nama_orang_tua) = ?', [strtolower($namaOrtu)])->first();

            if (!$ortu) {
                // 🔥 buat akun user
                $user = User::create([
                    'name' => $namaOrtu,
                    'email' => strtolower(str_replace(' ', '', $namaOrtu)) . rand(100, 999) . '@ortu.com',
                    'password' => Hash::make('12345678'),
                    'role' => 'orang_tua',
                ]);

                // 🔥 buat data orang tua
                $ortu = OrangTua::create([
                    'nama_orang_tua' => $namaOrtu,
                    'id_user' => $user->id,
                ]);
            }

            $idOrtu = $ortu->id_orang_tua;
        }

        // 🔥 SIMPAN SISWA
        return new Siswa([
            'nisn' => $row['nisn'],
            'nis' => $row['nis'],
            'nama_siswa' => $row['nama_siswa'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'alamat' => $row['alamat'] ?? null,
            'status' => $row['status'] ?? 'aktif',
            'id_kelas' => $kelas->id_kelas,
            'id_orang_tua' => $idOrtu,
        ]);
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required|unique:siswa,nisn',
            'nis' => 'required|unique:siswa,nis',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas' => 'required',
            'nama_orang_tua' => 'nullable',
        ];
    }
}
