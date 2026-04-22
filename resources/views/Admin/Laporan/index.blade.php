@extends('Layouts.template-admin')

@section('title', 'Laporan Kehadiran')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400 active">@yield('title')</li>
        {{--  <li class="breadcrumb-item f-w-400 active">Default</li>  --}}
    </ol>
@endsection

@section('content')
    @php
        use Carbon\Carbon;

        // DAFTAR KELAS (11 kelas)
        $kelasList = ['7A', '7B', '7C', '7D', '8A', '8B', '8C', '9A', '9B', '9C', '9D'];

        // Ambil filter dari request (demo)
        $selectedKelas = request()->get('kelas', '7A');
        $selectedBulan = request()->get('bulan', date('m'));
        $selectedTahun = request()->get('tahun', date('Y'));

        // Nama bulan
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

        // DATA DUMMY SISWA per KELAS (NIS, Nama)
        $siswaPerKelas = [
            '7A' => [
                ['nis' => '2024070001', 'nama' => 'Ahmad Zaki'],
                ['nis' => '2024070002', 'nama' => 'Siti Aisyah'],
                ['nis' => '2024070003', 'nama' => 'Budi Santoso'],
                ['nis' => '2024070004', 'nama' => 'Dewi Lestari'],
                ['nis' => '2024070005', 'nama' => 'Rizki Ramadhan'],
            ],
            '7B' => [
                ['nis' => '2024070006', 'nama' => 'Nur Aisyah'],
                ['nis' => '2024070007', 'nama' => 'M. Fajar'],
                ['nis' => '2024070008', 'nama' => 'Laila Fitriani'],
                ['nis' => '2024070009', 'nama' => 'Andi Saputra'],
                ['nis' => '2024070010', 'nama' => 'Rina Wati'],
            ],
            '7C' => [
                ['nis' => '2024070011', 'nama' => 'Rahmat Hidayat'],
                ['nis' => '2024070012', 'nama' => 'Siti Fatimah'],
                ['nis' => '2024070013', 'nama' => 'Dodi Prayogo'],
            ],
            '7D' => [
                ['nis' => '2024070014', 'nama' => 'Indah Permata'],
                ['nis' => '2024070015', 'nama' => 'Eko Prasetyo'],
                ['nis' => '2024070016', 'nama' => 'Yuni Astuti'],
            ],
            '8A' => [
                ['nis' => '2024080001', 'nama' => 'Agus Salim'],
                ['nis' => '2024080002', 'nama' => 'Diana Kusuma'],
                ['nis' => '2024080003', 'nama' => 'Fajar Nugroho'],
                ['nis' => '2024080004', 'nama' => 'Nadia Putri'],
            ],
            '8B' => [
                ['nis' => '2024080005', 'nama' => 'Rian Hidayat'],
                ['nis' => '2024080006', 'nama' => 'Sari Wulandari'],
                ['nis' => '2024080007', 'nama' => 'Teguh Prasetyo'],
                ['nis' => '2024080008', 'nama' => 'Winda Lestari'],
            ],
            '8C' => [
                ['nis' => '2024080009', 'nama' => 'Yoga Pratama'],
                ['nis' => '2024080010', 'nama' => 'Zahra Aulia'],
                ['nis' => '2024080011', 'nama' => 'Bayu Saputra'],
            ],
            '9A' => [
                ['nis' => '2024090001', 'nama' => 'Citra Dewi'],
                ['nis' => '2024090002', 'nama' => 'Dimas Aditya'],
                ['nis' => '2024090003', 'nama' => 'Eka Pratiwi'],
                ['nis' => '2024090004', 'nama' => 'Farhan Ardiansyah'],
            ],
            '9B' => [
                ['nis' => '2024090005', 'nama' => 'Gita Puspita'],
                ['nis' => '2024090006', 'nama' => 'Hendra Setiawan'],
                ['nis' => '2024090007', 'nama' => 'Intan Permata'],
                ['nis' => '2024090008', 'nama' => 'Joko Susilo'],
            ],
            '9C' => [
                ['nis' => '2024090009', 'nama' => 'Kiki Amelia'],
                ['nis' => '2024090010', 'nama' => 'Lukman Hakim'],
                ['nis' => '2024090011', 'nama' => 'Maya Sari'],
                ['nis' => '2024090012', 'nama' => 'Nando Putra'],
            ],
            '9D' => [
                ['nis' => '2024090013', 'nama' => 'Oktavia Dewi'],
                ['nis' => '2024090014', 'nama' => 'Panji Utomo'],
                ['nis' => '2024090015', 'nama' => 'Rani Kurnia'],
            ],
        ];

        // Data kehadiran dummy untuk setiap siswa di bulan & tahun terpilih
        // Format: ['hadir', 'izin', 'sakit', 'alpa']
        // Jumlah hari dalam bulan (28-31) untuk tahun dan bulan terpilih
        $jumlahHari = Carbon::create($selectedTahun, (int) $selectedBulan, 1)->daysInMonth;
        $siswaList = $siswaPerKelas[$selectedKelas] ?? [];

        $rekap = [];
        $totalHadir = 0;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpa = 0;

        foreach ($siswaList as $siswa) {
            // Data dummy: hadir 60-95%, izin 0-10%, sakit 0-10%, alpa 0-10%
            $hadir = rand(round($jumlahHari * 0.6), round($jumlahHari * 0.95));
            $izin = rand(0, round($jumlahHari * 0.1));
            $sakit = rand(0, round($jumlahHari * 0.1));
            $alpa = $jumlahHari - ($hadir + $izin + $sakit);
            if ($alpa < 0) {
                $alpa = 0;
            }
            $persen = round(($hadir / $jumlahHari) * 100, 1);
            $rekap[] = [
                'nis' => $siswa['nis'],
                'nama' => $siswa['nama'],
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

        $totalSiswa = count($siswaList);
        $rataPersen = $totalSiswa > 0 ? round(($totalHadir / ($totalSiswa * $jumlahHari)) * 100, 1) : 0;
    @endphp

    <div class="container-fluid px-0">
        <!-- Filter -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pilih Kelas</label>
                        <select name="kelas" class="form-select" onchange="this.form.submit()">
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>
                                    {{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Bulan</label>
                        <select name="bulan" class="form-select" onchange="this.form.submit()">
                            @foreach ($namaBulan as $angka => $nama)
                                <option value="{{ $angka }}" {{ $selectedBulan == $angka ? 'selected' : '' }}>
                                    {{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Tahun</label>
                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                            @for ($t = 2024; $t <= 2026; $t++)
                                <option value="{{ $t }}" {{ $selectedTahun == $t ? 'selected' : '' }}>
                                    {{ $t }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <a href="#" class="btn btn-outline-secondary w-100"
                            onclick="alert('Reset filter (demo)'); return false;">
                            <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i> Reset
                        </a>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary w-100"
                                onclick="alert('Export Excel (demo)'); return false;">
                                <i data-feather="file-text" class="me-1" width="16" height="16"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-outline-secondary w-100"
                                onclick="alert('Export PDF (demo)'); return false;">
                                <i data-feather="printer" class="me-1" width="16" height="16"></i> PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistik Ringkasan (kartu) -->
        <div class="row g-3 mb-4">
            <div class="col-md-2">
                <div class="card h-100 shadow-sm border-0 bg-primary bg-opacity-10">
                    <div class="card-body text-center">
                        <i data-feather="users" class="text-primary mb-2" width="28" height="28"></i>
                        <h6 class="text-muted mb-1">Total Siswa</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalSiswa }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card h-100 shadow-sm border-0 bg-success bg-opacity-10">
                    <div class="card-body text-center">
                        <i data-feather="check-circle" class="text-success mb-2" width="28" height="28"></i>
                        <h6 class="text-muted mb-1">Total Hadir</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalHadir }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card h-100 shadow-sm border-0 bg-warning bg-opacity-10">
                    <div class="card-body text-center">
                        <i data-feather="file-text" class="text-warning mb-2" width="28" height="28"></i>
                        <h6 class="text-muted mb-1">Total Izin</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalIzin }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                    <div class="card-body text-center">
                        <i data-feather="thermometer" class="text-info mb-2" width="28" height="28"></i>
                        <h6 class="text-muted mb-1">Total Sakit</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalSakit }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                    <div class="card-body text-center">
                        <i data-feather="x-circle" class="text-danger mb-2" width="28" height="28"></i>
                        <h6 class="text-muted mb-1">Total Alpa</h6>
                        <h3 class="mb-0 fw-bold">{{ $totalAlpa }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card h-100 shadow-sm border-0 bg-secondary bg-opacity-10">
                    <div class="card-body text-center">
                        <i data-feather="percent" class="text-secondary mb-2" width="28" height="28"></i>
                        <h6 class="text-muted mb-1">Rata-rata Kehadiran</h6>
                        <h3 class="mb-0 fw-bold">{{ $rataPersen }}%</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Rekap Kehadiran -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-5">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i>
                    Rekap Kehadiran Siswa - Kelas {{ $selectedKelas }} ({{ $namaBulan[$selectedBulan] }}
                    {{ $selectedTahun }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fs-6 py-2" style="width: 15%">NIS</th>
                                <th class="fs-6 py-2" style="width: 25%">Nama Siswa</th>
                                <th class="fs-6 py-2" style="width: 10%">Hadir</th>
                                <th class="fs-6 py-2" style="width: 10%">Izin</th>
                                <th class="fs-6 py-2" style="width: 10%">Sakit</th>
                                <th class="fs-6 py-2" style="width: 10%">Alpa</th>
                                <th class="fs-6 py-2" style="width: 10%">% Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekap as $item)
                                <tr>
                                    <td class="fs-6">{{ $item['nis'] }}</td>
                                    <td class="fs-6">{{ $item['nama'] }}</td>
                                    <td class="fs-6">{{ $item['hadir'] }}</td>
                                    <td class="fs-6">{{ $item['izin'] }}</td>
                                    <td class="fs-6">{{ $item['sakit'] }}</td>
                                    <td class="fs-6">{{ $item['alpa'] }}</td>
                                    <td
                                        class="fs-6 @if ($item['persen'] < 75) text-danger fw-bold @elseif($item['persen'] < 85) text-warning fw-bold @else text-success fw-bold @endif">
                                        {{ $item['persen'] }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                        Belum ada data siswa untuk kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination dummy -->
                <div class="p-3 border-top">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            <li class="page-item active"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link" href="#"
                                    onclick="alert('Demo pagination')">2</a></li>
                            <li class="page-item"><a class="page-link" href="#"
                                    onclick="alert('Demo pagination')">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"
                                    onclick="alert('Demo pagination')">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Informasi catatan -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-light border shadow-sm mb-0" role="alert">
                    <i data-feather="info" class="me-2" width="16" height="16"></i>
                    Menampilkan rekap kehadiran untuk kelas <strong>{{ $selectedKelas }}</strong> periode
                    <strong>{{ $namaBulan[$selectedBulan] }} {{ $selectedTahun }}</strong>.
                    Jumlah hari dalam bulan ini: <strong>{{ $jumlahHari }} hari</strong>.
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
