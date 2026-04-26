<?php

namespace App\Imports;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrangTuaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $nama = trim($row['nama_orang_tua']);

        // 🔍 cek apakah sudah ada
        $ortu = OrangTua::whereRaw('LOWER(nama_orang_tua) = ?', [strtolower($nama)])->first();

        if ($ortu) {
            return null; // ❌ skip jika sudah ada
        }

        // 🔥 buat user
        $user = User::create([
            'name' => $nama,
            'email' => strtolower(str_replace(' ', '', $nama)) . rand(100, 999) . '@ortu.com',
            'password' => Hash::make('12345678'),
            'role' => 'orang_tua',
        ]);

        // 🔥 buat orang tua
        return new OrangTua([
            'nama_orang_tua' => $nama,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'alamat' => $row['alamat'] ?? null,
            'id_user' => $user->id,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_orang_tua' => 'required',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
        ];
    }
}
