@extends('Layouts.template-admin')

@section('title', 'Detail Data Siswa')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400">
            <a href="{{ route('laporan.index') }}">Detail Absensi Kehadiran Mata Pelajaran</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid px-0">

        <!-- Informasi Mata Pelajaran -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header" style="background:#7C6FC4;">
                <h5 class="mb-0 fw-bold" style="color:white;">
                    Detail Kehadiran Mata Pelajaran
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="fw-semibold">Mata Pelajaran</label>
                        <p>{{ $jadwal->mataPelajaran->nama_mata_pelajaran }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Guru Pengajar</label>
                        <p>{{ $jadwal->guru->nama_guru ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Kelas</label>
                        <p>{{ $jadwal->kelas->nama_kelas }}</p>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Hari</label>
                        <p>{{ $jadwal->hari }}</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- Detail Absensi -->
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    Riwayat Kehadiran Pembelajaran
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#7C6FC4;">
                            <tr>
                                <th class="text-white">No</th>
                                <th class="text-white">Hari</th>
                                <th class="text-white">Tanggal</th>
                                <th class="text-white">Jam Sesi</th>
                                <th class="text-white">Status</th>
                                <th class="text-white">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($pertemuanList as $index => $pertemuan)
                                @php
                                    $absen = $pertemuan->absensi->first();
                                    $status = $absen->status ?? 'belum_absen';
                                @endphp

                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    @php
                                        $hariMap = [
                                            'Monday' => 'Senin',
                                            'Tuesday' => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday' => 'Kamis',
                                            'Friday' => 'Jumat',
                                            'Saturday' => 'Sabtu',
                                            'Sunday' => 'Minggu',
                                        ];
                                    @endphp

                                    <td>
                                        {{ $hariMap[\Carbon\Carbon::parse($pertemuan->tanggal)->format('l')] ?? '-' }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($pertemuan->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        {{ $jadwal->sesi->jam_mulai }}
                                        -
                                        {{ $jadwal->sesi->jam_selesai }}
                                    </td>
                                    <td>

                                        @if ($status == 'hadir')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($status == 'izin')
                                            <span class="badge bg-warning text-dark">Izin</span>
                                        @elseif($status == 'sakit')
                                            <span class="badge bg-info">Sakit</span>
                                        @elseif($status == 'alpa')
                                            <span class="badge bg-danger">Alpa</span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Belum Absen
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $absen->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="6" class="text-center">
                                        Belum ada data pertemuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary w-100">
                        Kembali ke Laporan Kehadiran Mata Pelajaran
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection
