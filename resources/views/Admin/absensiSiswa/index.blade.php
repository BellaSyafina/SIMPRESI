@extends('Layouts.template-admin')

@section('title', 'Data Absensi Siswa')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400 active">@yield('title')</li>
    </ol>
@endsection

@section('content')
    @php
        // Data dummy
        $today = date('Y-m-d');
        $kelasList = ['7A', '7B', '7C', '7D', '8A', '8B', '8C', '9A', '9B', '9C', '9D'];
        $mapelList = ['Matematika', 'Bahasa Indonesia', 'IPA', 'IPS', 'Agama', 'Bahasa Inggris', 'PJOK'];

        $selectedKelas = request()->get('kelas', '7A');
        $selectedMapel = request()->get('mapel', 'Matematika');
        $selectedTanggal = request()->get('tanggal', $today);

        // Daftar siswa
        $siswa = [
            ['no' => 1, 'nis' => '2024070001', 'nama' => 'Ahmad Zaki'],
            ['no' => 2, 'nis' => '2024070002', 'nama' => 'Siti Aisyah'],
            ['no' => 3, 'nis' => '2024070003', 'nama' => 'Budi Santoso'],
            ['no' => 4, 'nis' => '2024070004', 'nama' => 'Dewi Lestari'],
            ['no' => 5, 'nis' => '2024070005', 'nama' => 'Rizki Ramadhan'],
            ['no' => 6, 'nis' => '2024070006', 'nama' => 'Rini Hanayani'],
            ['no' => 7, 'nis' => '2024070007', 'nama' => 'Gilang Ramadhan'],
            ['no' => 8, 'nis' => '2024070008', 'nama' => 'Hana Safitri'],
            ['no' => 9, 'nis' => '2024070009', 'nama' => 'Indra Wijaya'],
            ['no' => 10, 'nis' => '2024070010', 'nama' => 'Jihan Ayu'],
        ];

        // Statistik awal (semua hadir)
        $totalSiswa = count($siswa);
        $totalHadir = $totalSiswa;
        $totalIzin = 0;
        $totalSakit = 0;
        $totalAlpha = 0;
        $persenHadir = 100;
    @endphp

    <div class="container-fluid px-0">
        <!-- Filter -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $selectedTanggal }}"
                            onchange="this.form.submit()">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas" class="form-select" onchange="this.form.submit()">
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>
                                    {{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Mata Pelajaran</label>
                        <select name="mapel" class="form-select" onchange="this.form.submit()">
                            @foreach ($mapelList as $mapel)
                                <option value="{{ $mapel }}" {{ $selectedMapel == $mapel ? 'selected' : '' }}>
                                    {{ $mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-outline-secondary w-100"
                            onclick="alert('Reset filter (demo)'); return false;">
                            <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistik Ringkasan (5 card, full width dengan row-cols-5) -->
        <div class="row row-cols-5 g-3 mb-4" id="statsContainer">
            <div class="col">
                <div class="card h-100 shadow-sm border-0 bg-primary text-white">
                    <div class="card-body text-center">
                        <i data-feather="users" class="mb-2" width="32" height="32" style="color: white;"></i>
                        <h6 class="mb-1 fw-bold text-white">Total</h6>
                        <h3 class="mb-0 fw-bold text-white" id="totalSiswa">{{ $totalSiswa }}</h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 bg-success text-white">
                    <div class="card-body text-center">
                        <i data-feather="check-circle" class="mb-2" width="32" height="32"
                            style="color: white;"></i>
                        <h6 class="mb-1 fw-bold text-white">Hadir</h6>
                        <h3 class="mb-0 fw-bold text-white" id="totalHadir">{{ $totalHadir }}</h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 bg-warning text-white">
                    <div class="card-body text-center">
                        <i data-feather="file-text" class="mb-2" width="32" height="32" style="color: white;"></i>
                        <h6 class="mb-1 fw-bold text-white">Izin</h6>
                        <h3 class="mb-0 fw-bold text-white" id="totalIzin">{{ $totalIzin }}</h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 bg-info text-white">
                    <div class="card-body text-center">
                        <i data-feather="thermometer" class="mb-2" width="32" height="32"
                            style="color: white;"></i>
                        <h6 class="mb-1 fw-bold text-white">Sakit</h6>
                        <h3 class="mb-0 fw-bold text-white" id="totalSakit">{{ $totalSakit }}</h3>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 bg-danger text-white">
                    <div class="card-body text-center">
                        <i data-feather="x-circle" class="mb-2" width="32" height="32" style="color: white;"></i>
                        <h6 class="mb-1 fw-bold text-white">Alpha</h6>
                        <h3 class="mb-0 fw-bold text-white" id="totalAlpha">{{ $totalAlpha }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Persentase Kehadiran (Card FULL WIDTH, tanpa sisa ruang) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title fw-semibold mb-3">Persentase Kehadiran</h5>
                        <p class="text-muted mb-2" id="persenKelasMapel">Kelas {{ $selectedKelas }} -
                            {{ $selectedMapel }}</p>
                        <h2 class="fw-bold text-primary display-4" id="persenValue">{{ $persenHadir }}%</h2>
                        <div class="progress mt-3 mx-auto" style="height: 10px; max-width: 80%;">
                            <div class="progress-bar bg-primary" id="persenProgress" role="progressbar"
                                style="width: {{ $persenHadir }}%;" aria-valuenow="{{ $persenHadir }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Siswa -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i>
                    Daftar Siswa Kelas {{ $selectedKelas }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <form action="#" method="POST" id="formAbsensi">
                        @csrf
                        <table class="table table-hover align-middle mb-0" id="siswaTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 20%">Nama Siswa</th>
                                    <th style="width: 15%">NIS</th>
                                    <th style="width: 30%">Status</th>
                                    <th style="width: 30%">Keterangan (Opsional)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $s)
                                    <tr>
                                        <td class="fs-6">{{ $s['no'] }}</td>
                                        <td class="fs-6">{{ $s['nama'] }}</td>
                                        <td class="fs-6">{{ $s['nis'] }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <label class="btn btn-outline-success">
                                                    <input type="radio" name="status[{{ $s['nis'] }}]"
                                                        value="hadir" class="status-radio"
                                                        data-nis="{{ $s['nis'] }}" checked> Hadir
                                                </label>
                                                <label class="btn btn-outline-warning">
                                                    <input type="radio" name="status[{{ $s['nis'] }}]"
                                                        value="izin" class="status-radio"
                                                        data-nis="{{ $s['nis'] }}"> Izin
                                                </label>
                                                <label class="btn btn-outline-info">
                                                    <input type="radio" name="status[{{ $s['nis'] }}]"
                                                        value="sakit" class="status-radio"
                                                        data-nis="{{ $s['nis'] }}"> Sakit
                                                </label>
                                                <label class="btn btn-outline-danger">
                                                    <input type="radio" name="status[{{ $s['nis'] }}]"
                                                        value="alpha" class="status-radio"
                                                        data-nis="{{ $s['nis'] }}"> Alpha
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                name="keterangan[{{ $s['nis'] }}]"
                                                placeholder="Tambahkan keterangan..." style="font-size: 0.875rem;">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notifikasi WhatsApp & Tombol Simpan -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="message-circle" class="me-2" width="18" height="18"></i>
                    Notifikasi WhatsApp Otomatis
                </h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Setelah Anda menyimpan data absensi, sistem akan otomatis mengirim notifikasi ke nomor WhatsApp orang
                    tua siswa yang statusnya <strong>Izin, Sakit, atau Alpha</strong>. Orang tua siswa yang hadir
                    <strong>tidak akan menerima notifikasi</strong>.
                </p>
                <button type="button" class="btn btn-primary w-100 py-2"
                    onclick="alert('Demo: Simpan absensi & kirim notifikasi (backend belum tersedia)');">
                    <i data-feather="save" class="me-1" width="16" height="16"></i> Simpan Absensi & Kirim
                    Notifikasi
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            function updateStats() {
                const radios = document.querySelectorAll('.status-radio:checked');
                let totalHadir = 0,
                    totalIzin = 0,
                    totalSakit = 0,
                    totalAlpha = 0;
                radios.forEach(radio => {
                    const value = radio.value;
                    if (value === 'hadir') totalHadir++;
                    else if (value === 'izin') totalIzin++;
                    else if (value === 'sakit') totalSakit++;
                    else if (value === 'alpha') totalAlpha++;
                });
                const totalSiswa = radios.length;
                const persen = totalSiswa > 0 ? ((totalHadir / totalSiswa) * 100).toFixed(1) : 0;

                document.getElementById('totalSiswa').innerText = totalSiswa;
                document.getElementById('totalHadir').innerText = totalHadir;
                document.getElementById('totalIzin').innerText = totalIzin;
                document.getElementById('totalSakit').innerText = totalSakit;
                document.getElementById('totalAlpha').innerText = totalAlpha;

                const persenValueElem = document.getElementById('persenValue');
                const persenProgressElem = document.getElementById('persenProgress');
                persenValueElem.innerText = persen + '%';
                persenProgressElem.style.width = persen + '%';
                persenProgressElem.setAttribute('aria-valuenow', persen);
            }

            document.querySelectorAll('.status-radio').forEach(radio => {
                radio.addEventListener('change', updateStats);
            });
            updateStats();
        });
    </script>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
