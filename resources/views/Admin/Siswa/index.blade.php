@extends('Layouts.template-admin')

@section('title', 'Data Siswa')

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
        use Illuminate\Support\Str;
    @endphp

    <div class="container-fluid">
        <!-- Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-primary bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary p-3 rounded-circle me-3">
                            <i data-feather="users" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Total Siswa</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalSiswa }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info p-3 rounded-circle me-3">
                            <i data-feather="user-check" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Siswa Laki-laki</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $siswaLaki }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger p-3 rounded-circle me-3">
                            <i data-feather="user" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Siswa Perempuan</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $siswaPerempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter: Search dan Kelas -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('siswa.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search:</label>
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelas as $id => $nama)
                                <option value="{{ $id }}" {{ request('kelas') == $id ? 'selected' : '' }}>
                                    {{ $nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">
                            Status
                        </label>
                        <select name="status" class="form-select">
                            <option value="">
                                Semua
                            </option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>
                                Lulus
                            </option>
                            <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>
                                Pindah
                            </option>
                            <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>
                                Keluar
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i data-feather="filter" class="me-1" width="16" height="16"></i> Filter
                        </button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary">
                            <i data-feather="refresh-cw" width="16" height="16"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @include('Components.alert')

        <!-- Tabel Data Siswa -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i> Daftar Siswa
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalImportSiswa">
                        <i data-feather="upload" class="me-1" width="16" height="16"></i> Import Data Siswa
                    </button>
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="window.location='{{ route('siswa.create') }}'">
                        <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Siswa
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0" style="min-width: 1400px">
                        <thead class="table">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 12%">NISN / NIS</th>
                                <th style="width: 14%">Nama Siswa</th>
                                <th style="width: 12%">TTL</th>
                                <th style="width: 8%">Agama</th>
                                <th style="width: 8%">Kelas</th>
                                <th style="width: 10%">Jenis Kelamin</th>
                                <th style="width: 18%">Orang Tua / Wali</th>
                                <th style="width: 15%">Alamat</th>
                                <th style="width: 7%">Status</th>
                                <th style="width: 14%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa->id_siswa }}</td>
                                    <td>
                                        @if ($siswa->nisn)
                                            <div><span class="text-primary fw-semibold">NISN:</span> <span
                                                    class="text-primary">{{ $siswa->nisn }}</span></div>
                                        @endif
                                        @if ($siswa->nis)
                                            <div><span class="text-success fw-semibold">NIS:</span> <span
                                                    class="text-success">{{ $siswa->nis }}</span></div>
                                        @endif
                                        @if (!$siswa->nisn && !$siswa->nis)
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $siswa->nama_siswa }}</td>

                                    <td>

                                        @if ($siswa->tempat_lahir || $siswa->tanggal_lahir)
                                            {{ $siswa->tempat_lahir ?? '-' }}

                                            @if ($siswa->tanggal_lahir)
                                                ,

                                                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d M Y') }}
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif

                                    </td>

                                    <td>
                                        {{ $siswa->agama ?? '-' }}
                                    </td>

                                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>
                                        @if ($siswa->jenis_kelamin == 'L')
                                            Laki-Laki
                                        @elseif($siswa->jenis_kelamin == 'P')
                                            Perempuan
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>

                                        @if ($siswa->nama_ayah)
                                            <div>
                                                <span class="fw-semibold text-primary">
                                                    Ayah:
                                                </span>
                                                {{ $siswa->nama_ayah }}
                                            </div>
                                        @endif

                                        @if ($siswa->nama_ibu)
                                            <div>
                                                <span class="fw-semibold text-danger">
                                                    Ibu:
                                                </span>
                                                {{ $siswa->nama_ibu }}
                                            </div>
                                        @endif

                                        @if ($siswa->nama_wali)
                                            <div>
                                                <span class="fw-semibold text-success">
                                                    Wali:
                                                </span>
                                                {{ $siswa->nama_wali }}

                                                @if ($siswa->no_hp_wali)
                                                    <div class="small text-muted">
                                                        {{ $siswa->no_hp_wali }}
                                                    </div>
                                                @endif

                                            </div>
                                        @endif

                                        @if (!$siswa->nama_ayah && !$siswa->nama_ibu && !$siswa->nama_wali)
                                            <span class="text-muted">-</span>
                                        @endif

                                    </td>
                                    <td>
                                        {{ Str::limit($siswa->alamat, 40) ?? '-' }}
                                    </td>

                                    @php
                                        $statusColor = match ($siswa->status) {
                                            'aktif' => 'success',
                                            'lulus' => 'primary',
                                            'pindah' => 'warning',
                                            'keluar' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <td>
                                        <span class="badge bg-{{ $statusColor }}">
                                            {{ ucfirst($siswa->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('siswa.detail', $siswa->id_siswa) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i data-feather="eye"></i> Detail
                                            </a>
                                            <a href="{{ route('siswa.show', $siswa->id_siswa) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i data-feather="edit-2"></i> Edit
                                            </a>
                                            <form action="{{ route('siswa.reset-password', $siswa->id_siswa) }}"
                                                method="POST"
                                                onsubmit="return confirm('Reset password siswa ke tanggal lahir?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                                    <i data-feather="key"></i>
                                                    Reset
                                                </button>
                                            </form>
                                            <button class="btn btn-sm btn-outline-danger btn-hapus"
                                                data-id="{{ $siswa->id_siswa }}" data-nama="{{ $siswa->nama_siswa }}">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center py-5 text-muted">
                                        <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                        Belum ada data siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @include('Components.pagination', ['data' => $siswas])
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusSiswa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="formHapusSiswa" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus siswa
                        <strong id="namaSiswaHapus"></strong>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Hapus
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImportSiswa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i data-feather="upload-cloud" class="me-2"></i>
                            Import Data Siswa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload File Excel</label>
                            <input type="file" name="file_excel" class="form-control" required>
                            <div class="form-text text-white">
                                Format: .xls / .xlsx (Max 2MB)
                            </div>
                        </div>

                        <div class="alert alert-warning d-flex align-items-center gap-2">
                            <i data-feather="alert-triangle"></i>
                            <span>
                                Pastikan format file sesuai template.
                            </span>
                        </div>
                        <div class="mt-2">
                            <a href="/template-siswa.xlsx" class="text-decoration-none small">
                                Download template Excel
                            </a>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="upload" class="me-1"></i> Import
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();

            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', function() {

                    let id = this.dataset.id;
                    let nama = this.dataset.nama;

                    // tampilkan nama di modal
                    document.getElementById('namaSiswaHapus').innerText = nama;

                    // set action form
                    document.getElementById('formHapusSiswa').action = '/siswa/' + id;

                    // buka modal
                    new bootstrap.Modal(document.getElementById('modalHapusSiswa')).show();

                });
            });
        });

        document.addEventListener('shown.bs.modal', function() {
            feather.replace();
        });
    </script>
@endpush
