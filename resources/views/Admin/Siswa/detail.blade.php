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
            <a href="{{ route('siswa.index') }}">Data Siswa</a>
        </li>
        <li class="breadcrumb-item f-w-400 active">@yield('title')</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid px-0">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">
                    Detail Data Siswa
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="fw-semibold">Nama Siswa</label>
                        <div>{{ $siswa->nama_siswa }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Jenis Kelamin</label>
                        <div>
                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">NISN</label>
                        <div>{{ $siswa->nisn }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">NIS</label>
                        <div>{{ $siswa->nis }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Tempat, Tanggal Lahir</label>
                        <div>
                            {{ $siswa->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Kelas</label>
                        <div>{{ $siswa->kelas->nama_kelas ?? '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Agama</label>
                        <div>{{ $siswa->agama }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-semibold">Status</label>
                        <div>{{ ucfirst($siswa->status) }}</div>
                    </div>

                    <div class="col-12">
                        <label class="fw-semibold">Alamat</label>
                        <div>{{ $siswa->alamat }}</div>
                    </div>

                    <hr>

                    <div class="col-12">
                        <h5 class="fw-bold">
                            Data Orang Tua / Wali
                        </h5>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Nama Ayah</label>
                        <div>{{ $siswa->nama_ayah ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">No HP Ayah</label>
                        <div>{{ $siswa->no_hp_ayah ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Pekerjaan Ayah</label>
                        <div>{{ $siswa->pekerjaan_ayah ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Nama Ibu</label>
                        <div>{{ $siswa->nama_ibu ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">No HP Ibu</label>
                        <div>{{ $siswa->no_hp_ibu ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Pekerjaan Ibu</label>
                        <div>{{ $siswa->pekerjaan_ibu ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Nama Wali</label>
                        <div>{{ $siswa->nama_wali ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">No HP Wali</label>
                        <div>{{ $siswa->no_hp_wali ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-semibold">Email Wali</label>
                        <div>{{ $siswa->email_wali ?? '-' }}</div>
                    </div>

                    <div class="col-12">
                        <label class="fw-semibold">Alamat Orang Tua / Wali</label>
                        <div>{{ $siswa->alamat_orang_tua ?? '-' }}</div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary w-100">
                        Kembali ke Data Siswa
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
