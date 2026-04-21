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
    @php
        // ==================== DATA DUMMY GURU ====================
        $gurus = collect([
            (object) [
                'id_guru' => 1,
                'nama_guru' => 'Budi Santoso, S.Pd',
                'nuptk' => '1234567890123456',
                'nip' => '196807111992031007',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Wali Kelas',
                'alamat' => 'Dusun Panggulan, RT 01 RW 02, Desa Saronggi',
            ],
            (object) [
                'id_guru' => 2,
                'nama_guru' => 'Siti Aminah, S.Pd',
                'nuptk' => '2345678901234567',
                'nip' => '197505152002122001',
                'jenis_kelamin' => 'P',
                'jabatan' => 'Guru Mapel Bahasa Indonesia',
                'alamat' => 'Dusun Krajan, RT 03 RW 01, Desa Saronggi',
            ],
            (object) [
                'id_guru' => 3,
                'nama_guru' => 'Dedi Kurniawan, S.Si',
                'nuptk' => '3456789012345678',
                'nip' => null,
                'jenis_kelamin' => 'L',
                'jabatan' => 'Guru Mapel IPA',
                'alamat' => 'Dusun Kebonagung, RT 02 RW 03, Desa Saronggi',
            ],
            (object) [
                'id_guru' => 4,
                'nama_guru' => 'Rina Safitri, S.Pd',
                'nuptk' => '4567890123456789',
                'nip' => '198206152010012001',
                'jenis_kelamin' => 'P',
                'jabatan' => 'Guru Mapel IPS',
                'alamat' => 'Dusun Panggulan, RT 04 RW 02, Desa Saronggi',
            ],
            (object) [
                'id_guru' => 5,
                'nama_guru' => 'Ahmad Fauzi, S.Ag',
                'nuptk' => '5678901234567890',
                'nip' => '197803252005011002',
                'jenis_kelamin' => 'L',
                'jabatan' => 'Guru Agama',
                'alamat' => 'Dusun Krajan, RT 01 RW 01, Desa Saronggi',
            ],
            (object) [
                'id_guru' => 6,
                'nama_guru' => 'Lestari Handayani, S.Pd',
                'nuptk' => '6789012345678901',
                'nip' => null,
                'jenis_kelamin' => 'P',
                'jabatan' => 'Guru Matematika',
                'alamat' => 'Dusun Kebonagung, RT 05 RW 03, Desa Saronggi',
            ],
        ]);

        $totalGuru = $gurus->count();
        $guruLaki = $gurus->where('jenis_kelamin', 'L')->count();
        $guruPerempuan = $gurus->where('jenis_kelamin', 'P')->count();
    @endphp

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
                            <h6 class="text-muted mb-1">Total Guru</h6>
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
                            <h6 class="text-muted mb-1">Guru Laki-laki</h6>
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
                            <h6 class="text-muted mb-1">Guru Perempuan</h6>
                            <h3 class="mb-0 fw-bold">{{ $guruPerempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search:</label>
                        <input type="text" name="search" class="form-control" placeholder="Search...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">Semua</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" placeholder="Cari jabatan...">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
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
                    <button type="button" class="btn btn-sm btn-success" onclick="alert('Tambah Guru (demo)')">
                        <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Guru
                    </button>
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
                                            <div><span class="text-primary fw-semibold">NUPTK:</span> {{ $guru->nuptk }}
                                            </div>
                                        @endif
                                        @if ($guru->nip)
                                            <div><span class="text-success fw-semibold">NIP:</span> {{ $guru->nip }}
                                            </div>
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
                                            <button class="btn btn-sm btn-outline-primary btn-edit"
                                                data-id="{{ $guru->id_guru }}"
                                                onclick="alert('Edit guru: {{ $guru->nama_guru }}')">
                                                <i data-feather="edit-2"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-hapus"
                                                data-id="{{ $guru->id_guru }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteguruModal{{ $guru->id_guru }}">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </div>

                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="deleteModal{{ $guru->id_guru }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Konfirmasi Hapus</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus guru
                                                        <strong>{{ $guru->nama_guru }}</strong>?
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
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                        Belum ada data guru.
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

    <!-- Modal Import Data Guru -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i data-feather="upload-cloud" class="me-2" width="18" height="18"></i> Import Data
                        Guru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_excel" class="form-label fw-semibold">Upload File Excel</label>
                            <input type="file" name="file_excel" id="file_excel" class="form-control"
                                accept=".xls, .xlsx" required>
                            <div class="form-text">Format file: .xls atau .xlsx (Max. 2MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"
                            onclick="alert('Import data (demo)'); return false;">
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
