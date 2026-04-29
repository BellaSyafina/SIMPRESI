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
                            <h5 class="card-title mb-0 fw-semibold fs-3">
                                <i data-feather="calendar" class="me-2" width="28" height="28"></i>
                                Jadwal Mengajar Hari Ini
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <!-- item jadwal 1 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-6 me-3">07:30 - 08:30</span>
                                            <span class="fw-bold fs-5">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 7A</span>
                                        </div>
                                        <span class="badge bg-success fs-6">Selesai</span>
                                    </div>
                                </div>
                                <!-- item jadwal 2 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-6 me-3">08:30 - 09:30</span>
                                            <span class="fw-bold fs-5">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 8B</span>
                                        </div>
                                        <span class="badge bg-success fs-6">Selesai</span>
                                    </div>
                                </div>
                                <!-- item jadwal 3 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-6 me-3">09:45 - 10:45</span>
                                            <span class="fw-bold fs-5">Matematika</span>
                                            <span class="text-muted fs-6 ms-2">Kelas 9A</span>
                                        </div>
                                        <span class="badge bg-warning text-dark fs-6">Berlangsung</span>
                                    </div>
                                </div>
                                <!-- item jadwal 4 -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <span class="badge bg-secondary fs-6 me-3">10:45 - 11:45</span>
                                            <span class="fw-bold fs-5">Matematika</span>
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
                            <h5 class="card-title mb-0 fw-semibold fs-3">
                                <i data-feather="check-square" class="me-2" width="28" height="28"></i>
                                Absensi Terbaru
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <!-- Absensi Kelas 7A -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <h6 class="mb-1 fw-bold fs-5">Kelas 7A</h6>
                                            <small class="text-muted fs-6">Waktu: 08:25</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary fs-5 px-3 py-2">93.8%</span>
                                            <div class="small text-muted fs-6 mt-1">30/32 siswa</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Absensi Kelas 8B -->
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="mb-2 mb-sm-0">
                                            <h6 class="mb-1 fw-bold fs-5">Kelas 8B</h6>
                                            <small class="text-muted fs-6">Waktu: 09:20</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-primary fs-5 px-3 py-2">96.9%</span>
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
@endsection
