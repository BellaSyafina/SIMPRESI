@extends('Layouts.template-admin')

@section('title', 'Data Sesi')

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

        {{-- HEADER --}}
        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h3 class="fw-bold mb-1"> Data Sesi Pembelajaran </h3>

                        <p class="text-muted mb-0"> Kelola sesi pertemuan berdasarkan hari dan jam pelajaran </p>
                    </div>

                    {{-- BUTTON --}}
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i data-feather="plus"></i> TambahSesi
                    </button>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form method="GET">
                    <div class="row g-3 align-items-end">

                        {{-- SEARCH --}}
                        <div class="col-lg-4">
                            <label class="form-label fw-semibold">
                                Cari Sesi
                            </label>
                            <div class="position-relative">
                                <i data-feather="search" width="16"
                                    class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"> </i>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control ps-5" placeholder="Cari sesi pertemuan...">
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="col-lg-2">
                            <a href="{{ route('sesi.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('Components.alert')

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1"> List Sesi Pembelajaran </h5>
                        <small class="text-muted"> Data sesi digunakan pada menu jadwal pelajaran </small>
                    </div>
                    <span class="badge bg-primary px-3 py-2 rounded-pill"> {{ $sesiList->total() }} Sesi </span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead style="background-color:#7C6FC4;">
                            <tr>
                                <th width="5%" class="text-white"> No </th>
                                <th class="text-white"> Sesi Pertemuan </th>
                                <th class="text-white"> Jam Mulai </th>
                                <th class="text-white"> Jam Selesai </th>
                                <th class="text-white"> Durasi </th>
                                <th class="text-center text-white"> Action </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($sesiList as $sesi)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="fw-semibold mb-0">
                                                    {{ $sesi->nama_sesi }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $sesi->keterangan ?? 'Sesi Pembelajaran' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ substr($sesi->jam_mulai, 0, 5) }}
                                    </td>
                                    <td>
                                        {{ substr($sesi->jam_selesai, 0, 5) }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($sesi->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($sesi->jam_selesai)) }}
                                        Menit
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- EDIT --}}
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                                data-id="{{ $sesi->id_sesi }}" data-nama="{{ $sesi->nama_sesi }}"
                                                data-jam_mulai="{{ substr($sesi->jam_mulai, 0, 5) }}"
                                                data-jam_selesai="{{ substr($sesi->jam_selesai, 0, 5) }}">
                                                <i data-feather="edit-2"></i>
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i data-feather="calendar" style="width: 48px; height: 48px;"
                                                class="mb-3"></i>
                                            <h6 class="fw-semibold">
                                                Belum Ada Data Sesi
                                            </h6>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($sesiList->hasPages())
                        <div class="mt-4">
                            {{ $sesiList->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH SESI --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                {{-- HEADER --}}
                <div class="modal-header bg-success text-white border-0">
                    <div>
                        <h5 class="modal-title fw-bold">
                            Tambah Sesi Pembelajaran
                        </h5>
                        <small class="text-white-50">
                            Tambahkan sesi pembelajaran baru
                        </small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                {{-- FORM --}}
                <form action="{{ route('sesi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            {{-- NAMA SESI --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    Nama Sesi
                                </label>
                                <select name="nama_sesi" class="form-select" required>
                                    <option value="">Pilih Sesi</option>
                                    <option value="Sesi 1">Sesi 1</option>
                                    <option value="Sesi 2">Sesi 2</option>
                                    <option value="Sesi 3">Sesi 3</option>
                                    <option value="Sesi 4">Sesi 4</option>
                                    <option value="Sesi 5">Sesi 5</option>
                                    <option value="Sesi 6">Sesi 6</option>
                                    <option value="Sesi 7">Sesi 7</option>
                                    <option value="Sesi 8">Sesi 8</option>
                                </select>
                            </div>
                            {{-- JAM MULAI --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Jam Mulai
                                </label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                            {{-- JAM SELESAI --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Jam Selesai
                                </label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i data-feather="save" class="me-1"></i>
                            Simpan Sesi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT SESI --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                {{-- HEADER --}}
                <div class="modal-header bg-primary text-white border-0">
                    <div>
                        <h5 class="modal-title fw-bold">
                            Edit Sesi Pembelajaran
                        </h5>
                        <small class="text-white-50">
                            Perbarui data sesi pembelajaran
                        </small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                {{-- FORM --}}
                <form method="POST" id="formEditSesi">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            {{-- NAMA SESI --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    Nama Sesi
                                </label>
                                <select name="nama_sesi" id="edit_nama_sesi" class="form-select" required>
                                    <option value="Sesi 1">Sesi 1</option>
                                    <option value="Sesi 2">Sesi 2</option>
                                    <option value="Sesi 3">Sesi 3</option>
                                    <option value="Sesi 4">Sesi 4</option>
                                    <option value="Sesi 5">Sesi 5</option>
                                    <option value="Sesi 6">Sesi 6</option>
                                    <option value="Sesi 7">Sesi 7</option>
                                    <option value="Sesi 8">Sesi 8</option>
                                </select>
                            </div>
                            {{-- JAM MULAI --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Jam Mulai
                                </label>
                                <input type="time" name="jam_mulai" id="edit_jam_mulai" class="form-control"
                                    required>
                            </div>
                            {{-- JAM SELESAI --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Jam Selesai
                                </label>
                                <input type="time" name="jam_selesai" id="edit_jam_selesai" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i data-feather="save" class="me-1"></i>
                            Update Sesi
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

            const editButtons =
                document.querySelectorAll('.btn-edit');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id =
                        this.dataset.id;

                    // 🔥 SET ACTION
                    document
                        .getElementById('formEditSesi')
                        .action =
                        `/sesi/${id}`;

                    // 🔥 SET VALUE
                    document
                        .getElementById('edit_nama_sesi')
                        .value =
                        this.dataset.nama;
                    document
                        .getElementById('edit_jam_mulai')
                        .value =
                        this.dataset.jam_mulai;
                    document
                        .getElementById('edit_jam_selesai')
                        .value =
                        this.dataset.jam_selesai;

                    // 🔥 OPEN MODAL
                    new bootstrap.Modal(
                        document.getElementById('modalEdit')
                    ).show();
                });
            });
        });
    </script>
@endpush
