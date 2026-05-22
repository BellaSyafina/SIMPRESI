<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\PertemuanPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiSiswaController extends Controller
{
    public function index(Request $request)
    {
        // 🔥 Guru login
        $guru = Auth::user()->guru;

        // 🔥 Jadwal guru hari ini
        $jadwalGuru = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi'])
            ->where('id_guru', $guru->id_guru)
            ->orderBy('hari')
            ->orderBy('id_sesi')
            ->get();

        // 🔥 Jika belum ada jadwal
        if ($jadwalGuru->isEmpty()) {
            return view('Admin.absensiSiswa.index', [
                'kelasList' => collect(),
                'jadwalList' => collect(),
                'selectedKelas' => null,
                'selectedJadwal' => null,
                'selectedTanggal' => $selectedTanggal,
                'siswa' => collect(),
                'absensi' => collect(),
                'jadwalAktif' => null,
                'totalSiswa' => 0,
                'totalHadir' => 0,
                'totalIzin' => 0,
                'totalSakit' => 0,
                'totalAlpha' => 0,
                'persenHadir' => 0,
            ]);
        }

        // 🔥 Dropdown kelas & mapel
        $kelasList = $jadwalGuru->pluck('kelas.nama_kelas', 'id_kelas');

        // 🔥 Jadwal default pertama
        $jadwalPertama = $jadwalGuru->first();
        $selectedKelas = $request->kelas ?? $jadwalPertama->id_kelas;
        $jadwalList = $jadwalGuru->where('id_kelas', $selectedKelas)->values();
        $selectedJadwal = $request->jadwal;
        $pertemuanList = PertemuanPelajaran::where('id_jadwal_pelajaran', $selectedJadwal)->orderBy('pertemuan_ke')->get();
        $selectedPertemuan = $request->pertemuan ?? optional($pertemuanList->first())->id_pertemuan;

        if (!$selectedJadwal || !$jadwalList->contains('id_jadwal_pelajaran', $selectedJadwal)) {
            $selectedJadwal = optional($jadwalList->first())->id_jadwal_pelajaran;
        }

        // 🔥 Jadwal aktif
        $jadwalAktif = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
            ->where('id_jadwal_pelajaran', $selectedJadwal)
            ->where('id_guru', $guru->id_guru)
            ->first();

        // 🔥 Siswa
        $siswa = Siswa::where('id_kelas', $selectedKelas)->orderBy('nama_siswa')->get();

        // 🔥 Absensi existing
        $absensi = collect();

        if ($selectedPertemuan) {
            $absensi = Absensi::where('id_pertemuan', $selectedPertemuan)->get()->keyBy('id_siswa');
        }

        // 🔥 Statistik
        $totalSiswa = $siswa->count();
        $totalHadir = $absensi->where('status', 'hadir')->count();
        $totalIzin = $absensi->where('status', 'izin')->count();
        $totalSakit = $absensi->where('status', 'sakit')->count();
        $totalAlpha = $absensi->where('status', 'alpa')->count();
        $persenHadir = $totalSiswa > 0 ? round(($totalHadir / $totalSiswa) * 100, 1) : 0;

        return view('Admin.absensiSiswa.index', compact('kelasList', 'jadwalList', 'selectedKelas', 'selectedJadwal', 'selectedTanggal', 'siswa', 'absensi', 'jadwalAktif', 'totalSiswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'persenHadir'));
    }

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
}
