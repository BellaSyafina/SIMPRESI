@extends('Layouts.template-admin')

@section('title', 'Data Kelas')

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
    <style>
        /* Custom styling untuk card */
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            font-weight: 600;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Warna header card sesuai tingkat */
        .card-header.bg-kelas7 {
            background-color: #28a745 !important;
            /* hijau */
            color: white;
        }

        .card-header.bg-kelas8 {
            background-color: #fd7e14 !important;
            /* orange */
            color: white;
        }

        .card-header.bg-kelas9 {
            background-color: #0dcaf0 !important;
            /* biru muda */
            color: white;
        }

        .table-sm td {
            padding: 0.3rem 0;
        }
    </style>

    @php
        // DATA DUMMY UNTUK FRONTEND (hapus nanti jika sudah pakai database)
        $kelas = [
            (object) [
                'id_kelas' => 1,
                'nama_kelas' => '7A',
                'wali_kelas' => 'Budi Santoso, S.Pd',
                'ruang' => 'R.7A',
                'jumlah_siswa' => 32,
                'tingkat' => '7',
            ],
            (object) [
                'id_kelas' => 2,
                'nama_kelas' => '7B',
                'wali_kelas' => 'Siti Aminah, S.Pd',
                'ruang' => 'R.7B',
                'jumlah_siswa' => 30,
                'tingkat' => '7',
            ],
            (object) [
                'id_kelas' => 3,
                'nama_kelas' => '7C',
                'wali_kelas' => 'Drs. Ahmad Fauzi',
                'ruang' => 'R.7C',
                'jumlah_siswa' => 28,
                'tingkat' => '7',
            ],
            (object) [
                'id_kelas' => 4,
                'nama_kelas' => '7D',
                'wali_kelas' => 'Dra. Rina Marlina',
                'ruang' => 'R.7D',
                'jumlah_siswa' => 31,
                'tingkat' => '7',
            ],
            (object) [
                'id_kelas' => 5,
                'nama_kelas' => '8A',
                'wali_kelas' => 'Muhammad Iqbal, S.Pd',
                'ruang' => 'R.8A',
                'jumlah_siswa' => 29,
                'tingkat' => '8',
            ],
            (object) [
                'id_kelas' => 6,
                'nama_kelas' => '8B',
                'wali_kelas' => 'Laila Fitriani, S.Pd',
                'ruang' => 'R.8B',
                'jumlah_siswa' => 27,
                'tingkat' => '8',
            ],
            (object) [
                'id_kelas' => 7,
                'nama_kelas' => '8C',
                'wali_kelas' => 'Drs. Heru Susanto',
                'ruang' => 'R.8C',
                'jumlah_siswa' => 30,
                'tingkat' => '8',
            ],
            (object) [
                'id_kelas' => 8,
                'nama_kelas' => '9A',
                'wali_kelas' => 'Eka Prasetya, M.Pd',
                'ruang' => 'R.9A',
                'jumlah_siswa' => 33,
                'tingkat' => '9',
            ],
            (object) [
                'id_kelas' => 9,
                'nama_kelas' => '9B',
                'wali_kelas' => 'Dewi Sartika, S.Pd',
                'ruang' => 'R.9B',
                'jumlah_siswa' => 32,
                'tingkat' => '9',
            ],
            (object) [
                'id_kelas' => 10,
                'nama_kelas' => '9C',
                'wali_kelas' => 'Agus Salim, S.Ag',
                'ruang' => 'R.9C',
                'jumlah_siswa' => 29,
                'tingkat' => '9',
            ],
            (object) [
                'id_kelas' => 11,
                'nama_kelas' => '9D',
                'wali_kelas' => 'Nurul Hikmah, S.Pd',
                'ruang' => 'R.9D',
                'jumlah_siswa' => 31,
                'tingkat' => '9',
            ],
        ];

        $totalKelas = count($kelas);
        $kelas7Count = count(array_filter($kelas, fn($item) => $item->tingkat == '7'));
        $kelas8Count = count(array_filter($kelas, fn($item) => $item->tingkat == '8'));
        $kelas9Count = count(array_filter($kelas, fn($item) => $item->tingkat == '9'));
    @endphp

    <div class="container-fluid">
        {{-- Statistik Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">Total Kelas</h6>
                                <h3 class="mb-0 fw-bold">{{ $totalKelas }}</h3>
                            </div>
                            <i data-feather="grid" width="40" height="40"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">Kelas 7</h6>
                                <h3 class="mb-0 fw-bold">{{ $kelas7Count }}</h3>
                            </div>
                            <i data-feather="book-open" width="40" height="40"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">Kelas 8</h6>
                                <h3 class="mb-0 fw-bold">{{ $kelas8Count }}</h3>
                            </div>
                            <i data-feather="users" width="40" height="40"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">Kelas 9</h6>
                                <h3 class="mb-0 fw-bold">{{ $kelas9Count }}</h3>
                            </div>
                            <i data-feather="award" width="40" height="40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol & Filter --}}
        <div class="card mb-4">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
                <button class="btn btn-primary d-inline-flex align-items-center gap-1" data-bs-toggle="modal"
                    data-bs-target="#modalTambahKelas">
                    <i data-feather="plus"></i> Tambah Kelas
                </button>
                <div class="d-flex gap-2 align-items-center">
                    <select class="form-select w-auto" id="filterTingkat">
                        <option value="all">Semua Tingkat</option>
                        <option value="7">Kelas 7</option>
                        <option value="8">Kelas 8</option>
                        <option value="9">Kelas 9</option>
                    </select>
                    <button class="btn btn-outline-secondary d-inline-flex align-items-center gap-1" type="button"
                        id="btnFilter">
                        <i data-feather="filter"></i> Filter
                    </button>
                </div>
            </div>
        </div>

        {{-- Daftar Kelas (Grid Card) dengan warna header sesuai tingkat --}}
        <div class="row g-4" id="kelasGrid">
            @forelse ($kelas as $item)
                @php
                    // Tentukan kelas warna untuk header berdasarkan tingkat
                    $warnaHeader = '';
                    if ($item->tingkat == '7') {
                        $warnaHeader = 'bg-kelas7';
                    } elseif ($item->tingkat == '8') {
                        $warnaHeader = 'bg-kelas8';
                    } elseif ($item->tingkat == '9') {
                        $warnaHeader = 'bg-kelas9';
                    }
                @endphp
                <div class="col-md-6 col-lg-4 kelas-card" data-tingkat="{{ $item->tingkat }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header {{ $warnaHeader }}">
                            {{ $item->nama_kelas }}
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="35%">Wali Kelas</td>
                                    <td>: {{ $item->wali_kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Ruang</td>
                                    <td>: {{ $item->ruang }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Siswa</td>
                                    <td>: {{ $item->jumlah_siswa }} siswa</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-primary btn-edit" data-id="{{ $item->id_kelas }}">
                                <i data-feather="edit-2"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $item->id_kelas }}">
                                <i data-feather="trash-2"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i data-feather="folder" width="48" height="48"></i>
                    <p class="mt-2 text-muted">Belum ada data kelas.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Tambah Kelas --}}
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control" placeholder="Masukkan Nama Kelas">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control" placeholder="Masukkan Nama Wali-Kelas">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ruang</label>
                            <input type="text" name="ruang" class="form-control" placeholder="R.7A">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Siswa</label>
                            <input type="number" name="jumlah_siswa" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tingkat</label>
                            <select name="tingkat" class="form-select">
                                <option value="">Pilih Tingkat</option>
                                <option value="7">Kelas 7</option>
                                <option value="8">Kelas 8</option>
                                <option value="9">Kelas 9</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Filter
        document.getElementById('btnFilter')?.addEventListener('click', function() {
            let filter = document.getElementById('filterTingkat').value;
            let cards = document.querySelectorAll('.kelas-card');
            cards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = '';
                } else {
                    let tingkat = card.getAttribute('data-tingkat');
                    card.style.display = tingkat === filter ? '' : 'none';
                }
            });
        });

        // Refresh feather icons setelah modal terbuka
        document.getElementById('modalTambahKelas')?.addEventListener('shown.bs.modal', function() {
            feather.replace();
        });
    </script>
@endpush
