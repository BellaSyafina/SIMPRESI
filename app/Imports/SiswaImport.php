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
        $siswa = Siswa::where('nis', $row['nis'])

            ->orWhere('nisn', $row['nisn'])

            ->first();

        if (!$siswa) {
            $siswa = new Siswa();
        }

        $siswa->nisn = trim($row['nisn']);

        $siswa->nis = trim($row['nis']);

        $siswa->nama_siswa = strtoupper(trim($row['nama_siswa']));

        $siswa->jenis_kelamin = strtoupper(trim($row['jenis_kelamin']));

        $siswa->tempat_lahir = isset($row['tempat_lahir']) ? strtoupper(trim($row['tempat_lahir'])) : null;

        $siswa->tanggal_lahir = isset($row['tanggal_lahir']) ? Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir'])->format('Y-m-d') : null;

        $siswa->agama = isset($row['agama']) ? strtoupper(trim($row['agama'])) : null;

        $siswa->alamat = isset($row['alamat']) ? trim($row['alamat']) : null;

        $siswa->status = $row['status'] ?? 'aktif';

        $siswa->id_kelas = $kelas->id_kelas;

        $siswa->id_user = $user->id;

        // 🔥 ayah
        $siswa->nama_ayah = isset($row['nama_ayah']) ? strtoupper(trim($row['nama_ayah'])) : null;

        $siswa->no_hp_ayah = $row['no_hp_ayah'] ?? null;

        $siswa->pekerjaan_ayah = isset($row['pekerjaan_ayah']) ? strtoupper(trim($row['pekerjaan_ayah'])) : null;

        // 🔥 ibu
        $siswa->nama_ibu = isset($row['nama_ibu']) ? strtoupper(trim($row['nama_ibu'])) : null;

        $siswa->no_hp_ibu = $row['no_hp_ibu'] ?? null;

        $siswa->pekerjaan_ibu = isset($row['pekerjaan_ibu']) ? strtoupper(trim($row['pekerjaan_ibu'])) : null;

        // 🔥 wali
        $siswa->nama_wali = isset($row['nama_wali']) ? strtoupper(trim($row['nama_wali'])) : null;

        $siswa->no_hp_wali = $row['no_hp_wali'] ?? null;

        $siswa->email_wali = $row['email_wali'] ?? null;

        $siswa->pekerjaan_wali = isset($row['pekerjaan_wali']) ? strtoupper(trim($row['pekerjaan_wali'])) : null;

        $siswa->alamat_orang_tua = $row['alamat_orang_tua'] ?? null;

        $siswa->save();

        return $siswa;
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
