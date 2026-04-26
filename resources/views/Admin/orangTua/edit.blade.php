@extends('Layouts.template-admin')

@section('title', 'Edit Data Orang Tua')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400">
            <a href="{{ route('orangtua.index') }}">Data Orang Tua</a>
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
                    Form Edit Data Orang Tua
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('orangtua.update', $orangTua->id_orang_tua) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Nama --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Nama Orang Tua <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_orang_tua" class="form-control"
                                value="{{ old('nama_orang_tua', $orangTua->nama_orang_tua) }}" required>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin', $orangTua->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin', $orangTua->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        {{-- No HP --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $orangTua->no_hp) }}"
                                placeholder="Contoh: 081234567890">
                        </div>

                        {{-- Alamat --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat">{{ old('alamat', $orangTua->alamat) }}</textarea>
                        </div>

                    </div>

                    {{-- Tombol --}}
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('orangtua.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" class="me-1" width="16" height="16"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
