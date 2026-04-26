@extends('Layouts.template-admin')

@section('title', 'Data Orang Tua')

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
    <div class="container-fluid px-0">
        <!-- Statistik Ringkas (4 card) -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0 bg-primary bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary p-3 rounded-circle me-3">
                            <i data-feather="users" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Total Orang Tua</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0 bg-info bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info p-3 rounded-circle me-3">
                            <i data-feather="user-check" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Orang Tua Laki-laki</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $ortuLaki }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0 bg-danger bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger p-3 rounded-circle me-3">
                            <i data-feather="user" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Orang Tua Perempuan</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $ortuPerempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0 bg-success bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success p-3 rounded-circle me-3">
                            <i data-feather="phone" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-bold text-white">Memiliki No. HP</h6>
                            <h3 class="mb-0 fw-bold text-white">{{ $memilikiHp }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('orangtua.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Search:</label>
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i data-feather="filter" class="me-1" width="16" height="16"></i> Filter
                        </button>
                        <a href="{{ route('orangtua.index') }}" class="btn btn-outline-secondary">
                            <i data-feather="refresh-cw" width="16" height="16"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @include('Components.alert')

        <!-- Tabel Data Orang Tua (dengan kolom JK) -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i> Daftar Orang Tua / Wali
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#importModalOrtu">
                        <i data-feather="upload" class="me-1" width="16" height="16"></i> Import Data Orang Tua
                    </button>
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="window.location='{{ route('orangtua.create') }}'">
                        <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Orang Tua
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 20%">Nama Orang Tua</th>
                                <th style="width: 15%">Jenis Kelamin</th>
                                <th style="width: 15%">No. HP</th>
                                <th style="width: 25%">Alamat</th>
                                <th style="width: 12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orangTua as $ortu)
                                <tr>
                                    <td>{{ $ortu->id_orang_tua }}</td>
                                    <td>{{ $ortu->nama_orang_tua }}</td>
                                    <td>{{ $ortu->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        @if ($ortu->no_hp)
                                            <span class="text-primary">{{ $ortu->no_hp }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $ortu->alamat ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary btn-edit"
                                                data-id="{{ $ortu->id_orang_tua }}"
                                                onclick="window.location='{{ route('orangtua.edit', $ortu->id_orang_tua) }}'">
                                                <i data-feather="edit-2"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-info btn-akun"
                                                data-id="{{ $ortu->id_orang_tua }}"
                                                data-email="{{ $ortu->user->email ?? '-' }}">
                                                <i data-feather="eye"></i> Akun
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-hapus"
                                                data-id="{{ $ortu->id_orang_tua }}"
                                                data-nama="{{ $ortu->nama_orang_tua }}">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                        Belum ada data orang tua.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination dummy -->
                <div class="p-3 border-top">
                    {{ $orangTua->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHapusOrtu" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form id="formHapusOrtu" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h6 class="modal-title">Konfirmasi Hapus</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        Hapus data orang tua <strong id="namaOrtuHapus"></strong>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAkunOrtu" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Informasi Akun</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Email: <strong id="emailOrtu"></strong></p>
                    <p>Password: <strong>12345678</strong></p>

                    <div class="alert alert-warning mt-2">
                        <i data-feather="alert-triangle"></i>
                        Password default, segera diganti!
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModalOrtu" tabindex="-1" aria-labelledby="importModalOrtuLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalOrtuLabel">
                        <i data-feather="upload-cloud" class="me-2" width="18" height="18"></i> Import Data
                        Orang Tua
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('orangtua.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_excel_ortu" class="form-label fw-semibold">Upload File Excel</label>
                            <input type="file" name="file_excel" id="file_excel_ortu" class="form-control"
                                accept=".xls, .xlsx" required>

                            <div class="form-text text-white">
                                Format file: .xls atau .xlsx (Max. 2MB)
                            </div>

                            {{-- 🔥 DOWNLOAD TEMPLATE --}}
                            <div class="mt-2">
                                <a href="{{ asset('template-orangtua.xlsx') }}" class="text-decoration-none small">
                                    <i data-feather="download" class="me-1" width="14" height="14"></i>
                                    Download Template Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="upload" class="me-1" width="16" height="16"></i> Import
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

                    document.getElementById('namaOrtuHapus').innerText = nama;
                    document.getElementById('formHapusOrtu').action = '/orangtua/' + id;

                    new bootstrap.Modal(document.getElementById('modalHapusOrtu')).show();
                });
            });

            document.querySelectorAll('.btn-akun').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.getElementById('emailOrtu').innerText = this.dataset.email;
                    new bootstrap.Modal(document.getElementById('modalAkunOrtu')).show();
                });
            });
        });
    </script>
@endpush
