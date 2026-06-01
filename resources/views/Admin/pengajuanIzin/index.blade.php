@extends('Layouts.template-admin')

@section('title', 'Pengajuan Izin')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>

        <li class="breadcrumb-item f-w-400 active">
            @yield('title')
        </li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid px-0">

        {{-- HEADER --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

            <div class="card-body p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Pengajuan Izin / Sakit
                        </h4>

                        <p class="text-muted mb-0">

                            Upload surat izin atau surat sakit siswa untuk
                            keperluan absensi sekolah.

                        </p>

                    </div>

                    <div>

                        <span class="badge bg-primary-subtle text-primary px-4 py-3 rounded-pill">

                            <i data-feather="calendar" class="me-1" width="16" height="16"></i>

                            {{ now()->translatedFormat('d F Y') }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="row g-4">

            {{-- FORM --}}
            <div class="col-lg-5">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-primary text-white border-0 py-3">

                        <h5 class="mb-0 fw-bold text-white">

                            Form Pengajuan

                        </h5>

                    </div>

                    <div class="card-body p-4">

                        {{-- ALERT --}}
                        @include('Components.alert')

                        <form action="{{ route('pengajuan-izin.store') }}" method="POST" enctype="multipart/form-data">

                            @csrf

                            {{-- TANGGAL --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Tanggal Izin

                                </label>

                                <input type="date" name="tanggal"
                                    class="form-control rounded-3 @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', now()->format('Y-m-d')) }}">

                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- JENIS --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Jenis Pengajuan

                                </label>

                                <select name="jenis" class="form-select rounded-3 @error('jenis') is-invalid @enderror">

                                    <option value="">
                                        -- Pilih Jenis --
                                    </option>

                                    <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>

                                        Izin

                                    </option>

                                    <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>

                                        Sakit

                                    </option>

                                </select>

                                @error('jenis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- KETERANGAN --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">

                                    Keterangan

                                </label>

                                <textarea name="keterangan" rows="4" class="form-control rounded-3 @error('keterangan') is-invalid @enderror"
                                    placeholder="Masukkan alasan izin / sakit">{{ old('keterangan') }}</textarea>

                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- FILE --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold">

                                    Upload Surat

                                </label>

                                <input type="file" name="file_surat"
                                    class="form-control rounded-3 @error('file_surat') is-invalid @enderror"
                                    accept=".pdf,.jpg,.jpeg,.png">

                                <small class="text-muted">

                                    Format: PDF, JPG, JPEG, PNG
                                    (Max 2MB)

                                </small>

                                @error('file_surat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            {{-- BUTTON --}}
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">

                                <i data-feather="send" class="me-1" width="18" height="18"></i>

                                Kirim Pengajuan

                            </button>

                        </form>

                    </div>

                </div>

            </div>

            {{-- RIWAYAT --}}
            <div class="col-lg-7">

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-header bg-white border-0 py-3">

                        <h5 class="mb-0 fw-bold">

                            Riwayat Pengajuan Izin

                        </h5>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th>No</th>

                                        <th>Tanggal</th>

                                        <th>Jenis</th>

                                        <th>Status</th>

                                        <th>File</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($pengajuanList ?? [] as $item)
                                        <tr>

                                            <td width="60">

                                                {{ $loop->iteration }}

                                            </td>

                                            <td>

                                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}

                                            </td>

                                            <td>

                                                @if ($item->jenis == 'izin')
                                                    <span class="badge bg-warning">

                                                        Izin

                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">

                                                        Sakit

                                                    </span>
                                                @endif

                                            </td>

                                            <td>

                                                @if ($item->status_verifikasi == 'pending')
                                                    <span class="badge bg-secondary">

                                                        Pending

                                                    </span>
                                                @elseif($item->status_verifikasi == 'diterima')
                                                    <span class="badge bg-success">

                                                        Diterima

                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">

                                                        Ditolak

                                                    </span>
                                                @endif

                                            </td>

                                            <td>

                                                <a href="{{ asset('storage/' . $item->file_surat) }}" target="_blank"
                                                    class="btn btn-sm btn-danger rounded-pill">

                                                    <i data-feather="file-text" width="14" height="14"></i>

                                                    Lihat

                                                </a>

                                            </td>

                                        </tr>
                                    @empty
                                        <tr>

                                            <td colspan="5" class="text-center py-5 text-muted">

                                                Belum ada pengajuan izin.

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

    </div>
@endsection
