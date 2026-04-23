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
    @php
        // DATA DUMMY ORANG TUA
        $orangTua = collect([
            (object) [
                'id_orang_tua' => 1,
                'nama_orang_tua' => 'Bapak Hadi',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 12',
            ],
            (object) [
                'id_orang_tua' => 2,
                'nama_orang_tua' => 'Ibu Ani',
                'jenis_kelamin' => 'P',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Sudirman No. 45',
            ],
            (object) [
                'id_orang_tua' => 3,
                'nama_orang_tua' => 'Bapak Joko',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Pahlawan No. 8',
            ],
            (object) [
                'id_orang_tua' => 4,
                'nama_orang_tua' => 'Ibu Sari',
                'jenis_kelamin' => 'P',
                'no_hp' => '081234567893',
                'alamat' => 'Jl. Pemuda No. 23',
            ],
            (object) [
                'id_orang_tua' => 5,
                'nama_orang_tua' => 'Bapak Slamet',
                'jenis_kelamin' => 'L',
                'no_hp' => '081234567894',
                'alamat' => 'Jl. Kartini No. 7',
            ],
            (object) [
                'id_orang_tua' => 6,
                'nama_orang_tua' => 'Ibu Ratna',
                'jenis_kelamin' => 'P',
                'no_hp' => null,
                'alamat' => 'Jl. Diponegoro No. 31',
            ],
        ]);

        $total = $orangTua->count();
        $ortuLaki = $orangTua->where('jenis_kelamin', 'L')->count();
        $ortuPerempuan = $orangTua->where('jenis_kelamin', 'P')->count();
        $memilikiHp = $orangTua->whereNotNull('no_hp')->count();
    @endphp

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
                            <h6 class="mb-1 fw-bold">Total Orang Tua</h6>
                            <h3 class="mb-0 fw-bold">{{ $total }}</h3>
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
                            <h6 class="mb-1 fw-bold">Orang Tua Laki-laki</h6>
                            <h3 class="mb-0 fw-bold">{{ $ortuLaki }}</h3>
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
                            <h6 class="mb-1 fw-bold">Orang Tua Perempuan</h6>
                            <h3 class="mb-0 fw-bold">{{ $ortuPerempuan }}</h3>
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
                            <h6 class="mb-1 fw-bold">Memiliki No. HP</h6>
                            <h3 class="mb-0 fw-bold">{{ $memilikiHp }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Search:</label>
                        <input type="text" name="search" class="form-control"
                            placeholder="Search...">
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1" onclick="alert('Demo filter')">
                            <i data-feather="filter" class="me-1" width="16" height="16"></i> Filter
                        </button>
                        <a href="#" class="btn btn-outline-secondary" onclick="alert('Reset filter')">
                            <i data-feather="refresh-cw" width="16" height="16"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

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
                    <button type="button" class="btn btn-sm btn-success" onclick="alert('Tambah Orang Tua (demo)')">
                        <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Orang Tua
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
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
                                                onclick="alert('Edit orang tua: {{ $ortu->nama_orang_tua }}')">
                                                <i data-feather="edit-2"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-hapus"
                                                data-id="{{ $ortu->id_orang_tua }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteOrtuModal{{ $ortu->id_orang_tua }}">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </div>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteOrtuModal{{ $ortu->id_orang_tua }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Konfirmasi Hapus</h6>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data orang tua
                                                        <strong>{{ $ortu->nama_orang_tua }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="button" class="btn btn-danger"
                                                            onclick="alert('Demo: data tidak benar-benar dihapus.')">Hapus</button>
                                                    </div>
                                                </div>
                                            </div>
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
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_excel_ortu" class="form-label fw-semibold">Upload File Excel</label>
                            <input type="file" name="file_excel" id="file_excel_ortu" class="form-control"
                                accept=".xls, .xlsx" required>
                            <div class="form-text">Format file: .xls atau .xlsx (Max. 2MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"
                            onclick="alert('Import data orang tua (demo)'); return false;">
                            <i data-feather="upload" class="me-1" width="16" height="16"></i> Import
                        </button>
                    </div>
                </form>
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
