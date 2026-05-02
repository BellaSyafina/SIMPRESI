@extends('Layouts.template-admin')

@section('title', 'Mata Pelajaran')

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
    <div class="row">

        {{-- 🔥 STATISTIK --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i data-feather="book" class="mb-2"></i>
                    <h6 class="text-muted">Total Mata Pelajaran</h6>
                    <h3 class="fw-bold">{{ $totalMapel }}</h3>
                </div>
            </div>
        </div>

    </div>

    @include('Components.alert')

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- 🔍 SEARCH + BUTTON --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form action="{{ route('mata-pelajaran.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari mata pelajaran..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary">Search</button>
                    <a href="{{ route('mata-pelajaran.index') }}" class="btn btn-secondary">Reset</a>
                </form>

                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i data-feather="plus"></i> Tambah
                </button>
            </div>

            {{-- 📋 TABEL --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mapel as $index => $item)
                            <tr>
                                <td>{{ $mapel->firstItem() + $index }}</td>
                                <td>{{ $item->nama_mata_pelajaran }}</td>
                                <td class="text-center">

                                    {{-- EDIT --}}
                                    <button class="btn btn-sm btn-warning btn-edit" data-id="{{ $item->id_mata_pelajaran }}"
                                        data-nama="{{ $item->nama_mata_pelajaran }}">
                                        <i data-feather="edit"></i>
                                    </button>

                                    {{-- HAPUS --}}
                                    <button class="btn btn-sm btn-danger btn-hapus"
                                        data-id="{{ $item->id_mata_pelajaran }}">
                                        <i data-feather="trash"></i>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $mapel->links() }}
            </div>

        </div>
    </div>

    {{-- ========================= MODAL TAMBAH ========================= --}}
    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('mata-pelajaran.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mata_pelajaran" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ========================= MODAL EDIT ========================= --}}
    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formEdit">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Mata Pelajaran</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mata_pelajaran" id="edit_nama" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- ========================= MODAL HAPUS ========================= --}}
    <div class="modal fade" id="modalHapus">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Hapus Data</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Yakin ingin menghapus data ini?
                </div>

                <div class="modal-footer">
                    <form method="POST" id="formHapus">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // EDIT
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {

                    let id = this.dataset.id;
                    let nama = this.dataset.nama;

                    document.getElementById('edit_nama').value = nama;

                    // 🔥 FIX ROUTE
                    document.getElementById('formEdit').action = `/mata-pelajaran/${id}/update`;

                    new bootstrap.Modal(document.getElementById('modalEdit')).show();
                });
            });

            // HAPUS
            document.querySelectorAll('.btn-hapus').forEach(btn => {
                btn.addEventListener('click', function() {

                    let id = this.dataset.id;

                    // 🔥 FIX ROUTE
                    document.getElementById('formHapus').action = `/mata-pelajaran/${id}/delete`;

                    new bootstrap.Modal(document.getElementById('modalHapus')).show();
                });
            });

        });
    </script>
@endpush
