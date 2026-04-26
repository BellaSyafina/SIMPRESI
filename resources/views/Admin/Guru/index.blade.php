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
                            <h6 class="mb-1 fw-bold text-white">Total Guru</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $totalGuru }}</h3>
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
                            <h6 class="mb-1 fw-bold text-white">Guru Laki-laki</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $guruLaki }}</h3>
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
                            <h6 class="mb-1 fw-bold text-white">Guru Perempuan</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $guruPerempuan }}</h3>
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

        @include('Components.alert')

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
                        <thead class="table">
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
                                    <td class="fw-semibold">
                                        {{ $guru->nama_guru }}

                                        @if ($guru->kelas)
                                            <span class="badge bg-success ms-1">
                                                Wali {{ $guru->kelas->nama_kelas }}
                                            </span>
                                        @endif
                                    </td>
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
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal" data-bs-target="#akunModal{{ $guru->id_guru }}">
                                                <i data-feather="eye"></i> Akun
                                            </button>
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

                                <div class="modal fade" id="akunModal{{ $guru->id_guru }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Informasi Akun</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-2">
                                                    <strong>Nama:</strong><br>
                                                    {{ $guru->nama_guru }}
                                                </div>

                                                <div class="mb-2">
                                                    <strong>Email:</strong><br>
                                                    {{ $guru->user->email ?? '-' }}
                                                </div>

                                                <div class="mb-2">
                                                    <strong>Password:</strong><br>
                                                    <span class="text-muted">password123</span>
                                                </div>

                                                <div class="alert alert-warning mt-3 d-flex align-items-start gap-2">
                                                    <span>
                                                        Password adalah default saat import. Disarankan segera diganti.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Upload File Excel</label>
                            <input type="file" name="file_excel" class="form-control">
                        </div>
                        <small class="text-muted">
                            Format: nama_guru, nuptk, nip, jenis_kelamin (L/P), jabatan, alamat
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        feather.replace();

        document.addEventListener("shown.bs.modal", function() {
            feather.replace();
        });
    </script>
@endpush
