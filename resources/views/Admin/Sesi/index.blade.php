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
                <div class="row g-3 align-items-end">

                    {{-- SEARCH --}}
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            Cari Sesi
                        </label>

                        <div class="position-relative">
                            <i data-feather="search" width="16"
                                class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"> </i>
                            <input type="text" class="form-control ps-5" placeholder="Cari sesi pertemuan...">
                        </div>
                    </div>

                    {{-- FILTER HARI --}}
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold"> Filter Hari </label>
                        <select class="form-select">
                            <option selected> Semua Hari </option>
                            <option>Senin</option>
                            <option>Selasa</option>
                            <option>Rabu</option>
                            <option>Kamis</option>
                            <option>Jumat</option>
                            <option>Sabtu</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">
                            Status
                        </label>
                        <select class="form-select">
                            <option selected> Semua Status </option>
                            <option>Tersedia</option>
                            <option>Sudah Digunakan</option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="col-lg-2">
                        <a href="#" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1"> List Sesi Pembelajaran </h5>
                        <small class="text-muted"> Data sesi digunakan pada menu jadwal pelajaran </small>
                    </div>

                    <span class="badge bg-primary px-3 py-2 rounded-pill"> 12 Sesi </span>
                </div>

            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th width="5%"> No </th>
                                <th> Sesi Pertemuan </th>
                                <th> Hari </th>
                                <th> Jam Mulai </th>
                                <th> Jam Selesai </th>
                                <th> Durasi </th>
                                <th> Status </th>
                                <th class="text-center"> Action </th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- ITEM --}}
                            <tr>
                                <td> 1 </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fw-semibold mb-0">
                                                Sesi Pertemuan 1
                                            </h6>
                                            <small class="text-muted">
                                                Shift Pagi
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td> <span class="badge bg-light-primary text-primary px-3 py-2"> Senin </span> </td>
                                <td> 07:00 </td>
                                <td> 08:30 </td>
                                <td> 90 Menit </td>
                                <td> <span class="badge bg-success px-3 py-2"> Tersedia </span> </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- EDIT --}}
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit">
                                            <i data-feather="edit-2"></i> Edit
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="#">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- ITEM --}}
                            <tr>
                                <td> 2 </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="fw-semibold mb-0"> Sesi Pertemuan 2 </h6>
                                            <small class="text-muted"> Shift Pagi </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-light-warning text-warning px-3 py-2"> Selasa </span>
                                </td>
                                <td> 08:30 </td>
                                <td> 10:00 </td>
                                <td> 90 Menit </td>

                                <td>
                                    {{-- KETIKA SUDAH DIPAKAI DI JADWAL --}}
                                    <span class="badge bg-danger px-3 py-2"> Sudah Digunakan </span>

                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- EDIT --}}
                                        <button type="button" class="btn btn-sm btn-outline-primary btn-edit">
                                            <i data-feather="edit-2"></i> Edit
                                        </button>

                                        {{-- DELETE --}}
                                        <form action="#">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i data-feather="trash-2"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
