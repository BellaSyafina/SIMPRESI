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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->format('Y-m-d');

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

                $absensi = Absensi::whereIn('id_siswa', $siswaIds)->whereDate('tanggal', $today)->get();

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

                $totalAbsensi = Absensi::whereDate('tanggal', $date)->count();

                $hadir = Absensi::whereDate('tanggal', $date)->where('status', 'hadir')->count();

                $persen = $totalAbsensi > 0 ? round(($hadir / $totalAbsensi) * 100) : 0;

                $persenChart[] = $persen;
            }

            return view('Admin.Dashboard.index', compact('totalSiswa', 'totalGuru', 'totalKelas', 'totalMataPelajaran', 'chartKelas', 'hadirData', 'izinData', 'sakitData', 'alpaData', 'hariChart', 'persenChart'));
        }

        // Guru
        if (Auth::user()->role == 'guru') {
            $guru = Auth::user()->guru;

            $jadwalHariIni = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
                ->where('id_guru', $guru->id_guru)
                ->whereDate('tanggal', $today)
                ->orderBy('jam_mulai')
                ->get();

            $kelasHariIni = $jadwalHariIni->count();

            $absensiSelesai = 0;

            foreach ($jadwalHariIni as $jadwal) {
                $sudahAbsen = Absensi::where('id_jadwal_pelajaran', $jadwal->id_jadwal_pelajaran)->whereDate('tanggal', $today)->exists();

                if ($sudahAbsen) {
                    $absensiSelesai++;
                }
            }

            $menungguAbsensi = $kelasHariIni - $absensiSelesai;

            // 🔥 Absensi terbaru
            $absensiTerbaru = [];

            foreach ($jadwalHariIni as $jadwal) {
                $totalSiswa = Siswa::where('id_kelas', $jadwal->id_kelas)->count();

                $hadir = Absensi::where('id_jadwal_pelajaran', $jadwal->id_jadwal_pelajaran)->whereDate('tanggal', $today)->where('status', 'hadir')->count();

                if ($totalSiswa > 0) {
                    $absensiTerbaru[] = [
                        'kelas' => $jadwal->kelas->nama_kelas,
                        'waktu' => Carbon::parse($jadwal->jam_mulai)->format('H:i'),
                        'persen' => round(($hadir / $totalSiswa) * 100, 1),
                        'hadir' => $hadir,
                        'total' => $totalSiswa,
                    ];
                }
            }

            return view('Admin.Dashboard.index', compact('jadwalHariIni', 'kelasHariIni', 'absensiSelesai', 'menungguAbsensi', 'absensiTerbaru'));
        }

        // Orang Tua
        if (Auth::user()->role == 'orang_tua') {
            $siswa = Auth::user()->id_siswa ? Siswa::find(Auth::user()->id_siswa) : null;

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
                // 🔥 absensi bulan ini
                $absensi = Absensi::where('id_siswa', $siswa->id_siswa)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->get();

                $totalHadir = $absensi->where('status', 'hadir')->count();

                $totalIzin = $absensi->where('status', 'izin')->count();

                $totalSakit = $absensi->where('status', 'sakit')->count();

                $totalAlpa = $absensi->where('status', 'alpa')->count();

                // 🔥 persentase
                $totalAbsensi = $totalHadir + $totalIzin + $totalSakit + $totalAlpa;

                if ($totalAbsensi > 0) {
                    $persenHadir = round(($totalHadir / $totalAbsensi) * 100);

                    $persenIzin = round(($totalIzin / $totalAbsensi) * 100);

                    $persenSakit = round(($totalSakit / $totalAbsensi) * 100);

                    $persenAlpa = round(($totalAlpa / $totalAbsensi) * 100);
                }

                // 🔥 chart 7 hari
                for ($i = 6; $i >= 0; $i--) {
                    $tanggal = now()->subDays($i);

                    $chartTanggal[] = $tanggal->format('d M');

                    $data = Absensi::where('id_siswa', $siswa->id_siswa)->whereDate('tanggal', $tanggal)->get();

                    $chartHadir[] = $data->where('status', 'hadir')->count();

                    $chartIzin[] = $data->where('status', 'izin')->count();

                    $chartSakit[] = $data->where('status', 'sakit')->count();

                    $chartAlpa[] = $data->where('status', 'alpa')->count();
                }

                // 🔥 jadwal hari ini
                $jadwalHariIni = JadwalPelajaran::with(['mataPelajaran', 'guru'])
                    ->where('id_kelas', $siswa->id_kelas)
                    ->whereDate('tanggal', now())
                    ->orderBy('jam_mulai')
                    ->get();

                foreach ($jadwalHariIni as $jadwal) {
                    $absen = Absensi::where('id_jadwal_pelajaran', $jadwal->id_jadwal_pelajaran)->where('id_siswa', $siswa->id_siswa)->whereDate('tanggal', now())->first();

                    $kehadiranHariIni[] = [
                        'mapel' => $jadwal->mataPelajaran->nama_mata_pelajaran,

                        'waktu' => Carbon::parse($jadwal->jam_mulai)->format('H:i') . ' - ' . Carbon::parse($jadwal->jam_selesai)->format('H:i'),

                        'guru' => $jadwal->guru->nama_guru,

                        'status' => $absen->status ?? 'belum absen',
                    ];
                }
            }

            return view('Admin.Dashboard.index', compact('siswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'kehadiranHariIni', 'chartTanggal', 'chartHadir', 'chartIzin', 'chartSakit', 'chartAlpa', 'persenHadir', 'persenIzin', 'persenSakit', 'persenAlpa'));
        }
    }
}
