@extends('Layouts.template-admin')

@section('title', 'Jadwal Mengajar')

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

        {{-- HEADER --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

            <div class="card-body p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Jadwal Mengajar Hari Ini
                        </h4>

                        <p class="text-muted mb-0">

                            Kelola sesi pembelajaran dan mulai absensi siswa
                            berdasarkan jadwal mengajar hari ini.

                        </p>

                    </div>

                    <div>

                        <span class="badge bg-primary-subtle text-primary px-4 py-3 rounded-pill">

                            <i data-feather="calendar" class="me-1" width="16" height="16"></i>

                            {{ now()->translatedFormat('l, d F Y') }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- JADWAL --}}
        <div class="row g-4">

            @forelse ($jadwalList as $jadwal)
                <div class="col-xl-4 col-md-6">

                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                        {{-- HEADER --}}
                        <div class="card-header bg-primary text-white border-0 py-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="mb-1 fw-bold text-white">

                                        {{ $jadwal->mataPelajaran->nama_mata_pelajaran }}

                                    </h5>

                                    <small class="text-white-50">

                                        {{ $jadwal->kelas->nama_kelas }}

                                    </small>

                                </div>

                                <div>

                                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill">

                                        {{ $jadwal->sesi?->nama_sesi ?? '-' }}

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- BODY --}}
                        <div class="card-body p-4">

                            {{-- JAM --}}
                            <div class="d-flex align-items-center mb-4">

                                <div class="icon-box bg-light-primary text-primary rounded-circle me-3">

                                    <i data-feather="clock"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Jam Pembelajaran
                                    </small>

                                    <div class="fw-semibold">

                                        {{ \Carbon\Carbon::parse($jadwal->sesi?->jam_mulai)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($jadwal->sesi?->jam_selesai)->format('H:i') }}

                                    </div>

                                </div>

                            </div>

                            {{-- HARI --}}
                            <div class="d-flex align-items-center mb-4">

                                <div class="icon-box bg-light-success text-success rounded-circle me-3">

                                    <i data-feather="calendar"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Hari
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $jadwal->hari }}

                                    </div>

                                </div>

                            </div>

                            {{-- SEMESTER --}}
                            <div class="d-flex align-items-center mb-4">

                                <div class="icon-box bg-light-warning text-warning rounded-circle me-3">

                                    <i data-feather="book-open"></i>

                                </div>

                                <div>

                                    <small class="text-muted d-block">
                                        Semester
                                    </small>

                                    <div class="fw-semibold">

                                        {{ $jadwal->semester }}

                                        •

                                        {{ $jadwal->tahun_ajaran }}

                                    </div>

                                </div>

                            </div>

                            {{-- PERTEMUAN --}}
                            @php

                                $pertemuanHariIni = \App\Models\PertemuanPelajaran::where(
                                    'id_jadwal_pelajaran',
                                    $jadwal->id_jadwal_pelajaran,
                                )
                                    ->whereDate('tanggal', now())
                                    ->first();

                                $totalSiswa = $jadwal->kelas->siswa()->count();

                                $totalAbsensi = $pertemuanHariIni
                                    ? \App\Models\Absensi::where(
                                        'id_pertemuan',
                                        $pertemuanHariIni->id_pertemuan,
                                    )->count()
                                    : 0;

                            @endphp

                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-box bg-light-info text-info rounded-circle me-3">
                                    <i data-feather="layers"></i>
                                </div>

                                <div>
                                    <small class="text-muted d-block">
                                        Pertemuan Hari Ini
                                    </small>

                                    <div class="fw-semibold">
                                        @if ($pertemuanHariIni)
                                            Pertemuan
                                            {{ $pertemuanHariIni->pertemuan_ke }}
                                        @else
                                            Belum Ada Pertemuan
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="card-footer bg-white border-0 p-4">

                            @if (!$pertemuanHariIni)
                                <button class="btn btn-secondary w-100 rounded-pill py-2" disabled>
                                    <i data-feather="slash"></i>
                                    Belum Ada Pertemuan
                                </button>
                            @elseif($totalAbsensi >= $totalSiswa)
                                <button class="btn btn-success w-100 rounded-pill py-2" disabled>
                                    <i data-feather="check-circle"></i>
                                    Selesai
                                </button>
                            @else
                                <a href="{{ route('absensi.form', [
                                    'jadwal' => $jadwal->id_jadwal_pelajaran,
                                    'pertemuan' => $pertemuanHariIni->id_pertemuan,
                                ]) }}"
                                    class="btn btn-primary w-100 rounded-pill py-2">

                                    <i data-feather="play-circle"></i>
                                    Mulai Sesi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty

                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body text-center py-5">
                            <i data-feather="calendar" width="64" height="64" class="text-muted mb-3"></i>

                            <h5 class="fw-bold">
                                Tidak Ada Jadwal Mengajar
                            </h5>

                            <p class="text-muted mb-0">
                                Tidak ada jadwal mengajar untuk hari ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .icon-box {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
