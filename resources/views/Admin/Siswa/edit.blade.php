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
                <form action="{{ route('siswa.update', $siswa->id_siswa) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <h5 class="fw-semibold border-bottom pb-2">
                                Biodata Siswa
                            </h5>
                        </div>

                        {{-- NISN --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NISN</label>
                            <input type="text" name="nisn" class="form-control"
                                value="{{ old('nisn', $siswa->nisn) }}" placeholder="Masukkan NISN" required>
                        </div>

                        {{-- NIS --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIS</label>
                            <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}"
                                placeholder="Masukkan NIS" required>
                        </div>

                        {{-- Nama --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Nama Siswa
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_siswa" class="form-control"
                                value="{{ old('nama_siswa', $siswa->nama_siswa) }}" placeholder="Masukkan nama siswa"
                                required>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Jenis Kelamin
                                <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">
                                    Pilih
                                </option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Tempat Lahir
                            </label>
                            <input type="text" name="tempat_lahir" class="form-control"
                                value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Masukkan tempat lahir">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Tanggal Lahir
                            </label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                        </div>

                        {{-- Agama --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Agama
                            </label>
                            <select name="agama" class="form-select">
                                <option value="" {{ !old('agama') ? 'selected' : '' }} disabled>
                                    Pilih Agama
                                </option>
                                <option value="Islam" {{ old('agama', $siswa->agama) == 'Islam' ? 'selected' : '' }}>Islam
                                </option>
                                <option value="Kristen" {{ old('agama', $siswa->agama) == 'Kristen' ? 'selected' : '' }}>
                                    Kristen</option>
                                <option value="Katolik" {{ old('agama', $siswa->agama) == 'Katolik' ? 'selected' : '' }}>
                                    Katolik</option>
                                <option value="Hindu" {{ old('agama', $siswa->agama) == 'Hindu' ? 'selected' : '' }}>Hindu
                                </option>
                                <option value="Budha" {{ old('agama', $siswa->agama) == 'Budha' ? 'selected' : '' }}>Budha
                                </option>
                                <option value="Konghucu" {{ old('agama', $siswa->agama) == 'Konghucu' ? 'selected' : '' }}>
                                    Konghucu
                                </option>
                            </select>
                        </div>

                        {{-- Kelas --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <select name="id_kelas" class="form-select" required>
                                <option value="" {{ !old('id_kelas') ? 'selected' : '' }}>Pilih Kelas</option>
                                @foreach ($kelas as $id => $nama)
                                    <option value="{{ $id }}"
                                        {{ old('id_kelas', $siswa->id_kelas) == $id ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="lulus" {{ old('status', $siswa->status) == 'lulus' ? 'selected' : '' }}>
                                    Lulus</option>
                                <option value="pindah" {{ old('status', $siswa->status) == 'pindah' ? 'selected' : '' }}>
                                    Pindah</option>
                                <option value="keluar" {{ old('status', $siswa->status) == 'keluar' ? 'selected' : '' }}>
                                    Keluar</option>
                            </select>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat siswa">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <h5 class="fw-semibold border-bottom pb-2">
                                Data Orang Tua / Wali
                            </h5>
                        </div>

                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="fw-semibold mb-3">
                                    Data Ayah
                                </h6>

                                <div class="row g-3">
                                    {{-- Ayah --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            Nama Ayah
                                        </label>
                                        <input type="text" name="nama_ayah" class="form-control"
                                            value="{{ old('nama_ayah', $siswa->nama_ayah) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            No HP Ayah
                                        </label>
                                        <input type="tel" name="no_hp_ayah" class="form-control"
                                            value="{{ old('no_hp_ayah', $siswa->no_hp_ayah) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            Pekerjaan Ayah
                                        </label>
                                        <input type="text" name="pekerjaan_ayah" class="form-control"
                                            value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="fw-semibold mb-3">
                                    Data Ibu
                                </h6>
                                <div class="row g-3">
                                    {{-- Ibu --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            Nama Ibu
                                        </label>
                                        <input type="text" name="nama_ibu" class="form-control"
                                            value="{{ old('nama_ibu', $siswa->nama_ibu) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            No HP Ibu
                                        </label>
                                        <input type="tel" name="no_hp_ibu" class="form-control"
                                            value="{{ old('no_hp_ibu', $siswa->no_hp_ibu) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            Pekerjaan Ibu
                                        </label>
                                        <input type="text" name="pekerjaan_ibu" class="form-control"
                                            value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-light rounded p-3">
                                <h6 class="fw-semibold mb-3">
                                    Data Wali
                                </h6>
                                <div class="row g-3">
                                    {{-- Wali --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            Nama Wali
                                        </label>
                                        <input type="text" name="nama_wali" class="form-control"
                                            value="{{ old('nama_wali', $siswa->nama_wali) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            No HP Wali
                                        </label>
                                        <input type="tel" name="no_hp_wali" class="form-control"
                                            value="{{ old('no_hp_wali', $siswa->no_hp_wali) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            Email Wali
                                        </label>
                                        <input type="email" name="email_wali"
                                            class="form-control @error('email_wali') is-invalid @enderror"
                                            value="{{ old('email_wali', $siswa->email_wali) }}">
                                        @error('email_wali')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Pekerjaan Wali
                                        </label>
                                        <input type="text" name="pekerjaan_wali" class="form-control"
                                            value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali) }}">
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            Alamat Orang Tua / Wali
                                        </label>
                                        <textarea name="alamat_orang_tua" class="form-control" rows="2">{{ old('alamat_orang_tua', $siswa->alamat_orang_tua) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Update Data
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
