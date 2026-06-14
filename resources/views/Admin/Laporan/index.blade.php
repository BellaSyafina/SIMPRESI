@extends('Layouts.template-admin')

@section('title', 'Laporan Kehadiran Pembelajaran')

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
    @if (Auth::user()->role == 'admin')
        <div class="container-fluid px-0">
            <!-- Filter -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Pilih Kelas</label>
                            <select name="kelas" class="form-select" onchange="this.form.submit()">
                                @foreach ($kelasList as $id => $kelas)
                                    <option value="{{ $id }}" {{ $selectedKelas == $id ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Semester
                            </label>

                            <select name="semester" class="form-select" onchange="this.form.submit()">

                                @foreach ($semesterList as $semester)
                                    <option value="{{ $semester }}"
                                        {{ $selectedSemester == $semester ? 'selected' : '' }}>

                                        {{ $semester }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">

                                @foreach ($tahunAjaranList as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ $selectedTahunAjaran == $tahun ? 'selected' : '' }}>

                                        {{ $tahun }}

                                    </option>
                                @endforeach

                            </select>

                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100">
                                <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i> Reset
                            </a>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary w-100"
                                    onclick="window.location.href='{{ route('laporan.export.excel', request()->query()) }}'">
                                    <i data-feather="file-text" class="me-1" width="16" height="16"></i> Export
                                    Excel
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-100"
                                    onclick="window.location.href='{{ route('laporan.export.pdf', request()->query()) }}'">
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
                            <i data-feather="users" class="mb-2" width="28" height="28" style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Siswa</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalSiswa }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="check-circle" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Hadir</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalHadir }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="file-text" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Izin</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalIzin }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="thermometer" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Sakit</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalSakit }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="x-circle" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Alpa</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalAlpa }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-secondary bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="percent" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Rata-rata Kehadiran</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $rataPersen }}%</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekap Kehadiran -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-4">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i data-feather="list" class="me-2" width="18" height="18"></i>
                        Rekap Kehadiran Siswa - Kelas {{ $kelasList[$selectedKelas] ?? '-' }}
                        Semester {{ $selectedSemester }}
                        {{ $selectedTahunAjaran }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead style="background-color:#7C6FC4;">
                                <tr>
                                    <th class="fs-6 py-2 text-white" style="width: 15%">NIS</th>
                                    <th class="fs-6 py-2 text-white" style="width: 25%">Nama Siswa</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Hadir</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Izin</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Sakit</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Alpa</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">% Kehadiran</th>
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
                                            <i data-feather="inbox" width="48" height="48"
                                                class="mb-3"></i><br>
                                            Belum ada data siswa untuk kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @include('Components.pagination', [
                        'data' => $rekap,
                    ])
                </div>
            </div>

            <!-- Informasi catatan -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-light border shadow-sm mb-0" role="alert">

                        <i data-feather="info" class="me-2" width="16" height="16"></i>

                        Menampilkan rekap kehadiran untuk
                        kelas
                        <strong>
                            {{ $kelasList[$selectedKelas] ?? '-' }}
                        </strong>

                        periode

                        <strong>
                            Semester {{ $selectedSemester }}
                            {{ $selectedTahunAjaran }}
                        </strong>.

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role == 'guru')
        <div class="container-fluid px-0">
            <!-- Filter (hanya menampilkan kelas yang diizinkan) -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">

                        <input type="hidden" name="kelas" value="{{ $selectedKelas }}">

                        {{-- KELAS --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Pilih Kelas</label>

                            <select name="kelas" class="form-select" onchange="this.form.submit()">

                                @foreach ($kelasList as $id => $kelas)
                                    <option value="{{ $id }}" {{ $selectedKelas == $id ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- MATA PELAJARAN --}}
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>

                            <select name="mapel" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Mapel</option>

                                @foreach ($mapelList as $mapel)
                                    <option value="{{ $mapel->id_mata_pelajaran }}"
                                        {{ $selectedMapel == $mapel->id_mata_pelajaran ? 'selected' : '' }}>
                                        {{ $mapel->nama_mata_pelajaran }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Semester
                            </label>

                            <select name="semester" class="form-select" onchange="this.form.submit()">

                                @foreach ($semesterList as $semester)
                                    <option value="{{ $semester }}"
                                        {{ $selectedSemester == $semester ? 'selected' : '' }}>

                                        {{ $semester }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">

                                @foreach ($tahunAjaranList as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ $selectedTahunAjaran == $tahun ? 'selected' : '' }}>

                                        {{ $tahun }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- RESET --}}
                        <div class="col-md-1">
                            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100">
                                Reset
                            </a>
                        </div>

                        {{-- EXPORT --}}
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary w-100"
                                    onclick="window.location.href='{{ route('laporan.export.excel', request()->query()) }}'">
                                    Excel
                                </button>

                                <button type="button" class="btn btn-outline-secondary w-100"
                                    onclick="window.location.href='{{ route('laporan.export.pdf', request()->query()) }}'">
                                    PDF
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
                            <i data-feather="users" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Siswa</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalSiswa }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="check-circle" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Hadir</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalHadir }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="file-text" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Izin</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalIzin }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="thermometer" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Sakit</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalSakit }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="x-circle" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Alpa</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalAlpa }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100 shadow-sm border-0 bg-secondary bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="percent" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Rata-rata Kehadiran</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $rataPersen }}%</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekap Kehadiran -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-4">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i data-feather="list" class="me-2" width="18" height="18"></i>
                        Rekap Kehadiran Siswa - Kelas {{ $kelasList[$selectedKelas] ?? '-' }}
                        Semester {{ $selectedSemester }}
                        {{ $selectedTahunAjaran }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead style="background-color:#7C6FC4;">
                                <tr>
                                    <th class="fs-6 py-2 text-white" style="width: 15%">NIS</th>
                                    <th class="fs-6 py-2 text-white" style="width: 25%">Nama Siswa</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Hadir</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Izin</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Sakit</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">Alpa</th>
                                    <th class="fs-6 py-2 text-white" style="width: 10%">% Kehadiran</th>
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
                                            <i data-feather="inbox" width="48" height="48"
                                                class="mb-3"></i><br>
                                            Belum ada data siswa untuk kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @include('Components.pagination', [
                        'data' => $rekap,
                    ])
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-light border shadow-sm mb-0" role="alert">

                        <i data-feather="info" class="me-2" width="16" height="16"></i>

                        Menampilkan rekap kehadiran untuk
                        kelas
                        <strong>
                            {{ $kelasList[$selectedKelas] ?? '-' }}
                        </strong>

                        periode

                        <strong>
                            Semester {{ $selectedSemester }}
                            {{ $selectedTahunAjaran }}
                        </strong>.

                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user()->role == 'orang_tua')
        <div class="container-fluid px-0">
            <!-- Filter (kelas hanya menampilkan kelas anak, tidak bisa pilih lain) -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
                        <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <input type="text" class="form-control" value="{{ $kelasList[$selectedKelas] ?? '-' }}"
                                disabled>
                        </div>
                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Semester
                            </label>

                            <select name="semester" class="form-select" onchange="this.form.submit()">

                                @foreach ($semesterList as $semester)
                                    <option value="{{ $semester }}"
                                        {{ $selectedSemester == $semester ? 'selected' : '' }}>

                                        {{ $semester }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-2">

                            <label class="form-label fw-semibold">
                                Tahun Ajaran
                            </label>

                            <select name="tahun_ajaran" class="form-select" onchange="this.form.submit()">

                                @foreach ($tahunAjaranList as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ $selectedTahunAjaran == $tahun ? 'selected' : '' }}>

                                        {{ $tahun }}

                                    </option>
                                @endforeach

                            </select>

                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100">
                                <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i> Reset
                            </a>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary w-100"
                                    onclick="window.location.href='{{ route('laporan.export.excel', request()->query()) }}'">
                                    <i data-feather="file-text" class="me-1" width="16" height="16"></i> Export
                                    Excel
                                </button>
                                <button type="button" class="btn btn-outline-secondary w-100"
                                    onclick="window.location.href='{{ route('laporan.export.pdf', request()->query()) }}'">
                                    <i data-feather="printer" class="me-1" width="16" height="16"></i> PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistik Ringkasan (kartu) -->
            <div class="row g-3 mb-4">
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="check-circle" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Hadir</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalHadir }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="file-text" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Izin</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalIzin }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="thermometer" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Sakit</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalSakit }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="x-circle" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Total Alpa</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalAlpa }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 bg-secondary bg-opacity-10">
                        <div class="card-body text-center">
                            <i data-feather="percent" class="mb-2" width="28" height="28"
                                style="color: white;"></i>
                            <h6 class="mb-1 fw-bold text-white">Rata-rata Kehadiran</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $rataPersen }}%</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekap Kehadiran (hanya satu baris) -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-4">
                    <h5 class="card-title mb-0 fw-semibold">
                        <i data-feather="calendar" class="me-2" width="18" height="18"></i>
                        Jadwal Kehadiran Berdasarkan Mata Pelajaran
                    </h5>
                    <small class="text-muted">
                        Klik detail untuk melihat kehadiran per pertemuan.
                    </small>
                </div>

                <div class="card-body">
                    @forelse ($jadwalMapelOrangTua as $hari => $jadwalList)
                        <h5 class="fw-bold mt-3 mb-3">{{ $hari }}</h5>

                        <div class="row g-3">
                            @foreach ($jadwalList as $jadwal)
                                <div class="col-md-6">
                                    <div class="card shadow-sm border-0 h-100" style="background:#f6f4ff;">
                                        <div class="card-body">
                                            <h5 class="fw-bold mb-2" style="color:#7C6FC4;">
                                                {{ $jadwal->mataPelajaran->nama_mata_pelajaran }}
                                            </h5>

                                            <p style="color:#2c323f !important;">
                                                <i data-feather="clock" width="15"></i>
                                                {{ $jadwal->hari }},
                                                {{ \Carbon\Carbon::parse($jadwal->sesi->jam_mulai)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($jadwal->sesi->jam_selesai)->format('H:i') }}
                                            </p>

                                            <p style="color:#2c323f !important;">
                                                <i data-feather="users" width="15"></i>
                                                Kelas {{ $jadwal->kelas->nama_kelas }}
                                            </p>

                                            <p style="color:#2c323f !important;" >
                                                <i data-feather="user" width="15"></i>
                                                {{ $jadwal->guru->nama_guru ?? '-' }}
                                            </p>

                                            <a href="{{ route('laporan.detail', $jadwal->id_jadwal_pelajaran) }}"
                                                class="btn btn-sm text-white" style="background:#7C6FC4;">
                                                Detail Kehadiran
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            Belum ada jadwal pelajaran.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-light border shadow-sm mb-0" role="alert">

                        <i data-feather="info" class="me-2" width="16" height="16"></i>

                        Menampilkan rekap kehadiran untuk
                        kelas
                        <strong>
                            {{ $kelasList[$selectedKelas] ?? '-' }}
                        </strong>

                        periode

                        <strong>
                            Semester {{ $selectedSemester }}
                            {{ $selectedTahunAjaran }}
                        </strong>.

                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
