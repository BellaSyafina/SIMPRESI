<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuruImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Guru([
            'nama_guru'     => $row['nama_guru'],
            'nuptk'         => $row['nuptk'] ?? null,
            'nip'           => $row['nip'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'jabatan'       => $row['jabatan'] ?? null,
            'alamat'        => $row['alamat'] ?? null,
        ]);
    }

    /**
     * Aturan validasi untuk setiap baris Excel
     */
    public function rules(): array
    {
        return [
            'nama_guru'     => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'nuptk'         => 'nullable|unique:gurus,nuptk',
            'nip'           => 'nullable|unique:gurus,nip',
        ];
    }

    /**
     * Pesan error kustom (opsional)
     */
    public function customValidationMessages()
    {
        return [
            'nama_guru.required' => 'Nama guru wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi (L/P)',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P',
            'nuptk.unique' => 'NUPTK sudah terdaftar',
            'nip.unique' => 'NIP sudah terdaftar',
        ];
    }
}
