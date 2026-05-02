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
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 bg-primary bg-opacity-10">
                <div class="card-body text-center">
                    <i data-feather="book" class="mb-2" width="32" height="32"></i>
                    <h6 class="mb-1 fw-bold text-white"">Total Mata Pelajaran</h6>
                    <h3 class="mb-0 fw-bold text-white">{{ $totalMapel ?? $mapel->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    @include('Components.alert')

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- SEARCH + BUTTON --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
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

            {{-- TABEL --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Nama Mata Pelajaran</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mapel as $index => $item)
                            <tr>
                                <td class="text-center">{{ $item->id_mata_pelajaran }}</td>
                                <td>{{ $item->nama_mata_pelajaran }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Tombol Edit (buka modal) -->
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                            data-id="{{ $item->id_mata_pelajaran }}"
                                            data-nama="{{ $item->nama_mata_pelajaran }}">
                                            <i data-feather="edit-2"></i> Edit
                                        </button>

                                        <!-- Form Hapus dengan confirm -->
                                        <form action="{{ route('mata-pelajaran.destroy', $item->id_mata_pelajaran) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus data mata pelajaran ini?')"
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
                                <td colspan="4" class="text-center text-muted py-4">Belum ada data mata pelajaran.</td>
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

    {{-- MODAL TAMBAH --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('mata-pelajaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mata_pelajaran" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formEdit">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        {{-- 🔥 ID (tidak bisa diedit, tapi ikut terkirim) --}}
                        <input type="hidden" name="id_mata_pelajaran" id="edit_id">

                        {{-- 🔥 Optional: tampilkan ID (readonly, biar user lihat) --}}
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" id="edit_id_display" class="form-control" readonly>
                        </div>

                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mata_pelajaran" id="edit_nama" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus data mata pelajaran ini?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="formHapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;

                    const formEdit = document.getElementById('formEdit');

                    // set action route
                    formEdit.action = `/mata-pelajaran/${id}`;

                    // isi input
                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_id_display').value = id;
                    document.getElementById('edit_nama').value = nama;

                    // tampilkan modal
                    const modal = new bootstrap.Modal(document.getElementById('modalEdit'));
                    modal.show();
                });
            });
        });
    </script>
@endpush
