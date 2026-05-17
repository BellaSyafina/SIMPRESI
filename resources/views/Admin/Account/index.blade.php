@extends('Layouts.template-admin')

@section('title', 'Account')

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
    <div class="container-fluid px-0">

        {{-- PROFILE HEADER --}}
        <div class="card border-0 shadow-sm overflow-hidden mb-4">

            {{-- Background --}}
            <div style="height: 180px; background: linear-gradient(135deg, #7367f0 0%, #9b8cff 100%);">
            </div>

            <div class="card-body position-relative">

                <div class="row align-items-end">

                    {{-- FOTO PROFILE --}}
                    <div class="col-lg-8">

                        <div class="d-flex align-items-end flex-wrap">

                            {{-- FOTO PROFILE --}}
                            <div class="d-flex flex-column align-items-center" style="margin-top: -90px;">

                                {{-- FOTO --}}
                                <img src="{{ asset('assets/images/dashboard/user/1.jpg') }}"
                                    class="rounded-circle border border-5 border-white shadow" width="140" height="140"
                                    style="object-fit: cover;">

                                {{-- BUTTON EDIT --}}
                                <label class="btn btn-primary btn-sm mt-3 px-3 rounded-pill shadow-sm">

                                    <i data-feather="camera" width="14" height="14" class="me-1"></i>

                                    Edit Profile

                                    <input type="file" hidden>
                                </label>

                            </div>

                            {{-- INFO USER --}}
                            <div class="ms-4 mb-2">

                                <h3 class="fw-bold mb-1">
                                    {{ Auth::user()->name }}
                                </h3>

                                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">

                                    <span class="badge bg-primary px-3 py-2 text-uppercase">
                                        {{ Auth::user()->role }}
                                    </span>

                                    <span class="badge bg-success px-3 py-2">
                                        Active
                                    </span>

                                </div>

                                <p class="text-muted mb-0">
                                    {{ Auth::user()->email }}
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- STATUS LOGIN --}}
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                        <div class="d-inline-block bg-light rounded-4 px-4 py-3">

                            <small class="text-muted d-block mb-1">
                                Last Login
                            </small>

                            <h6 class="fw-bold mb-0">
                                17 Mei 2026 • 21:10
                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="row g-4">

            {{-- INFORMASI AKUN --}}
            <div class="col-lg-4 d-flex">

                <div class="card border-0 shadow-sm w-100">

                    {{-- HEADER --}}
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i data-feather="user" class="me-2" width="18"></i>
                            Informasi Akun
                        </h5>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body d-flex flex-column">

                        {{-- ITEM --}}
                        <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                            <label class="text-muted small d-block mb-1">
                                Nama Lengkap
                            </label>

                            <h6 class="fw-semibold mb-0">
                                {{ Auth::user()->name }}
                            </h6>

                        </div>

                        {{-- ITEM --}}
                        <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                            <label class="text-muted small d-block mb-1">
                                Email
                            </label>

                            <h6 class="fw-semibold mb-0">
                                {{ Auth::user()->email }}
                            </h6>

                        </div>

                        {{-- ITEM --}}
                        <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                            <label class="text-muted small d-block mb-1">
                                Role
                            </label>

                            <h6 class="fw-semibold text-capitalize mb-0">
                                {{ Auth::user()->role }}
                            </h6>

                        </div>

                        {{-- ITEM --}}
                        <div class="mb-4 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                            <label class="text-muted small d-block mb-1">
                                Status Akun
                            </label>

                            <h6 class="fw-semibold text-success mb-0">
                                Active
                            </h6>

                        </div>

                        {{-- PASSWORD --}}
                        <div class="mt-auto">

                            <label class="text-muted small d-block mb-1">
                                Password Terakhir Diubah
                            </label>

                            <h6 class="fw-semibold mb-3">
                                {{ Auth::user()->updated_at->translatedFormat('d F Y') }}
                            </h6>

                            <a href="{{ route('settings.index') }}"
                                class="btn btn-outline-primary btn-sm rounded-pill px-3">

                                <i data-feather="lock" width="14" height="14" class="me-1"></i>

                                Ubah Password

                            </a>

                        </div>

                    </div>

                </div>

            </div>

            {{-- RIWAYAT LOGIN --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">

                            <h5 class="fw-bold mb-0">
                                <i data-feather="clock" class="me-2" width="18"></i>
                                Riwayat Aktivitas Login
                            </h5>

                            <span class="badge bg-light text-dark border">
                                5 Aktivitas Terakhir
                            </span>

                        </div>
                    </div>

                    <div class="card-body">

                        {{-- ITEM --}}
                        <div class="d-flex mb-4">

                            <div class="me-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="log-in" width="18" height="18"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between flex-wrap">

                                    <div>
                                        <h6 class="fw-semibold mb-1">
                                            Login Berhasil
                                        </h6>

                                        <small class="text-muted">
                                            Login ke sistem SIMPRESI
                                        </small>
                                    </div>

                                    <small class="text-muted">
                                        17 Mei 2026 • 21:10
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- ITEM --}}
                        <div class="d-flex mb-4">

                            <div class="me-3">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="log-out" width="18" height="18"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between flex-wrap">

                                    <div>
                                        <h6 class="fw-semibold mb-1">
                                            Logout
                                        </h6>

                                        <small class="text-muted">
                                            Keluar dari sistem
                                        </small>
                                    </div>

                                    <small class="text-muted">
                                        17 Mei 2026 • 20:45
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- ITEM --}}
                        <div class="d-flex mb-4">

                            <div class="me-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="shield" width="18" height="18"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between flex-wrap">

                                    <div>
                                        <h6 class="fw-semibold mb-1">
                                            Session Verified
                                        </h6>

                                        <small class="text-muted">
                                            Sistem memverifikasi keamanan akun
                                        </small>
                                    </div>

                                    <small class="text-muted">
                                        16 Mei 2026 • 18:20
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- ITEM --}}
                        <div class="d-flex mb-4">

                            <div class="me-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="log-in" width="18" height="18"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between flex-wrap">

                                    <div>
                                        <h6 class="fw-semibold mb-1">
                                            Login Berhasil
                                        </h6>

                                        <small class="text-muted">
                                            Login menggunakan browser Chrome
                                        </small>
                                    </div>

                                    <small class="text-muted">
                                        16 Mei 2026 • 18:15
                                    </small>

                                </div>

                            </div>

                        </div>

                        {{-- ITEM --}}
                        <div class="d-flex">

                            <div class="me-3">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="log-out" width="18" height="18"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">

                                <div class="d-flex justify-content-between flex-wrap">

                                    <div>
                                        <h6 class="fw-semibold mb-1">
                                            Logout
                                        </h6>

                                        <small class="text-muted">
                                            Keluar dari akun admin
                                        </small>
                                    </div>

                                    <small class="text-muted">
                                        15 Mei 2026 • 22:11
                                    </small>

                                </div>

                            </div>

                        </div>

                    </div>

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
