<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\User;
use App\Models\PertemuanPelajaran;
use App\Models\SettingSistem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');
        $setting = SettingSistem::first();

        // Admin
        if (Auth::user()->role == 'admin') {
            // Statistik
            $totalSiswa = Siswa::count();
            $totalGuru = Guru::count();
            $totalKelas = Kelas::count();
            $totalMataPelajaran = MataPelajaran::count();
            //$totalAkunSiswa = User::where('role', 'siswa')->count();

            // 🔥 Data chart per kelas
            $kelasData = Kelas::all();

            $chartKelas = [];
            $hadirData = [];
            $izinData = [];
            $sakitData = [];
            $alpaData = [];

            foreach ($kelasData as $kelas) {
                $chartKelas[] = $kelas->nama_kelas;
                $siswaIds = Siswa::where('id_kelas', $kelas->id_kelas)->pluck('id_siswa');
                $pertemuanHariIni = PertemuanPelajaran::whereDate('tanggal', $today)->pluck('id_pertemuan');
                $absensi = Absensi::whereIn('id_siswa', $siswaIds)->whereIn('id_pertemuan', $pertemuanHariIni)->get();
                $hadirData[] = $absensi->where('status', 'hadir')->count();
                $izinData[] = $absensi->where('status', 'izin')->count();
                $sakitData[] = $absensi->where('status', 'sakit')->count();
                $alpaData[] = $absensi->where('status', 'alpa')->count();
            }

            // 🔥 Tren minggu ini
            $hariChart = [];
            $persenChart = [];

            for ($i = 0; $i < 6; $i++) {
                $date = Carbon::now()->startOfWeek()->addDays($i);
                $hariChart[] = $date->translatedFormat('D');
                $pertemuanTanggal = PertemuanPelajaran::whereDate('tanggal', $date)->pluck('id_pertemuan');
                $totalAbsensi = Absensi::whereIn('id_pertemuan', $pertemuanTanggal)->count();
                $hadir = Absensi::whereIn('id_pertemuan', $pertemuanTanggal)->where('status', 'hadir')->count();
                $persen = $totalAbsensi > 0 ? round(($hadir / $totalAbsensi) * 100) : 0;
                $persenChart[] = $persen;
            }

            return view('Admin.Dashboard.index', compact('totalSiswa', 'totalGuru', 'totalKelas', 'totalMataPelajaran', 'chartKelas', 'hadirData', 'izinData', 'sakitData', 'alpaData', 'hariChart', 'persenChart', 'setting'));
        }

        // Guru
        if (Auth::user()->role == 'guru') {
            $guru = Auth::user()->guru;
            $hariIni = now()->translatedFormat('l');

            $hariMap = [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu',
            ];

            $jadwalHariIni = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi'])
                ->where('id_guru', $guru->id_guru)
                ->where('hari', $hariMap[now()->format('l')])
                ->orderBy('id_sesi')
                ->get();

            $kelasHariIni = $jadwalHariIni->count();
            $absensiSelesai = 0;

            foreach ($jadwalHariIni as $jadwal) {
                $pertemuanHariIni = PertemuanPelajaran::where('id_jadwal_pelajaran', $jadwal->id_jadwal_pelajaran)->whereDate('tanggal', $today)->first();
                $sudahAbsen = false;

                if ($pertemuanHariIni) {
                    $sudahAbsen = Absensi::where('id_pertemuan', $pertemuanHariIni->id_pertemuan)->exists();
                }

                if ($sudahAbsen) {
                    $absensiSelesai++;
                }
            }

            $menungguAbsensi = $kelasHariIni - $absensiSelesai;

            // 🔥 Absensi terbaru
            $absensiTerbaru = [];

            foreach ($jadwalHariIni as $jadwal) {
                $totalSiswa = Siswa::where('id_kelas', $jadwal->id_kelas)->count();
                $hadir = 0;

                if ($pertemuanHariIni) {
                    $hadir = Absensi::where('id_pertemuan', $pertemuanHariIni->id_pertemuan)->where('status', 'hadir')->count();
                }

                if ($totalSiswa > 0) {
                    $absensiTerbaru[] = [
                        'kelas' => $jadwal->kelas->nama_kelas,
                        'waktu' => $jadwal->sesi ? Carbon::parse($jadwal->sesi->jam_mulai)->format('H:i') : '-',
                        'persen' => round(($hadir / $totalSiswa) * 100, 1),
                        'hadir' => $hadir,
                        'total' => $totalSiswa,
                    ];
                }
            }

            return view('Admin.Dashboard.index', compact('jadwalHariIni', 'kelasHariIni', 'absensiSelesai', 'menungguAbsensi', 'absensiTerbaru', 'setting'));
        }

        // Orang Tua
        if (Auth::user()->role == 'orang_tua') {
            $siswa = Siswa::with(['kelas.waliKelas'])
                ->where('id_user', Auth::id())
                ->first();

            $totalHadir = 0;
            $totalIzin = 0;
            $totalSakit = 0;
            $totalAlpa = 0;

            $kehadiranHariIni = [];

            $chartTanggal = [];
            $chartHadir = [];
            $chartIzin = [];
            $chartSakit = [];
            $chartAlpa = [];

            $persenHadir = 0;
            $persenIzin = 0;
            $persenSakit = 0;
            $persenAlpa = 0;

            if ($siswa) {
                // 🔥 TOTAL KEHADIRAN
                $totalHadir = Absensi::where('id_siswa', $siswa->id_siswa)

                    ->where('status', 'hadir')

                    ->count();

                $totalIzin = Absensi::where('id_siswa', $siswa->id_siswa)

                    ->where('status', 'izin')

                    ->count();

                $totalSakit = Absensi::where('id_siswa', $siswa->id_siswa)

                    ->where('status', 'sakit')

                    ->count();

                $totalAlpa = Absensi::where('id_siswa', $siswa->id_siswa)

                    ->where('status', 'alpa')

                    ->count();
                    
                // 🔥 KEHADIRAN HARI INI
                $absensiHariIni = Absensi::with(['pertemuan.jadwal.mataPelajaran', 'pertemuan.jadwal.guru'])

                    ->where('id_siswa', $siswa->id_siswa)

                    ->whereHas('pertemuan', function ($q) use ($today) {
                        $q->whereDate('tanggal', $today);
                    })

                    ->get();

                foreach ($absensiHariIni as $item) {
                    $kehadiranHariIni[] = [
                        'mapel' => $item->pertemuan?->jadwal?->mataPelajaran?->nama_mata_pelajaran ?? '-',

                        'guru' => $item->pertemuan?->jadwal?->guru?->nama_guru ?? '-',

                        'waktu' => $item->pertemuan?->tanggal ?? '-',

                        'status' => $item->status,
                    ];
                }

                // 🔥 CHART 7 HARI TERAKHIR
                for ($i = 6; $i >= 0; $i--) {
                    $tanggal = Carbon::now()->subDays($i);

                    $chartTanggal[] = $tanggal->format('d M');

                    $absensiTanggal = Absensi::with('pertemuan')

                        ->where('id_siswa', $siswa->id_siswa)

                        ->whereHas('pertemuan', function ($q) use ($tanggal) {
                            $q->whereDate('tanggal', $tanggal);
                        })

                        ->get();

                    $chartHadir[] = $absensiTanggal->where('status', 'hadir')->count();

                    $chartIzin[] = $absensiTanggal->where('status', 'izin')->count();

                    $chartSakit[] = $absensiTanggal->where('status', 'sakit')->count();

                    $chartAlpa[] = $absensiTanggal->where('status', 'alpa')->count();
                }

                // 🔥 PERSENTASE
                $totalSemua = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;

                if ($totalSemua > 0) {
                    $persenHadir = round(($totalHadir / $totalSemua) * 100);

                    $persenIzin = round(($totalIzin / $totalSemua) * 100);

                    $persenSakit = round(($totalSakit / $totalSemua) * 100);

                    $persenAlpa = round(($totalAlpa / $totalSemua) * 100);
                }
            }

            return view('Admin.Dashboard.index', compact('siswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'kehadiranHariIni', 'chartTanggal', 'chartHadir', 'chartIzin', 'chartSakit', 'chartAlpa', 'persenHadir', 'persenIzin', 'persenSakit', 'persenAlpa', 'setting'));
        }
    }
}
