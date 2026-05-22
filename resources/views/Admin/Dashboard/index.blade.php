@extends('Layouts.template-admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400">Dashboard</li>
        <li class="breadcrumb-item f-w-400 active">Default</li>
    </ol>
@endsection

@section('content')
    @if (Auth::user()->role == 'admin')
        <div class="container-fluid default-dashboard">

            <div class="row g-3">

                {{-- ================= GREETING (KIRI) ================= --}}
                <div class="col-xl-5 col-md-6">
                    <div class="card profile-greeting p-0 h-100">
                        <div class="card-body">
                            <div class="img-overlay">
                                <h1>Hallo, {{ Auth::user()->name }}!</h1>
                                <p>
                                    Selamat datang di Sistem Absensi SMPN 2 Saronggi.<br>
                                    Kelola kehadiran siswa dengan mudah.
                                </p>
                                <a class="btn" href="{{ route('account.index') }}">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= CARD STATISTIK ================= --}}
                <div class="col-xl-7 col-md-6">
                    <div class="row g-4">

                        {{-- Total Siswa --}}
                        <div class="col-6">
                            <div class="card border-0 shadow-sm text-white position-relative overflow-hidden"
                                style="border-radius: 24px; height: 145px; background: linear-gradient(135deg,#2b96ef,#9cccf6); ">

                                <div class="card-body d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <p class="mb-1 fw-medium text-white" style="font-size:15px;">
                                            Total Siswa
                                        </p>

                                        <h1 class="fw-bold mb-0 text-white" style="font-size:40px;">
                                            {{ $totalSiswa }}
                                        </h1>
                                    </div>

                                    <div class="position-absolute"
                                        style="right:-10px; bottom:-20px; font-size:90px; opacity:.15; ">
                                        👨‍🎓
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Guru --}}
                        <div class="col-6">
                            <div class="card border-0 shadow-sm text-white position-relative overflow-hidden"
                                style="border-radius: 24px; height: 145px; background: linear-gradient(135deg,#f43591,#fdc389); ">

                                <div class="card-body d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <p class="mb-1 fw-medium text-white" style="font-size:15px;">
                                            Total Guru
                                        </p>

                                        <h1 class="fw-bold mb-0 text-white" style="font-size:40px;">
                                            {{ $totalGuru }}
                                        </h1>
                                    </div>

                                    <div class="position-absolute"
                                        style="right:-10px; bottom:-20px; font-size:90px; opacity:.15; ">
                                        👨‍🏫
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Kelas --}}
                        <div class="col-6">
                            <div class="card border-0 shadow-sm text-white position-relative overflow-hidden"
                                style="border-radius: 24px; height: 145px; background: linear-gradient(135deg,#f6c80e,#f6e09d);">

                                <div class="card-body d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <p class="mb-1 fw-medium text-white" style="font-size:15px;">
                                            Total Kelas
                                        </p>

                                        <h1 class="fw-bold mb-0 text-white" style="font-size:40px;">
                                            {{ $totalKelas }}
                                        </h1>
                                    </div>

                                    <div class="position-absolute"
                                        style="right:-10px; bottom:-20px; font-size:90px; opacity:.15; ">
                                        🏫
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Mata Pelajaran --}}
                        <div class="col-6">
                            <div class="card border-0 shadow-sm text-white position-relative overflow-hidden"
                                style="border-radius: 24px; height: 145px; background: linear-gradient(135deg,#1e9600,#dfff00); ">

                                <div class="card-body d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <p class="mb-1 fw-medium text-white" style="font-size:15px;">
                                            Total Mata Pelajaran
                                        </p>

                                        <h1 class="fw-bold mb-0 text-white" style="font-size:40px;">
                                            {{ $totalMataPelajaran }}
                                        </h1>
                                    </div>

                                    <div class="position-absolute"
                                        style=" right:-10px; bottom:-20px; font-size:90px; opacity:.15; ">
                                        🕒
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= CHART AREA ================= --}}
            <div class="row mt-4 g-3">

                {{-- BAR CHART: Kehadiran per Kelas Hari Ini (11 kelas) --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3">
                        <h5 class="mb-3">Kehadiran per Kelas Hari Ini</h5>
                        <canvas id="barChartKelas" style="width:100%; max-height:350px;"></canvas>
                    </div>
                </div>

                {{-- LINE CHART: Tren Kehadiran Minggu Ini --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 p-3">
                        <h5 class="mb-3">Tren Kehadiran Minggu Ini</h5>
                        <canvas id="lineChartMinggu" style="width:100%; max-height:350px;"></canvas>
                    </div>
                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ========== BAR CHART: 11 KELAS ==========
                const kelas = @json($chartKelas);
                // Data dummy (jumlah kehadiran per status)
                const hadir = @json($hadirData);
                const izin = @json($izinData);
                const sakit = @json($sakitData);
                const alpha = @json($alpaData);

                const ctxBar = document.getElementById('barChartKelas').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: kelas,
                        datasets: [{
                                label: 'Hadir',
                                data: hadir,
                                backgroundColor: '#28a745',
                                borderRadius: 6
                            },
                            {
                                label: 'Izin',
                                data: izin,
                                backgroundColor: '#ffc107',
                                borderRadius: 6
                            },
                            {
                                label: 'Sakit',
                                data: sakit,
                                backgroundColor: '#17a2b8',
                                borderRadius: 6
                            },
                            {
                                label: 'Alpha',
                                data: alpha,
                                backgroundColor: '#dc3545',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Siswa',
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 10
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Kelas',
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });

                // ========== LINE CHART: Tren Kehadiran Minggu Ini ==========
                const hari = @json($hariChart);
                const persen = @json($persenChart);

                const ctxLine = document.getElementById('lineChartMinggu').getContext('2d');
                new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: hari,
                        datasets: [{
                            label: 'Persentase Kehadiran (%)',
                            data: persen,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#0d6efd',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.raw}%`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Persentase (%)',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Hari',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif

    @if (Auth::user()->role == 'guru')
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-5 col-md-6 proorder-xl-1 proorder-md-1">
                    <div class="card profile-greeting p-0">
                        <div class="card-body">
                            <div class="img-overlay">
                                <h1>Hallo, {{ Auth::user()->name }}!</h1>
                                <p>Selamat datang di Sistem Absensi SMPN 2 Saronggi. Kelola kehadiran siswa dengan mudah.
                                </p><a class="btn" href="{{ route('account.index') }}">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: 4 card statistik -->
                <div class="col-xl-7 col-md-6">
                    <div class="row g-3 h-100">
                        <!-- Kelas Hari Ini -->
                        <div class="col-sm-3 col-6 d-flex">
                            <div class="card w-100 text-white bg-primary shadow-sm border-0">
                                <div
                                    class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                    <i data-feather="book-open" class="mb-2" width="40" height="150"></i>
                                    <h2 class="fw-bold display-6 mb-0">
                                        {{ $kelasHariIni }}
                                    </h2>
                                    <h6 class="fw-semibold mt-1">Kelas Hari Ini</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Absensi Selesai -->
                        <div class="col-sm-3 col-6 d-flex">
                            <div class="card w-100 text-white bg-success shadow-sm border-0">
                                <div
                                    class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                    <i data-feather="check-circle" class="mb-2" width="40" height="150"></i>
                                    <h2 class="fw-bold display-6 mb-0">
                                        {{ $absensiSelesai }}
                                    </h2>
                                    <h6 class="fw-semibold mt-1">Absensi Selesai</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Menunggu Absensi -->
                        <div class="col-sm-3 col-6 d-flex">
                            <div class="card w-100 text-white bg-warning shadow-sm border-0">
                                <div
                                    class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                    <i data-feather="clock" class="mb-2" width="40" height="150"></i>
                                    <h2 class="fw-bold display-6 mb-0">
                                        {{ $menungguAbsensi }}
                                    </h2>
                                    <h6 class="fw-semibold mt-1">Menunggu Absensi</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Lihat Laporan -->
                        <div class="col-sm-3 col-6 d-flex">
                            <div class="card w-100 bg-info shadow-sm border-0">
                                <div
                                    class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                    <i data-feather="file-text" class="mb-2 text-white" width="40"
                                        height="155"></i>
                                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-primary mt-2">Lihat
                                        Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris kedua: Jadwal Mengajar Hari Ini -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 fw-semibold fs-4">
                                <i data-feather="calendar" class="me-2" width="25" height="25"></i>
                                Jadwal Mengajar Hari Ini
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse ($jadwalHariIni as $jadwal)
                                    @php
                                        $pertemuanHariIni = \App\Models\PertemuanPelajaran::where(
                                            'id_jadwal_pelajaran',
                                            $jadwal->id_jadwal_pelajaran,
                                        )
                                            ->whereDate('tanggal', now())
                                            ->first();

                                        $sudahAbsen = false;

                                        if ($pertemuanHariIni) {
                                            $sudahAbsen = \App\Models\Absensi::where(
                                                'id_pertemuan',
                                                $pertemuanHariIni->id_pertemuan,
                                            )->exists();
                                        }

                                        $now = now()->format('H:i:s');
                                        $jamMulai = $jadwal->sesi->jam_mulai;
                                        $jamSelesai = $jadwal->sesi->jam_selesai;

                                        if ($sudahAbsen) {
                                            $status = 'Selesai';
                                            $badge = 'success';
                                        } elseif ($now >= $jamMulai && $now <= $jamSelesai) {
                                            $status = 'Berlangsung';
                                            $badge = 'warning text-dark';
                                        } else {
                                            $status = 'Menunggu';
                                            $badge = 'info';
                                        }
                                    @endphp

                                    <div class="list-group-item py-3">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center">

                                            <div class="mb-2 mb-sm-0">

                                                <span class="badge bg-secondary fs-7 me-3">
                                                    {{ \Carbon\Carbon::parse($jadwal->sesi->jam_mulai)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($jadwal->sesi->jam_selesai)->format('H:i') }}
                                                </span>

                                                <span class="fw-bold fs-6">
                                                    {{ $jadwal->mataPelajaran->nama_mata_pelajaran }}
                                                </span>

                                                <span class="text-muted fs-6 ms-2">
                                                    Kelas {{ $jadwal->kelas->nama_kelas }}
                                                </span>

                                            </div>

                                            <span class="badge bg-{{ $badge }} fs-6">
                                                {{ $status }}
                                            </span>

                                        </div>
                                    </div>

                                @empty

                                    <div class="list-group-item py-4 text-center text-muted">
                                        Tidak ada jadwal hari ini
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris ketiga: Absensi Terbaru -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 fw-semibold fs-4">
                                <i data-feather="check-square" class="me-2" width="25" height="25"></i>
                                Absensi Terbaru
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse ($absensiTerbaru as $item)
                                    <div class="list-group-item py-3">

                                        <div class="d-flex flex-wrap justify-content-between align-items-center">

                                            <div class="mb-2 mb-sm-0">

                                                <h6 class="mb-1 fw-bold fs-6">
                                                    Kelas {{ $item['kelas'] }}
                                                </h6>

                                                <small class="text-muted fs-6">
                                                    Waktu: {{ $item['waktu'] }}
                                                </small>

                                            </div>

                                            <div class="text-end">

                                                <span class="badge bg-primary fs-6 px-3 py-2">
                                                    {{ $item['persen'] }}%
                                                </span>

                                                <div class="small text-muted fs-6 mt-1">
                                                    {{ $item['hadir'] }}/{{ $item['total'] }} siswa
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div class="list-group-item py-4 text-center text-muted">
                                        Belum ada absensi hari ini
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role == 'orang_tua')
        <div class="container-fluid default-dashboard">
            <div class="row align-items-stretch">
                <!-- Card Greeting (kiri) -->
                <div class="col-xl-5 col-md-6 mb-4 d-flex">
                    <div class="card profile-greeting w-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h1 class="fw-bold display-8">Hallo, {{ Auth::user()->name }}!</h1>
                                <p class="fs-6 mt-3 text-secondary">Selamat datang di Sistem <br> Absensi SMPN 2
                                    Saronggi.<br>
                                    Pantau kehadiran dan jadwal pelajaran <br> Anda dengan mudah.</p>
                                <a class="btn btn-outline-primary b-r-8" href="{{ route('account.index') }}">View
                                    Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Anak + Tombol Laporan (kanan) -->
                <div class="col-xl-7 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="fw-bold mb-4" style="color: #2c3e50;">
                                <i data-feather="user" class="me-2" width="24" height="24"></i> Profil Siswa
                            </h4>
                            <div class="row mb-2">
                                <div class="col-5 fw-semibold text-dark">Nama Lengkap :</div>
                                <div class="col-7 fw-bold text-dark">
                                    {{ $siswa?->nama_siswa ?? '-' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-semibold text-dark">NIS :</div>
                                <div class="col-7 fw-bold text-dark">
                                    {{ $siswa?->nis ?? '-' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-semibold text-dark">Kelas :</div>
                                <div class="col-7 fw-bold text-dark">
                                    {{ $siswa?->kelas?->nama_kelas ?? '-' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-semibold text-dark">Wali Kelas :</div>
                                <div class="col-7 fw-bold text-dark">
                                    {{ $siswa?->kelas?->waliKelas?->nama_guru ?? '-' }}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-5 fw-semibold text-dark">Total Kehadiran (Bulan Ini) :</div>
                                <div class="col-7 fw-bold text-dark">
                                    {{ $totalHadir }} Hadir,
                                    {{ $totalIzin }} Izin,
                                    {{ $totalSakit }} Sakit,
                                    {{ $totalAlpa }} Alpha
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('laporan.index') }}"
                                    class="btn btn-outline-primary b-r-8 w-100 rounded-pill">
                                    <i data-feather="file-text" class="me-2" width="18" height="18"></i>
                                    Lihat Laporan Kehadiran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Kehadiran -->
            <div class="row mt-1 g-3">
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-success bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="check-circle" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">
                                {{ $totalHadir }} hari
                            </h3>
                            <p class="text-white fs-6">Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-warning bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="file-text" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">
                                {{ $totalIzin }} hari
                            </h3>
                            <p class="text-white fs-6">Izin</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-info bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="thermometer" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">
                                {{ $totalSakit }} hari
                            </h3>
                            <p class="text-white fs-6">Sakit</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-danger bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="x-circle" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">
                                {{ $totalAlpa }} hari
                            </h3>
                            <p class="text-white fs-6">Alpha</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kehadiran Hari Ini -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 fw-semibold fs-4">
                                <i data-feather="calendar" class="me-2" width="20" height="20"></i>
                                Kehadiran Hari Ini
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="kehadiranHariIniContainer" class="list-group list-group-flush">
                                @forelse ($kehadiranHariIni as $item)
                                    @php

                                        $statusClass = match ($item['status']) {
                                            'hadir' => 'text-success fw-bold',
                                            'izin' => 'text-warning fw-bold',
                                            'sakit' => 'text-info fw-bold',
                                            'alpa' => 'text-danger fw-bold',
                                            default => 'text-secondary fw-bold',
                                        };

                                    @endphp

                                    <div class="list-group-item py-3">

                                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                                            <div>

                                                <div class="fw-bold fs-5">
                                                    {{ $item['mapel'] }}
                                                </div>

                                                <div class="text-muted small">
                                                    {{ $item['waktu'] }}
                                                    •
                                                    {{ $item['guru'] }}
                                                </div>

                                            </div>

                                            <div class="{{ $statusClass }}">
                                                {{ ucfirst($item['status']) }}
                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div class="list-group-item py-3 text-center text-muted">
                                        Tidak ada jadwal hari ini.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script></script>

            <!-- Tren Kehadiran Harian (Bar Chart) + Diagram Lingkaran -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 fw-semibold fs-4">
                                <i data-feather="trending-up" class="me-2" width="20" height="20"></i>
                                Tren Kehadiran Harian
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Kolom Bar Chart -->
                                <div class="col-md-7">
                                    <canvas id="barChartKehadiran" style="width:100%; max-height: 300px;"></canvas>
                                </div>
                                <!-- Kolom Diagram Lingkaran (Bulat) -->
                                <div class="col-md-5 text-center">
                                    <canvas id="pieChartPersentase"
                                        style="max-width: 200px; max-height: 200px; margin: 0 auto;"></canvas>
                                    <div class="mt-3">
                                        <span class="badge bg-success me-2">Hadir {{ $persenHadir }}%</span>
                                        <span class="badge bg-warning me-2">Izin {{ $persenIzin }}%</span>
                                        <span class="badge bg-info me-2">Sakit {{ $persenSakit }}%</span>
                                        <span class="badge bg-danger">Alpa {{ $persenAlpa }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // BAR CHART untuk Tren Kehadiran Harian (Grouped Bar)
                const ctxBar = document.getElementById('barChartKehadiran').getContext('2d');
                new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: @json($chartTanggal),
                        datasets: [{
                                label: 'Hadir',
                                data: @json($chartHadir),
                                backgroundColor: '#28a745',
                                borderRadius: 4
                            },
                            {
                                label: 'Izin',
                                data: @json($chartIzin),
                                backgroundColor: '#ffc107',
                                borderRadius: 4
                            },
                            {
                                label: 'Sakit',
                                data: @json($chartSakit),
                                backgroundColor: '#17a2b8',
                                borderRadius: 4
                            },
                            {
                                label: 'Alpa',
                                data: @json($chartAlpa),
                                backgroundColor: '#dc3545',
                                borderRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Siswa',
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });

                // PIE CHART untuk Persentase
                const ctxPie = document.getElementById('pieChartPersentase').getContext('2d');
                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: [
                            'Hadir ({{ $persenHadir }}%)',
                            'Izin ({{ $persenIzin }}%)',
                            'Sakit ({{ $persenSakit }}%)',
                            'Alpha ({{ $persenAlpa }}%)'
                        ],
                        datasets: [{
                            data: [
                                {{ $persenHadir }},
                                {{ $persenIzin }},
                                {{ $persenSakit }},
                                {{ $persenAlpa }}
                            ],
                            backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.label}: ${ctx.raw}%`
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif

@endsection
