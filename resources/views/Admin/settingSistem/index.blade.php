@extends('Layouts.template-admin')

@section('title', 'Setting Sistem')

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
    <div class="container-fluid">

        <div class="row">

            <div class="col-xl-8 mx-auto">

                @include('Components.alert')

                <div class="card border-0 shadow-sm rounded-4">

                    {{-- HEADER --}}
                    <div class="card-header bg-white border-0 py-4">

                        <div class="d-flex align-items-center">

                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">

                                <i data-feather="settings"></i>

                            </div>

                            <div>

                                <h4 class="fw-bold mb-1">
                                    Setting Sistem
                                </h4>

                                <p class="text-muted mb-0">

                                    Kelola periode akademik aktif sistem.

                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">

                        <form action="{{ route('setting-sistem.update') }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="row g-4">

                                {{-- Nama Sekolah --}}
                                <div class="col-md-12">

                                    <label class="form-label fw-semibold">
                                        Nama Sekolah
                                    </label>

                                    <input type="text" class="form-control" name="nama_sekolah"
                                        value="{{ $setting?->nama_sekolah }}" placeholder="Masukkan nama sekolah">

                                </div>

                                {{-- Semester Aktif --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Semester Aktif
                                    </label>

                                    <select name="semester_aktif" class="form-select">

                                        <option value="Ganjil"
                                            {{ $setting?->semester_aktif == 'Ganjil' ? 'selected' : '' }}>
                                            Ganjil
                                        </option>

                                        <option value="Genap" {{ $setting?->semester_aktif == 'Genap' ? 'selected' : '' }}>
                                            Genap
                                        </option>

                                    </select>

                                </div>

                                {{-- Tahun Ajaran --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">
                                        Tahun Ajaran Aktif
                                    </label>

                                    <input type="text" class="form-control" name="tahun_ajaran_aktif"
                                        value="{{ $setting?->tahun_ajaran_aktif }}" placeholder="2025/2026">

                                </div>

                            </div>

                            {{-- BUTTON --}}
                            <div class="mt-5 text-end">

                                <button type="submit" class="btn btn-primary px-5 rounded-pill">

                                    <i data-feather="save" class="me-1"></i>

                                    Simpan Pengaturan

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
