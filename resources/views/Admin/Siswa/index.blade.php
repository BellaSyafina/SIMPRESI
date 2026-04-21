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
        {{--  <li class="breadcrumb-item f-w-400 active">Default</li>  --}}
    </ol>
@endsection

@section('content')
    @php
        // DATA DUMMY SISWA (sesuai migration)
        $kelasDummy = [
            1 => '7A',
            2 => '7B',
            3 => '8A',
            4 => '8B',
            5 => '9A',
            6 => '9B',
        ];

        $siswas = collect([
            (object) [
                'id_siswa' => 1,
                'nisn' => '1234567890',
                'nis' => '2024070001',
                'nama_siswa' => 'Ahmad Zaki',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 12',
                'status' => 'aktif',
                'id_kelas' => 1,
            ],
            (object) [
                'id_siswa' => 2,
                'nisn' => '1234567891',
                'nis' => '2024070002',
                'nama_siswa' => 'Siti Aisyah',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 45',
                'status' => 'aktif',
                'id_kelas' => 1,
            ],
            (object) [
                'id_siswa' => 3,
                'nisn' => '1234567892',
                'nis' => '2024070003',
                'nama_siswa' => 'Budi Santoso',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pahlawan No. 8',
                'status' => 'aktif',
                'id_kelas' => 2,
            ],
            (object) [
                'id_siswa' => 4,
                'nisn' => '1234567893',
                'nis' => '2024080001',
                'nama_siswa' => 'Dewi Lestari',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Pemuda No. 23',
                'status' => 'aktif',
                'id_kelas' => 3,
            ],
            (object) [
                'id_siswa' => 5,
                'nisn' => '1234567894',
                'nis' => '2024080002',
                'nama_siswa' => 'Rizki Ramadhan',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kartini No. 7',
                'status' => 'aktif',
                'id_kelas' => 4,
            ],
            (object) [
                'id_siswa' => 6,
                'nisn' => '1234567895',
                'nis' => '2024090001',
                'nama_siswa' => 'Nur Aisyah',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Diponegoro No. 31',
                'status' => 'aktif',
                'id_kelas' => 5,
            ],
            (object) [
                'id_siswa' => 7,
                'nisn' => '1234567896',
                'nis' => '2024090002',
                'nama_siswa' => 'M. Fajar',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Thamrin No. 18',
                'status' => 'aktif',
                'id_kelas' => 6,
            ],
            (object) [
                'id_siswa' => 8,
                'nisn' => '1234567897',
                'nis' => '2024100001',
                'nama_siswa' => 'Laila Fitriani',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. A. Yani No. 5',
                'status' => 'aktif',
                'id_kelas' => 2,
            ],
        ]);

        $totalSiswa = $siswas->count();
        $siswaLaki = $siswas->where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = $siswas->where('jenis_kelamin', 'P')->count();

        function getNamaKelas($idKelas, $kelasDummy)
        {
            return $kelasDummy[$idKelas] ?? 'Kelas ?';
        }
    @endphp

    <div class="container-fluid px-0">
        <!-- Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 bg-primary bg-opacity-10">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary p-3 rounded-circle me-3">
                            <i data-feather="users" class="text-white" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Siswa</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalSiswa }}</h3>
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
                            <h6 class="text-muted mb-1">Siswa Laki-laki</h6>
                            <h3 class="mb-0 fw-bold">{{ $siswaLaki }}</h3>
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
                            <h6 class="text-muted mb-1">Siswa Perempuan</h6>
                            <h3 class="mb-0 fw-bold">{{ $siswaPerempuan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter: Search dan Kelas saja -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Search:</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, NIS, NISN...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kelas</label>
                        <select name="kelas" class="form-select">
                            <option value="">Semua Kelas</option>
                            <option value="1">7A</option>
                            <option value="2">7B</option>
                            <option value="3">8A</option>
                            <option value="4">8B</option>
                            <option value="5">9A</option>
                            <option value="6">9B</option>
                        </select>
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

        <!-- Tabel Data Siswa -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">
                    <i data-feather="list" class="me-2" width="18" height="18"></i> Daftar Siswa
                </h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#importModalSiswa">
                        <i data-feather="upload" class="me-1" width="16" height="16"></i> Import Data Siswa
                    </button>
                    <button type="button" class="btn btn-sm btn-success" onclick="alert('Tambah Siswa (demo)')">
                        <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Siswa
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 20%">NISN / NIS</th>
                                <th style="width: 15%">Nama Siswa</th>
                                <th style="width: 8%">Kelas</th>
                                <th style="width: 8%">Jenis Kelamin</th>
                                <th style="width: 20%">Alamat</th>
                                <th style="width: 8%">Status</th>
                                <th style="width: 10%">Aksi</th>
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
                                    <td>{{ getNamaKelas($siswa->id_kelas, $kelasDummy) }}</td>
                                    <td>{{ $siswa->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                                    <td>{{ $siswa->alamat }}</td>
                                    <td>
                                        {{ ucfirst($siswa->status) }} <!-- teks biasa, tanpa badge -->
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary btn-edit"
                                                data-id="{{ $siswa->id_siswa }}"
                                                onclick="alert('Edit siswa: {{ $siswa->nama_siswa }}')">
                                                <i data-feather="edit-2"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger btn-hapus"
                                                data-id="{{ $siswa->id_siswa }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteSiswaModal{{ $siswa->id_siswa }}">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </div>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteSiswaModal{{ $siswa->id_siswa }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Konfirmasi Hapus</h6>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus siswa
                                                        <strong>{{ $siswa->nama_siswa }}</strong>?
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
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                        Belum ada data siswa.
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

    <!-- Modal Import Data Siswa -->
    <div class="modal fade" id="importModalSiswa" tabindex="-1" aria-labelledby="importModalSiswaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalSiswaLabel">
                        <i data-feather="upload-cloud" class="me-2" width="18" height="18"></i> Import Data
                        Siswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_excel_siswa" class="form-label fw-semibold">Upload File Excel</label>
                            <input type="file" name="file_excel" id="file_excel_siswa" class="form-control"
                                accept=".xls, .xlsx" required>
                            <div class="form-text">Format file: .xls atau .xlsx (Max. 2MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"
                            onclick="alert('Import data siswa (demo)'); return false;">
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
