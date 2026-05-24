<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\PertemuanPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiSiswaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'id_pertemuan' => 'required|exists:pertemuan_pelajaran,id_pertemuan',
                    'status' => 'required|array',
                    'status.*' => 'required|in:hadir,izin,sakit,alpa',
                    'keterangan' => 'nullable|array',
                ],
                [
                    'id_pertemuan.required' => 'Pertemuan harus dipilih',
                    'id_pertemuan.exists' => 'Pertemuan tidak valid',

                    'status.required' => 'Data absensi tidak ditemukan',
                    'status.array' => 'Format status tidak valid',

                    'status.*.required' => 'Status absensi wajib diisi',
                    'status.*.in' => 'Status absensi tidak valid',
                ],
            );

            foreach ($request->status as $idSiswa => $status) {
                Absensi::updateOrCreate(
                    [
                        'id_pertemuan' => $request->id_pertemuan,
                        'id_siswa' => $idSiswa,
                    ],

                    [
                        'status' => $status,
                        'keterangan' => $request->keterangan[$idSiswa] ?? null,
                    ],
                );
            }

            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }

    public function jadwalMengajar()
    {
        $guru = Guru::where('id_user', Auth::id())->first();

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $hariIni = 'Senin';

        $jadwalList = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi'])
            ->where('id_guru', $guru->id_guru)
            ->where('hari', $hariIni)
            ->orderBy('id_sesi')
            ->get();

        return view('Admin.absensiSiswa.jadwal', compact('jadwalList'));
    }

    public function formAbsensi($idJadwal, $idPertemuan)
    {
        $guru = Auth::user()->guru;

        // 🔥 Jadwal aktif
        $jadwalAktif = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi'])
            ->where('id_jadwal_pelajaran', $idJadwal)
            ->where('id_guru', $guru->id_guru)
            ->firstOrFail();

        // 🔥 Pertemuan aktif
        $pertemuan = PertemuanPelajaran::where('id_pertemuan', $idPertemuan)->where('id_jadwal_pelajaran', $idJadwal)->firstOrFail();

        // 🔥 Siswa
        $siswa = Siswa::where('id_kelas', $jadwalAktif->id_kelas)->orderBy('nama_siswa')->get();

        // 🔥 Absensi existing
        $absensi = Absensi::where('id_pertemuan', $idPertemuan)->get()->keyBy('id_siswa');

        // 🔥 Statistik
        $totalSiswa = $siswa->count();
        $totalHadir = $absensi->where('status', 'hadir')->count();
        $totalIzin = $absensi->where('status', 'izin')->count();
        $totalSakit = $absensi->where('status', 'sakit')->count();
        $totalAlpha = $absensi->where('status', 'alpa')->count();
        $persenHadir = $totalSiswa > 0 ? round(($totalHadir / $totalSiswa) * 100, 1) : 0;

        return view('Admin.absensiSiswa.form', compact('jadwalAktif', 'pertemuan', 'siswa', 'absensi', 'totalSiswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'persenHadir'));
    }
}
