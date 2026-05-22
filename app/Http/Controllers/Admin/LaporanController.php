<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\PertemuanPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Exports\LaporanExport;
use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::pluck('nama_kelas', 'id_kelas');

        // DEFAULT
        $mapelList = collect();

        // ROLE HANDLING
        if (Auth::user()->role == 'guru' && Auth::user()->guru) {
            $guru = Auth::user()->guru;

            // AMBIL SEMUA JADWAL GURU
            $jadwalGuru = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
                ->where('id_guru', $guru->id_guru)
                ->get();

            // AMBIL ID KELAS DARI JADWAL
            $idKelasJadwal = $jadwalGuru->pluck('id_kelas')->toArray();

            // AMBIL ID KELAS WALI KELAS
            $idKelasWali = Kelas::where('id_guru', $guru->id_guru)->pluck('id_kelas')->toArray();

            // GABUNG SEMUA ID KELAS
            $semuaIdKelas = array_unique(array_merge($idKelasJadwal, $idKelasWali));

            // AMBIL DATA KELAS
            $kelasList = Kelas::whereIn('id_kelas', $semuaIdKelas)->pluck('nama_kelas', 'id_kelas');

            // PILIH KELAS
            $selectedKelas = $request->kelas ?? $kelasList->keys()->first();

            // MAPEL GURU
            $mapelList = $jadwalGuru->pluck('mataPelajaran')->filter()->unique('id_mata_pelajaran')->values();
        } elseif (Auth::user()->role == 'orang_tua') {
            $anak = Siswa::where('id_user', Auth::user()->id_user)->first();

            $selectedKelas = $anak?->id_kelas;
        } else {
            // ADMIN
            $selectedKelas = $request->kelas ?? $kelasList->keys()->first();
        }

        // FILTER
        $selectedBulan = $request->bulan ?? date('m');
        $selectedTahun = $request->tahun ?? date('Y');
        $selectedMapel = $request->mapel;

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

        // SISWA / ORANG TUA
        if (Auth::user()->role == 'orang_tua') {
            $anak = Siswa::where('id_user', Auth::user()->id_user)->first();

            $siswaList = $anak ? collect([$anak]) : collect();
        } else {
            $siswaList = Siswa::where('id_kelas', $selectedKelas)->get();
        }

        // QUERY ABSENSI
        $pertemuanIds = PertemuanPelajaran::whereMonth('tanggal', $selectedBulan)->whereYear('tanggal', $selectedTahun)->pluck('id_pertemuan');

        $absensiQuery = Absensi::with(['pertemuan.jadwalPelajaran'])
            ->whereIn('id_siswa', $siswaList->pluck('id_siswa'))
            ->whereIn('id_pertemuan', $pertemuanIds);

        // FILTER MAPEL KHUSUS GURU
        if (Auth::user()->role == 'guru' && $selectedMapel) {
            $absensiQuery->whereHas('pertemuan.jadwalPelajaran', function ($q) use ($selectedMapel) {
                $q->where('id_mata_pelajaran', $selectedMapel);
            });
        }

        $absensiAll = $absensiQuery->get()->groupBy('id_siswa');

        // REKAP
        $rekap = [];

        $totalHadir = 0;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpa = 0;

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

        // PAGINATION
        $page = request()->get('page', 1);

        $perPage = 10;

        $rekap = new LengthAwarePaginator(collect($rekap)->forPage($page, $perPage), count($rekap), $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        // TOTAL
        $totalSiswa = $siswaList->count();
        $rataPersen = $totalSiswa > 0 && $jumlahHari > 0 ? round(($totalHadir / ($totalSiswa * $jumlahHari)) * 100, 1) : 0;
        return view('Admin.Laporan.index', compact('mapelList', 'kelasList', 'selectedKelas', 'selectedBulan', 'selectedTahun', 'selectedMapel', 'namaBulan', 'jumlahHari', 'rekap', 'totalSiswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpa', 'rataPersen'));
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getLaporanData($request);

        // ambil kelas + relasi guru
        $kelas = Kelas::with('guru')->find($data['selectedKelas']);
        $bulan = $data['namaBulan'][$data['selectedBulan']] ?? '-';
        $tahun = $data['selectedTahun'];
        return Excel::download(new LaporanExport($data['rekap'], $kelas, $bulan, $tahun), 'laporan-kehadiran.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getLaporanData($request);

        // AMBIL DATA KELAS + WALI KELAS
        $kelas = Kelas::with('guru')->find($data['selectedKelas']);

        $pdf = Pdf::loadView('Admin.Laporan.pdf', [
            // DATA TABEL
            'rekap' => $data['rekap'],

            // DATA KELAS
            'kelas' => $kelas,

            // FILTER
            'selectedBulan' => $data['selectedBulan'],
            'selectedTahun' => $data['selectedTahun'],

            // NAMA BULAN
            'namaBulan' => $data['namaBulan'],
        ]);
        return $pdf->download('laporan-kehadiran.pdf');
    }

    private function getLaporanData($request)
    {
        $kelasList = Kelas::pluck('nama_kelas', 'id_kelas');

        // ROLE
        if (Auth::user()->role == 'guru' && Auth::user()->guru) {
            $guru = Auth::user()->guru;
            $jadwalGuru = JadwalPelajaran::where('id_guru', $guru->id_guru)->get();
            $idKelasJadwal = $jadwalGuru->pluck('id_kelas')->toArray();
            $idKelasWali = Kelas::where('id_guru', $guru->id_guru)->pluck('id_kelas')->toArray();
            $semuaIdKelas = array_unique(array_merge($idKelasJadwal, $idKelasWali));
            $selectedKelas = $request->kelas ?? ($semuaIdKelas[0] ?? null);
        } elseif (Auth::user()->role == 'orang_tua') {
            $anak = Siswa::where('id_user', Auth::user()->id_user)->first();

            $selectedKelas = $anak?->id_kelas;
        } else {
            $selectedKelas = $request->kelas ?? $kelasList->keys()->first();
        }

        // FILTER
        $selectedBulan = $request->bulan ?? date('m');
        $selectedTahun = $request->tahun ?? date('Y');
        $selectedMapel = $request->mapel;

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

        // SISWA / ORANG TUA
        if (Auth::user()->role == 'orang_tua') {
            $anak = Siswa::where('id_user', Auth::user()->id_user)->first();

            $siswaList = $anak ? collect([$anak]) : collect();
        } else {
            $siswaList = Siswa::where('id_kelas', $selectedKelas)->get();
        }

        // QUERY ABSENSI
        $pertemuanIds = PertemuanPelajaran::whereMonth('tanggal', $selectedBulan)->whereYear('tanggal', $selectedTahun)->pluck('id_pertemuan');

        $absensiQuery = Absensi::with(['pertemuan.jadwalPelajaran'])
            ->whereIn('id_siswa', $siswaList->pluck('id_siswa'))
            ->whereIn('id_pertemuan', $pertemuanIds);

        // FILTER MAPEL KHUSUS GURU
        if (Auth::user()->role == 'guru' && $selectedMapel) {
            $absensiQuery->whereHas('pertemuan.jadwalPelajaran', function ($q) use ($selectedMapel) {
                $q->where('id_mata_pelajaran', $selectedMapel);
            });
        }

        $absensiAll = $absensiQuery->get()->groupBy('id_siswa');

        // REKAP
        $rekap = [];

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
        }

        return [
            'rekap' => $rekap,
            'selectedKelas' => $selectedKelas,
            'selectedBulan' => $selectedBulan,
            'selectedTahun' => $selectedTahun,
            'namaBulan' => $namaBulan,
        ];
    }
}
