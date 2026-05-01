@extends('Layouts.template-admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    {{--  <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400">Dashboard</li>
        <li class="breadcrumb-item f-w-400 active">Default</li>
    </ol>  --}}
@endsection

@section('content')
    @if (Auth::user()->role == 'admin')
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-5 col-md-6 proorder-xl-1 proorder-md-1">
                    <div class="card profile-greeting p-0">
                        <div class="card-body">
                            <div class="img-overlay">
                                <h1>Hallo, {{ Auth::user()->name }}!</h1>
                                <p>Selamat datang di Sistem Absensi SMPN 2 Saronggi. Kelola kehadiran siswa dengan mudah.
                                </p><a class="btn" href="#">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                </p><a class="btn" href="#">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: 4 card statistik -->
                <div class="col-xl-7 col-md-6 mb-4">
                    <div class="row g-3 h-100">
                        <!-- Kelas Hari Ini -->
                        <div class="col-sm-3 col-6 d-flex">
                            <div class="card w-100 text-white bg-primary shadow-sm border-0">
                                <div
                                    class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                    <i data-feather="book-open" class="mb-2" width="40" height="150"></i>
                                    <h2 class="fw-bold display-6 mb-0">4</h2>
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
                                    <h2 class="fw-bold display-6 mb-0">2</h2>
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
                                    <h2 class="fw-bold display-6 mb-0">2</h2>
                                    <h6 class="fw-semibold mt-1">Menunggu Absensi</h6>
                                </div>
                            </div>
                        </div>
                        <!-- Lihat Laporan -->
                        <div class="col-sm-3 col-6 d-flex">
                            <div class="card w-100 bg-info shadow-sm border-0">
                                <div
                                    class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                                    <i data-feather="file-text" class="mb-2 text-white" width="40" height="155"></i>
                                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-primary mt-2">Lihat
                                        Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris kedua: Jadwal Mengajar Hari Ini -->
            <div class="row mt-4">
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
                                <!-- item jadwal 1 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-7 me-3">07:30 - 08:30</span>
                                            <span class="fw-bold fs-6">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 7A</span>
                                        </div>
                                        <span class="badge bg-success fs-6">Selesai</span>
                                    </div>
                                </div>
                                <!-- item jadwal 2 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-7 me-3">08:30 - 09:30</span>
                                            <span class="fw-bold fs-6">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 8B</span>
                                        </div>
                                        <span class="badge bg-success fs-6">Selesai</span>
                                    </div>
                                </div>
                                <!-- item jadwal 3 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-7 me-3">09:45 - 10:45</span>
                                            <span class="fw-bold fs-6">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 9A</span>
                                        </div>
                                        <span class="badge bg-warning text-dark fs-6">Berlangsung</span>
                                    </div>
                                </div>
                                <!-- item jadwal 4 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-7 me-3">10:45 - 11:45</span>
                                            <span class="fw-bold fs-6">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 7B</span>
                                        </div>
                                        <span class="badge bg-info fs-6">Menunggu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris ketiga: Absensi Terbaru -->
            <div class="row mt-4">
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
                                <!-- Absensi Kelas 7A -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <h6 class="mb-1 fw-bold fs-6">Kelas 7A</h6>
                                            <small class="text-muted fs-6">Waktu: 08:25</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary fs-6 px-3 py-2">93.8%</span>
                                            <div class="small text-muted fs-6 mt-1">30/32 siswa</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Absensi Kelas 8B -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <h6 class="mb-1 fw-bold fs-6">Kelas 8B</h6>
                                            <small class="text-muted fs-6">Waktu: 09:20</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary fs-6 px-3 py-2">96.9%</span>
                                            <div class="small text-muted fs-6 mt-1">31/32 siswa</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role == 'orang_tua')
        <div class="container-fluid default-dashboard">
            <!-- Baris pertama: Greeting (kiri) dan Data Anak (kanan) -->
            <div class="row align-items-stretch">
                <!-- Card Greeting (kiri) -->
                <div class="col-xl-5 col-md-6 mb-4 d-flex">
                    <div class="card profile-greeting w-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h1 class="fw-bold display-8">Hallo, {{ Auth::user()->name }}!</h1>
                                <p class="fs-6 mt-3 text-secondary">Selamat datang di Sistem <br> Absensi SMPN 2
                                    Saronggi.<br>
                                    Pantau kehadiran putra/putri <br> Anda dengan mudah.</p>
                                <a class="btn btn-outline-primary b-r-8" href="#">View Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Anak + Tombol Laporan (kanan) -->
                <div class="col-xl-7 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0"
                        style="border-left: 5px solid #0d6efd; background-color: #f8f9fc;">
                        <div class="card-body">
                            <h4 class="fw-bold mb-4" style="color: #2c3e50;">
                                <i data-feather="user" class="me-2" width="24" height="24"></i> Profil Anak
                            </h4>
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-semibold">Nama Lengkap :</div>
                                <div class="col-7 fw-bold">Ahmad Zaki</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-semibold">NIS :</div>
                                <div class="col-7 fw-bold">2024080001</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-semibold">Kelas :</div>
                                <div class="col-7 fw-bold">8A</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted fw-semibold">Wali Kelas :</div>
                                <div class="col-7 fw-bold">Budi Santoso, S.Pd</div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-5 text-muted fw-semibold">Total Kehadiran (Bulan Ini) :</div>
                                <div class="col-7 fw-bold">19 Hadir, 1 Izin, 1 Sakit, 0 Alpha</div>
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
                            <h3 class="fw-bold mb-0 text-white">19 hari</h3>
                            <p class="text-white fs-6">Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-warning bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="file-text" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">1 hari</h3>
                            <p class="text-white fs-6">Izin</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-info bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="thermometer" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">1 hari</h3>
                            <p class="text-white fs-6">Sakit</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card shadow-sm border-0 text-center h-100 bg-danger bg-opacity-10">
                        <div class="card-body">
                            <i data-feather="x-circle" class="text-white mb-2" width="36" height="36"></i>
                            <h3 class="fw-bold mb-0 text-white">0 hari</h3>
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
                                <div class="list-group-item py-3 text-center text-muted">Memuat data...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function loadKehadiranHariIni() {
                    // Data jadwal berdasarkan hari (0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
                    const jadwal = {
                        0: [], // Minggu libur
                        1: [ // Senin
                            {
                                mapel: "Matematika",
                                waktu: "07:30 - 08:30",
                                guru: "Budi Santoso, S.Pd",
                                status: "Hadir"
                            },
                            {
                                mapel: "Bahasa Indonesia",
                                waktu: "08:30 - 09:30",
                                guru: "Siti Aminah, S.Pd",
                                status: "Hadir"
                            },
                            {
                                mapel: "IPA",
                                waktu: "09:45 - 10:45",
                                guru: "Dedi Kurniawan, S.Si",
                                status: "Sakit"
                            },
                            {
                                mapel: "IPS",
                                waktu: "10:45 - 11:45",
                                guru: "Rina Safitri, S.Pd",
                                status: "Izin"
                            }
                        ],
                        2: [ // Selasa
                            {
                                mapel: "PJOK",
                                waktu: "07:30 - 08:30",
                                guru: "Ucup Sport",
                                status: "Alpha"
                            },
                            {
                                mapel: "Bahasa Inggris",
                                waktu: "08:30 - 09:30",
                                guru: "Lestari Handayani, S.Pd",
                                status: "Hadir"
                            }
                        ],
                        3: [ // Rabu
                            {
                                mapel: "Matematika",
                                waktu: "07:30 - 08:30",
                                guru: "Budi Santoso, S.Pd",
                                status: "Hadir"
                            },
                            {
                                mapel: "IPA",
                                waktu: "08:30 - 09:30",
                                guru: "Dedi Kurniawan, S.Si",
                                status: "Hadir"
                            }
                        ],
                        4: [ // Kamis
                            {
                                mapel: "Bahasa Indonesia",
                                waktu: "07:30 - 08:30",
                                guru: "Siti Aminah, S.Pd",
                                status: "Izin"
                            },
                            {
                                mapel: "IPS",
                                waktu: "08:30 - 09:30",
                                guru: "Rina Safitri, S.Pd",
                                status: "Hadir"
                            }
                        ],
                        5: [ // Jumat
                            {
                                mapel: "Agama",
                                waktu: "07:30 - 08:30",
                                guru: "Ahmad Fauzi, S.Ag",
                                status: "Hadir"
                            },
                            {
                                mapel: "IPS",
                                waktu: "08:30 - 09:30",
                                guru: "Rina Safitri, S.Pd",
                                status: "Alpha"
                            }

                        ],
                        6: [ // Sabtu
                            {
                                mapel: "Seni Budaya",
                                waktu: "07:30 - 08:30",
                                guru: "Sri Mulyani",
                                status: "Sakit"
                            }
                        ]
                    };

                    const today = new Date().getDay(); // 0 Minggu, 1 Senin ... 6 Sabtu
                    const jadwalHariIni = jadwal[today] || [];

                    const container = document.getElementById('kehadiranHariIniContainer');
                    if (jadwalHariIni.length === 0) {
                        container.innerHTML =
                            '<div class="list-group-item py-3 text-center text-muted">Tidak ada jadwal untuk hari ini.</div>';
                        return;
                    }

                    let html = '';
                    jadwalHariIni.forEach(item => {
                        let statusClass = '';
                        switch (item.status) {
                            case 'Hadir':
                                statusClass = 'text-success fw-bold';
                                break;
                            case 'Izin':
                                statusClass = 'text-warning fw-bold';
                                break;
                            case 'Sakit':
                                statusClass = 'text-info fw-bold';
                                break;
                            case 'Alpha':
                                statusClass = 'text-danger fw-bold';
                                break;
                            default:
                                statusClass = 'text-secondary fw-bold';
                        }
                        html += `
                <div class="list-group-item py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <div class="fw-bold fs-5">${item.mapel}</div>
                            <div class="text-muted small">${item.waktu} • ${item.guru}</div>
                        </div>
                        <div class="${statusClass}">${item.status}</div>
                    </div>
                </div>
            `;
                    });
                    container.innerHTML = html;
                }

                document.addEventListener('DOMContentLoaded', function() {
                    loadKehadiranHariIni();
                });
            </script>

            <!-- Tren Kehadiran Harian + Diagram Lingkaran -->
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
                                <!-- Kolom Tabel -->
                                <div class="col-md-7">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Hadir</th>
                                                    <th>Izin</th>
                                                    <th>Sakit</th>
                                                    <th>Alpha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>08 Apr</td>
                                                    <td>61</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>09 Apr</td>
                                                    <td>60</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>10 Apr</td>
                                                    <td>30</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                    <td>11 Apr</td>
                                                    <td>32</td>
                                                    <td>1</td>
                                                    <td>2</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr class="table-secondary">
                                                    <td><strong>Persentase</strong></td>
                                                    <td><strong>93%</strong></td>
                                                    <td><strong>4%</strong></td>
                                                    <td><strong>3%</strong></td>
                                                    <td><strong>0%</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Kolom Diagram Lingkaran (Bulat) -->
                                <div class="col-md-5 text-center">
                                    <canvas id="pieChartPersentase"
                                        style="max-width: 250px; max-height: 250px; margin: 0 auto;"></canvas>
                                    <div class="mt-3">
                                        <span class="badge bg-success me-2">Hadir 93%</span>
                                        <span class="badge bg-warning me-2">Izin 4%</span>
                                        <span class="badge bg-info me-2">Sakit 3%</span>
                                        <span class="badge bg-danger">Alpha 0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
