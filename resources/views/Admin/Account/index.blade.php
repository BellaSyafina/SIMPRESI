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

        @include('Components.alert')

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
                                <img src="{{ $user->foto ? asset('uploads/foto/' . $user->foto) : asset('assets/images/dashboard/user/1.jpg') }}"
                                    class="rounded-circle border border-5 border-white shadow" width="140" height="140"
                                    style="object-fit: cover;">

                                {{-- BUTTON EDIT --}}
                                <label class="btn btn-primary btn-sm mt-3 px-3 rounded-pill shadow-sm">

                                    <i data-feather="camera" width="14" height="14" class="me-1"></i>

                                    Edit Profile

                                    <form action="{{ route('account.uploadFoto') }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf

                                        <input type="file" name="foto" onchange="this.form.submit()" hidden>

                                    </form>
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
                                {{ $user->last_login_at ? $user->last_login_at->translatedFormat('d F Y • H:i') : 'Belum pernah login' }}
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

                        @forelse ($activities as $activity)
                            @php

                                $icon = 'shield';
                                $bg = 'primary';

                                if (str_contains(strtolower($activity->activity), 'login')) {
                                    $icon = 'log-in';
                                    $bg = 'success';
                                }

                                if (str_contains(strtolower($activity->activity), 'logout')) {
                                    $icon = 'log-out';
                                    $bg = 'danger';
                                }

                            @endphp

                            <div class="d-flex mb-4">

                                <div class="me-3">
                                    <div class="bg-{{ $bg }} bg-opacity-10 rounded-circle p-3">

                                        <i data-feather="{{ $icon }}" width="18" height="18"></i>

                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <div>
                                            <h6 class="fw-semibold mb-1">
                                                {{ $activity->activity }}
                                            </h6>
                                            <small class="text-muted">
                                                {{ $activity->description }}
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            {{ $activity->created_at->translatedFormat('d F Y • H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                Belum ada aktivitas login
                            </div>
                        @endforelse
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
