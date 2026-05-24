<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
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

        // 🔥 SIMPAN SISWA
        return new Siswa([
            // 🔥 biodata siswa
            'nisn' => $row['nisn'],

            'nis' => $row['nis'],

            'nama_siswa' => $row['nama_siswa'],

            'jenis_kelamin' => $row['jenis_kelamin'],

            'tempat_lahir' => $row['tempat_lahir'] ?? null,

            'tanggal_lahir' => isset($row['tanggal_lahir']) ? \Carbon\Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('Y-m-d') : null,

            'agama' => $row['agama'] ?? null,

            'alamat' => $row['alamat'] ?? null,

            'status' => $row['status'] ?? 'aktif',

            'id_kelas' => $kelas->id_kelas,

            // 🔥 data ayah
            'nama_ayah' => $row['nama_ayah'] ?? null,

            'no_hp_ayah' => $row['no_hp_ayah'] ?? null,

            'pekerjaan_ayah' => $row['pekerjaan_ayah'] ?? null,

            // 🔥 data ibu
            'nama_ibu' => $row['nama_ibu'] ?? null,

            'no_hp_ibu' => $row['no_hp_ibu'] ?? null,

            'pekerjaan_ibu' => $row['pekerjaan_ibu'] ?? null,

            // 🔥 data wali
            'nama_wali' => $row['nama_wali'] ?? null,

            'no_hp_wali' => $row['no_hp_wali'] ?? null,

            'email_wali' => $row['email_wali'] ?? null,

            'pekerjaan_wali' => $row['pekerjaan_wali'] ?? null,

            'alamat_orang_tua' => $row['alamat_orang_tua'] ?? null,
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
        ];
    }
}
