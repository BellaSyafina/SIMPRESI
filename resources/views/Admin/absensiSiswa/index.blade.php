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
    <div class="container-fluid px-0">
        <!-- Filter -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('absensi.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas" class="form-select" onchange="this.form.submit()">
                            @foreach ($kelasList as $id => $kelas)
                                <option value="{{ $id }}" {{ $selectedKelas == $id ? 'selected' : '' }}>
                                    {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Jadwal Pelajaran
                        </label>

                        <select name="jadwal" class="form-select" onchange="this.form.submit()">
                            @forelse ($jadwalList as $jadwal)
                                <option value="{{ $jadwal->id_jadwal_pelajaran }}"
                                    {{ $selectedJadwal == $jadwal->id_jadwal_pelajaran ? 'selected' : '' }}>
                                    {{ $jadwal->sesi->nama_sesi }}
                                    -
                                    {{ $jadwal->mataPelajaran->nama_mata_pelajaran }}
                                </option>
                            @empty
                                <option disabled>
                                    Tidak ada jadwal
                                </option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Pertemuan
                        </label>
                        <select name="pertemuan" class="form-select" onchange="this.form.submit()">
                            @forelse ($pertemuanList as $pertemuan)
                                <option value="{{ $pertemuan->id_pertemuan }}"
                                    {{ $selectedPertemuan == $pertemuan->id_pertemuan ? 'selected' : '' }}>
                                    Pertemuan
                                    {{ $pertemuan->pertemuan_ke }}
                                    -
                                    {{ $pertemuan->tanggal->format('d M Y') }}
                                </option>
                            @empty
                                <option disabled>
                                    Belum ada pertemuan
                                </option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary w-100">
                            <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="alert alert-primary border-0 shadow-sm">
            <div class="d-flex flex-wrap gap-4 align-items-center">
                <div>
                    <strong>Sesi:</strong>
                    {{ $jadwalAktif?->sesi?->nama_sesi ?? '-' }}
                </div>
                <div>
                    <strong>Jam:</strong>
                    {{ $jadwalAktif?->sesi?->jam_mulai ?? '-' }}
                    -
                    {{ $jadwalAktif?->sesi?->jam_selesai ?? '-' }}
                </div>
                <div>
                    <strong>Kelas:</strong> {{ $kelasList[$selectedKelas] ?? '-' }}
                </div>
                <div>
                    <strong>Mata Pelajaran:</strong> {{ $jadwalAktif?->mataPelajaran?->nama_mata_pelajaran ?? '-' }}
                </div>
                <div>
                    <strong>Pertemuan:</strong>
                    {{ optional($pertemuanList->where('id_pertemuan', $selectedPertemuan)->first())->pertemuan_ke ?? '-' }}
                </div>
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
                        <h6 class="mb-1 fw-bold text-white">Alpa</h6>
                        <h3 class="mb-0 fw-bold text-white" id="totalAlpha">{{ $totalAlpha }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Persentase Kehadiran (Card FULL WIDTH, tanpa sisa ruang) -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title fw-semibold mb-3">Persentase Kehadiran</h5>
                        <p class="text-muted mb-2" id="persenKelasMapel">Kelas {{ $kelasList[$selectedKelas] ?? '-' }} -
                            {{ $jadwalAktif?->mataPelajaran?->nama_mata_pelajaran ?? '-' }}</p>
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

        @include('Components.alert')
        @if (!$jadwalAktif)
            <div class="alert alert-warning shadow-sm border-0">
                <i data-feather="alert-triangle" class="me-2"></i>
                Belum ada jadwal atau pertemuan
                yang tersedia.
            </div>
        @endif

        <!-- Tabel Daftar Siswa -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i>
                    Absensi Pertemuan
                    {{ optional($pertemuanList->where('id_pertemuan', $selectedPertemuan)->first())->pertemuan_ke ?? '-' }}
                    -
                    {{ $kelasList[$selectedKelas] ?? '-' }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <form action="{{ route('absensi.store') }}" method="POST" id="formAbsensi">
                        @csrf
                        <input type="hidden" name="id_pertemuan" value="{{ $selectedPertemuan }}">
                        <table class="table table-hover align-middle mb-0" id="siswaTable">
                            <thead class="table">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 20%">Nama Siswa</th>
                                    <th style="width: 15%">NIS</th>
                                    <th style="width: 10%">L/P</th>
                                    <th style="width: 30%">Status</th>
                                    <th style="width: 30%">Keterangan (Opsional)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswa as $s)
                                    <tr>
                                        <td class="fs-6">{{ $loop->iteration }}</td>
                                        <td class="fs-6">{{ $s->nama_siswa }}</td>
                                        <td class="fs-6">{{ $s->nis }}</td>
                                        <td class="fs-6">{{ $s->jenis_kelamin }}</td>
                                        @php
                                            $status = $absensi[$s->id_siswa]->status ?? 'hadir';
                                        @endphp
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <label class="btn btn-outline-success">
                                                    <input type="radio" name="status[{{ $s->id_siswa }}]"
                                                        value="hadir" class="status-radio"
                                                        data-nis="{{ $s->id_siswa }}"
                                                        {{ $status == 'hadir' ? 'checked' : '' }}> Hadir
                                                </label>
                                                <label class="btn btn-outline-warning">
                                                    <input type="radio" name="status[{{ $s->id_siswa }}]"
                                                        value="izin" class="status-radio"
                                                        data-nis="{{ $s->id_siswa }}"
                                                        {{ $status == 'izin' ? 'checked' : '' }}> Izin
                                                </label>
                                                <label class="btn btn-outline-info">
                                                    <input type="radio" name="status[{{ $s->id_siswa }}]"
                                                        value="sakit" class="status-radio"
                                                        data-nis="{{ $s->id_siswa }}"
                                                        {{ $status == 'sakit' ? 'checked' : '' }}> Sakit
                                                </label>
                                                <label class="btn btn-outline-danger">
                                                    <input type="radio" name="status[{{ $s->id_siswa }}]"
                                                        value="alpa" class="status-radio"
                                                        data-nis="{{ $s->id_siswa }}"
                                                        {{ $status == 'alpa' ? 'checked' : '' }}> Alpa
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                name="keterangan[{{ $s->id_siswa }}]"
                                                placeholder="Tambahkan keterangan..." style="font-size: 0.875rem;">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            Tidak ada data siswa
                                        </td>
                                    </tr>
                                @endforelse
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
                    Notifikasi Email & WhatsApp Otomatis
                </h5>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Setelah Anda menyimpan data absensi, sistem akan otomatis mengirim notifikasi ke nomor WhatsApp orang
                    tua siswa yang statusnya <strong>Izin, Sakit, atau Alpa</strong>. Orang tua siswa yang hadir
                    <strong>tidak akan menerima notifikasi</strong>.
                </p>
                <button type="submit" form="formAbsensi" class="btn btn-primary w-100 py-2"
                    {{ !$jadwalAktif ? 'disabled' : '' }}>

                    <i data-feather="save" class="me-1"></i>
                    Simpan Absensi
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
                    else if (value === 'alpa') totalAlpha++;
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

    <style>
        .btn-group input[type="radio"]:checked+label,
        .btn-check:checked+.btn {
            color: #fff !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
