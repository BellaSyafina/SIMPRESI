@extends('Layouts.template-admin')

@section('title', 'Settings')

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

        <div class="row g-4">

            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="nav flex-column nav-pills gap-2" id="settings-tab" role="tablist">
                            {{-- GENERAL --}}
                            <button class="nav-link active text-start" data-bs-toggle="pill" data-bs-target="#general">
                                <i data-feather="user" width="16" class="me-2"></i>
                                General
                            </button>

                            {{-- PASSWORD --}}
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#password">
                                <i data-feather="lock" width="16" class="me-2"></i>
                                Password
                            </button>

                            {{-- SECURITY --}}
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#security">
                                <i data-feather="shield" width="16" class="me-2"></i>
                                Security
                            </button>

                            {{-- SESSION --}}
                            <button class="nav-link text-start" data-bs-toggle="pill" data-bs-target="#session">
                                <i data-feather="monitor" width="16" class="me-2"></i>
                                Login Session
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="col-lg-9">
                <div class="tab-content">

                    {{-- GENERAL --}}
                    <div class="tab-pane fade show active" id="general">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">

                                {{-- HEADER --}}
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                    <div>
                                        <h4 class="fw-bold mb-1">
                                            General Settings
                                        </h4>
                                        <p class="text-muted mb-0">
                                            Kelola informasi umum akun Anda
                                        </p>
                                    </div>

                                    {{-- STATUS --}}
                                    <span class="badge bg-success px-3 py-2 rounded-pill">
                                        Active Account
                                    </span>
                                </div>

                                {{-- FORM --}}
                                <div class="row g-4">

                                    {{-- NAMA --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Nama Lengkap
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text border-0">
                                                <i data-feather="user" width="16"></i>
                                            </span>

                                            <input type="text" class="form-control border-0"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>

                                    {{-- EMAIL --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Email
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text border-0">
                                                <i data-feather="mail" width="16"></i>
                                            </span>

                                            <input type="email" class="form-control border-0"
                                                value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>

                                    {{-- ROLE --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Role
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text border-0">
                                                <i data-feather="shield" width="16"></i>
                                            </span>

                                            <input type="text" class="form-control border-0 text-capitalize"
                                                value="{{ Auth::user()->role }}" disabled>
                                        </div>
                                    </div>

                                    {{-- STATUS --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Status Akun
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text border-0">
                                                <i data-feather="check-circle" width="16"></i>
                                            </span>

                                            <input type="text" class="form-control border-0 text-success fw-semibold"
                                                value="Active" disabled>
                                        </div>
                                    </div>

                                    {{-- LAST UPDATE --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Terakhir Diperbarui
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text border-0">
                                                <i data-feather="clock" width="16"></i>
                                            </span>

                                            <input type="text" class="form-control border-0"
                                                value="{{ Auth::user()->updated_at->translatedFormat('d F Y') }}" disabled>
                                        </div>
                                    </div>

                                    {{-- CREATED --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Bergabung Sejak
                                        </label>

                                        <div class="input-group">
                                            <span class="input-group-text border-0">
                                                <i data-feather="calendar" width="16"></i>
                                            </span>

                                            <input type="text" class="form-control border-0"
                                                value="{{ Auth::user()->created_at->translatedFormat('d F Y') }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                {{-- BUTTON --}}
                                <div class="border-top pt-4 mt-5">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-primary px-4 py-2 rounded-pill shadow-sm d-flex align-items-center">
                                            <i data-feather="save" width="16" height="16" class="me-2"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="tab-pane fade" id="password">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4">
                                    Change Password
                                </h4>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Password Lama
                                    </label>

                                    <input type="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Password Baru
                                    </label>

                                    <input type="password" class="form-control">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        Konfirmasi Password
                                    </label>

                                    <input type="password" class="form-control">
                                </div>

                                <button class="btn btn-primary px-4">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- SECURITY --}}
                    <div class="tab-pane fade" id="security">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-4">
                                    Security Settings
                                </h4>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label">
                                        Verifikasi Login
                                    </label>
                                </div>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">
                                        Email Login Notification
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SESSION --}}
                    <div class="tab-pane fade" id="session">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-4">
                                    <div>
                                        <h4 class="fw-bold mb-1">
                                            Login Session
                                        </h4>

                                        <p class="text-muted mb-0">
                                            Device yang sedang login
                                        </p>
                                    </div>

                                    <button class="btn btn-danger">
                                        Logout All Device
                                    </button>
                                </div>

                                {{-- DEVICE --}}
                                <div class="border rounded-4 p-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6 class="fw-semibold mb-1">
                                                Windows • Chrome
                                            </h6>

                                            <small class="text-muted">
                                                127.0.0.1 • Active Now
                                            </small>
                                        </div>

                                        <span class="badge bg-success">
                                            Current Device
                                        </span>
                                    </div>
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
