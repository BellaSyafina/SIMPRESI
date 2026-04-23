@extends('Layouts.template-admin')

@section('title', 'Data Guru')

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
        <!-- Statistik Ringkas -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-primary bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary p-3 rounded-circle me-3">
                            <i data-feather="users" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Total Guru</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalGuru }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info p-3 rounded-circle me-3">
                            <i data-feather="users" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Guru Laki-laki</h6>
                            <h3 class="mb-0 fw-bold">{{ $guruLaki }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger p-3 rounded-circle me-3">
                            <i data-feather="users" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold">Guru Perempuan</h6>
                            <h3 class="mb-0 fw-bold">{{ $guruPerempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('guru.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search:</label>
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Cari jabatan..."
                            value="{{ request('jabatan') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i data-feather="filter" class="me-1" width="16" height="16"></i> Filter
                        </button>
                        <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary">
                            <i data-feather="refresh-cw" width="16" height="16"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data Guru -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i> Daftar Guru
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#importModal">
                        <i data-feather="upload" class="me-1" width="16" height="16"></i> Import Data Guru
                    </button>
                    <a href="{{ route('guru.create') }}" class="btn btn-sm btn-success">
                        <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Guru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 15%">Nama Guru</th>
                                <th style="width: 20%">NUPTK/NIP</th>
                                <th style="width: 10%">Jenis Kelamin</th>
                                <th style="width: 15%">Jabatan</th>
                                <th style="width: 20%">Alamat</th>
                                <th style="width: 15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gurus as $guru)
                                <tr>
                                    <td>{{ $guru->id_guru }}</td>
                                    <td class="fw-semibold">{{ $guru->nama_guru }}</td>
                                    <td>
                                        @if ($guru->nuptk)
                                            <div><span class="text-primary fw-semibold">NUPTK:</span> <span
                                                    class="text-primary">{{ $guru->nuptk }}</span></div>
                                        @endif
                                        @if ($guru->nip)
                                            <div><span class="text-success fw-semibold">NIP:</span> <span
                                                    class="text-success">{{ $guru->nip }}</span></div>
                                        @endif
                                        @if (!$guru->nuptk && !$guru->nip)
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $guru->jabatan ?? '-' }}</td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $guru->alamat }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('guru.show', $guru->id_guru) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i data-feather="edit-2"></i> Edit
                                            </a>
                                            <form action="{{ route('guru.destroy', $guru->id_guru) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus data ini?')"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i data-feather="trash-2"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                        Belum ada data guru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top">
                    {{ $gurus->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
