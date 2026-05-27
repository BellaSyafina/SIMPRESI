<?php

namespace App\Imports;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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

        // 🔥 BUAT AKUN USER
        $email = $row['nisn'] . '@siswa.com';

        $tanggalLahir = isset($row['tanggal_lahir']) ? Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('dmY') : '12345678';

        $user = User::firstOrCreate(
            [
                'email' => $email,
            ],

            [
                'name' => $row['nama_siswa'],

                'password' => Hash::make($tanggalLahir),

                'role' => 'orang_tua',
            ],
        );

        // 🔥 SIMPAN SISWA
        return Siswa::updateOrCreate(
            [
                'nisn' => $row['nisn'],
            ],

            [
                // 🔥 biodata siswa
                'nis' => $row['nis'],

                'nama_siswa' => $row['nama_siswa'],

                'jenis_kelamin' => $row['jenis_kelamin'],

                'tempat_lahir' => $row['tempat_lahir'] ?? null,

                'tanggal_lahir' => isset($row['tanggal_lahir']) ? Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('Y-m-d') : null,

                'agama' => $row['agama'] ?? null,

                'alamat' => $row['alamat'] ?? null,

                'status' => $row['status'] ?? 'aktif',

                'id_kelas' => $kelas->id_kelas,

                'id_user' => $user->id,

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
            ],
        );
    }

    public function rules(): array
    {
        return [
            'nisn' => 'required',

            'nis' => 'required',

            'nama_siswa' => 'required',

            'jenis_kelamin' => 'required|in:L,P',

            'kelas' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nisn.required' => 'NISN wajib diisi.',

            'nis.required' => 'NIS wajib diisi.',

            'nama_siswa.required' => 'Nama siswa wajib diisi.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',

            'jenis_kelamin.in' => 'Jenis kelamin hanya boleh L atau P.',

            'kelas.required' => 'Kelas wajib diisi.',
        ];
    }
}
