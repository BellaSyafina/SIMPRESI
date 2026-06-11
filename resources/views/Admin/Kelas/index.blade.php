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

@push('style')
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
            color: white;
        }

        .card-body.bg-kelas7-soft,
        .card-footer.bg-kelas7-soft {
            background-color: #d4edda !important;
        }

        .card-header.bg-kelas8 {
            background-color: #fd7e14 !important;
            color: white;
        }

        .card-body.bg-kelas8-soft,
        .card-footer.bg-kelas8-soft {
            background-color: #ffe5d0 !important;
        }

        .card-header.bg-kelas9 {
            background-color: #0dcaf0 !important;
            color: white;
        }

        .card-body.bg-kelas9-soft,
        .card-footer.bg-kelas9-soft {
            background-color: #d1f4fb !important;
        }

        .table-sm td {
            padding: 0.3rem 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        {{-- Statistik Cards --}}
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold text-white">Total Kelas</h6>
                                <h3 class="mb-0 fw-bold text-white">{{ $totalKelas }}</h3>
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
                                <h6 class="mb-1 fw-bold text-white">Kelas 7</h6>
                                <h3 class="mb-0 fw-bold text-white">{{ $kelas7Count }}</h3>
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
                                <h6 class="mb-1 fw-bold text-white">Kelas 8</h6>
                                <h3 class="mb-0 fw-bold text-white">{{ $kelas8Count }}</h3>
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
                                <h6 class="mb-1 fw-bold text-white">Kelas 9</h6>
                                <h3 class="mb-0 fw-bold text-white">{{ $kelas9Count }}</h3>
                            </div>
                            <i data-feather="award" width="40" height="40"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol & Filter --}}
        <div class="card">
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

        @include('Components.alert')

        {{-- Daftar Kelas (Grid Card) dengan warna header sesuai tingkat --}}
        <div class="row g-3" id="kelasGrid">
            @forelse ($kelas as $item)
                @php
                    // Tentukan kelas warna untuk header berdasarkan tingkat
                    $warnaHeader = '';
                    $warnaBody = '';

                    if ($item->tingkat == '7') {
                        $warnaHeader = 'bg-kelas7';
                        $warnaBody = 'bg-kelas7-soft';
                    } elseif ($item->tingkat == '8') {
                        $warnaHeader = 'bg-kelas8';
                        $warnaBody = 'bg-kelas8-soft';
                    } elseif ($item->tingkat == '9') {
                        $warnaHeader = 'bg-kelas9';
                        $warnaBody = 'bg-kelas9-soft';
                    }
                @endphp
                <div class="col-md-6 col-lg-4 kelas-card" data-tingkat="{{ $item->tingkat }}">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header {{ $warnaHeader }}">
                            {{ $item->nama_kelas }}
                        </div>
                        <div class="card-body {{ $warnaBody }}">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td width="35%">Wali Kelas</td>
                                    <td>: {{ $item->guru->nama_guru ?? 'Tidak ada' }}</td>
                                </tr>
                                <tr>
                                    <td>Ruang</td>
                                    <td>: {{ $item->ruang }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Siswa</td>
                                    <td>: {{ $item->siswa_count }} siswa</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer {{ $warnaBody }} d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-primary btn-edit" data-id="{{ $item->id_kelas }}"
                                data-nama="{{ $item->nama_kelas }}" data-guru="{{ $item->id_guru }}"
                                data-ruang="{{ $item->ruang }}" data-tingkat="{{ $item->tingkat }}">
                                <i data-feather="edit-2"></i> Edit
                            </button>
                            <a href="{{ route('kelas.detail', $item->id_kelas) }}" class="btn btn-outline-info">
                                <i data-feather="eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="modalDetailKelas{{ $item->id_kelas }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Detail Kelas {{ $item->nama_kelas }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <table class="table table-sm table-borderless mb-3">
                                    <tr>
                                        <td width="30%">Nama Kelas</td>
                                        <td>: {{ $item->nama_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <td>Wali Kelas</td>
                                        <td>: {{ $item->guru->nama_guru ?? 'Tidak ada' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ruang</td>
                                        <td>: {{ $item->ruang ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Siswa</td>
                                        <td>: {{ $item->siswa_count }} siswa</td>
                                    </tr>
                                </table>

                                <h6 class="fw-bold mb-3">Daftar Siswa</h6>

                                <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="8%">No</th>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th>Jenis Kelamin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($item->siswa as $siswa)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $siswa->nis }}</td>
                                                    <td>{{ $siswa->nama_siswa }}</td>
                                                    <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">
                                                        Belum ada siswa di kelas ini.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>

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
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" name="nama_kelas" class="form-control"
                                placeholder="Masukkan Nama Kelas">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="id_guru">Wali Kelas</label>
                            <select name="id_guru" id="id_guru" class="form-select">
                                <option value="" selected disabled>Pilih Wali Kelas</option>
                                @foreach ($guru as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ruang</label>
                            <input type="text" name="ruang" class="form-control" placeholder="R.7A">
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

    <div class="modal fade" id="modalEditKelas" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="edit_nama" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Wali Kelas</label>
                            <select name="id_guru" id="edit_guru" class="form-select">
                                <option value="">Pilih</option>
                                @foreach ($guru as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Ruang</label>
                            <input type="text" name="ruang" id="edit_ruang" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Tingkat</label>
                            <select name="tingkat" id="edit_tingkat" class="form-select">
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

            // EDIT
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {

                    let id = this.dataset.id;

                    document.getElementById('edit_nama').value = this.dataset.nama;
                    document.getElementById('edit_ruang').value = this.dataset.ruang;
                    document.getElementById('edit_tingkat').value = this.dataset.tingkat;
                    document.getElementById('edit_guru').value = this.dataset.guru;

                    document.getElementById('formEdit').action = '/kelas/' + id;

                    new bootstrap.Modal(document.getElementById('modalEditKelas')).show();
                    feather.replace();
                });
            });
        });
    </script>
@endpush
