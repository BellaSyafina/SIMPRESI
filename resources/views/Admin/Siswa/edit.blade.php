@extends('Layouts.template-admin')

@section('title', 'Edit Data Siswa')

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
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold">
                    <i data-feather="user-plus" class="me-2"></i>
                    Form Edit Data Siswa
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="row g-3">

                        {{-- NISN --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NISN</label>
                            <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}"
                                placeholder="Masukkan NISN">
                        </div>

                        {{-- NIS --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}"
                                placeholder="Masukkan NIS">
                        </div>

                        {{-- Nama --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Siswa <span class="text-danger">*</span></label>
                            <input type="text" name="nama_siswa" class="form-control" value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                                placeholder="Masukkan Nama" required>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <select name="id_kelas" class="form-select" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $id => $nama)
                                    <option value="{{ $id }}" {{ old('id_kelas', $siswa->id_kelas) == $id ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Orang Tua --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nama Orang Tua</label>
                            <input type="text" name="nama_orang_tua" class="form-control"
                                value="{{ old('nama_orang_tua', $siswa->orangTua ? $siswa->orangTua->nama_orang_tua : '') }}" placeholder="Masukkan nama orang tua">
                            <datalist id="listOrtu">
                                @foreach ($orangTua as $ortu)
                                    <option value="{{ $ortu->nama_orang_tua }}">
                                @endforeach
                            </datalist>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $siswa->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat siswa">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>

                    </div>

                    {{-- Tombol --}}
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
