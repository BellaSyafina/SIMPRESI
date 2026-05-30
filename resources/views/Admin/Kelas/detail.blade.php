@extends('Layouts.template-admin')

@section('title', 'Detail Data Kelas')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400">
            <a href="{{ route('kelas.index') }}">Data Kelas</a>
        </li>
        <li class="breadcrumb-item f-w-400 active">@yield('title')</li>
    </ol>
@endsection


@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4>Detail Kelas {{ $kelas->nama_kelas }}</h4>
            </div>

            <div class="card-body">

                <table class="table table-borderless">
                    <tr>
                        <td width="200">Nama Kelas</td>
                        <td>: {{ $kelas->nama_kelas }}</td>
                    </tr>

                    <tr>
                        <td>Wali Kelas</td>
                        <td>: {{ $kelas->guru->nama_guru ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Ruang</td>
                        <td>: {{ $kelas->ruang }}</td>
                    </tr>

                    <tr>
                        <td>Jumlah Siswa</td>
                        <td>: {{ $kelas->siswa->count() }} siswa</td>
                    </tr>
                </table>

                <hr>

                <h5>Daftar Siswa</h5>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($kelas->siswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>
                                    {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="mt-3">
                    <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary w-100">
                        <i data-feather></i> Kembali ke Data Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
