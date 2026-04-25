<?php

namespace App\Imports;

use App\Models\guru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class GuruImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // 🔥 Generate email otomatis (biar unik)
        $email = Str::slug($row['nama_guru']) . rand(100, 999) . '@gmail.com';

        // 🔥 Buat user dulu
        $user = User::create([
            'name' => $row['nama_guru'],
            'email' => $email,
            'password' => Hash::make('password123'), // default password
        ]);

        return new guru([
            'nama_guru' => $row['nama_guru'],
            'nuptk' => $row['nuptk'] ?? null,
            'nip' => $row['nip'] ?? null,
            'jenis_kelamin' => strtoupper($row['jenis_kelamin']),
            'jabatan' => $row['jabatan'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'id_user' => $user->id, // WAJIB
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_guru' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'nuptk' => 'nullable|unique:guru,nuptk',
            'nip' => 'nullable|unique:guru,nip',
        ];
    }

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
