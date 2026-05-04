<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::pluck('nama_kelas', 'id_kelas');

        // 🔥 ROLE HANDLING
        if (Auth::user()->role == 'guru') {
            $selectedKelas = optional(Auth::user()->guru->kelas)->id_kelas;
        } elseif (Auth::user()->role == 'orang_tua') {
            $anak = optional(Auth::user()->orangTua->siswa);
            $selectedKelas = $anak->id_kelas ?? null;
        } else {
            $selectedKelas = $request->kelas ?? $kelasList->keys()->first();
        }

        $selectedBulan = $request->bulan ?? date('m');
        $selectedTahun = $request->tahun ?? date('Y');

        $namaBulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $jumlahHari = Carbon::create($selectedTahun, $selectedBulan)->daysInMonth;

        // 🔥 AMBIL SISWA SESUAI ROLE
        if (Auth::user()->role == 'orang_tua') {
            $anak = optional(Auth::user()->orangTua->siswa);
            $siswaList = $anak ? collect([$anak]) : collect();
        } else {
            $siswaList = Siswa::where('id_kelas', $selectedKelas)->get();
        }

        // 🔥 AMBIL SEMUA ABSENSI SEKALI (ANTI N+1)
        $absensiAll = Absensi::whereIn('id_siswa', $siswaList->pluck('id_siswa'))->whereMonth('tanggal', $selectedBulan)->whereYear('tanggal', $selectedTahun)->get()->groupBy('id_siswa');

        $rekap = [];
        $totalHadir = $totalIzin = $totalSakit = $totalAlpa = 0;

        foreach ($siswaList as $siswa) {
            $absensi = $absensiAll[$siswa->id_siswa] ?? collect();

            $hadir = $absensi->where('status', 'hadir')->count();
            $izin = $absensi->where('status', 'izin')->count();
            $sakit = $absensi->where('status', 'sakit')->count();
            $alpa = $absensi->where('status', 'alpa')->count();

            $persen = $jumlahHari > 0 ? round(($hadir / $jumlahHari) * 100, 1) : 0;

            $rekap[] = [
                'nis' => $siswa->nis,
                'nama' => $siswa->nama_siswa,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alpa' => $alpa,
                'persen' => $persen,
            ];

            $totalHadir += $hadir;
            $totalIzin += $izin;
            $totalSakit += $sakit;
            $totalAlpa += $alpa;
        }

        $totalSiswa = $siswaList->count();

        $rataPersen = $totalSiswa > 0 && $jumlahHari > 0 ? round(($totalHadir / ($totalSiswa * $jumlahHari)) * 100, 1) : 0;

        return view('Admin.Laporan.index', compact('kelasList', 'selectedKelas', 'selectedBulan', 'selectedTahun', 'namaBulan', 'jumlahHari', 'rekap', 'totalSiswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'rataPersen'));
    }
}
