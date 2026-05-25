@extends('Layouts.template-admin')

@section('title', 'Jadwal Pelajaran')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400 active">@yield('title')</li>
        {{--  <li class="breadcrumb-item f-w-400 active">Default</li>  --}}
    </ol>
@endsection

@section('content')
    @php

        // DAFTAR HARI
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $selectedKelas = request('kelas') ?? optional($kelasList->keys())->first();
        $namaKelas = $kelasList[$selectedKelas] ?? '-';
        \Carbon\Carbon::setLocale('id');
    @endphp

    <div class="container-fluid px-0">
        @if ($kelasList->isEmpty())
            <div class="alert alert-warning text-center">
                <strong>Data kelas belum tersedia.</strong><br>
                Silakan tambah data kelas terlebih dahulu sebelum membuat jadwal.
            </div>
        @else
            <!-- Filter dan Tombol Tambah -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('jadwal.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Pilih Kelas</label>
                            <select name="kelas" class="form-select" onchange="this.form.submit()">
                                @foreach ($kelasList as $id => $kelas)
                                    <option value="{{ $id }}" {{ $selectedKelas == $id ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Pilih Hari</label>
                            <select name="hari" class="form-select" onchange="this.form.submit()">
                                @foreach ($hariList as $hari)
                                    <option value="{{ $hari }}" {{ $selectedHari == $hari ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">

                            <div class="alert alert-primary mb-0 py-2">

                                <strong>Semester Aktif:</strong>
                                {{ $selectedSemester }}

                                |

                                <strong>Tahun Ajaran:</strong>
                                {{ $selectedTahunAjaran }}

                            </div>

                        </div>
                        <div class="col-12">

                            <div class="d-flex justify-content-center gap-3 mt-2">

                                <div class="col-md-3">
                                    <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary w-100">
                                        <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i>
                                        Reset
                                    </a>
                                </div>

                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#tambahJadwalModal">

                                        <i data-feather="plus" class="me-1" width="16" height="16"></i>
                                        Tambah Jadwal Pelajaran

                                    </button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>

            @include('Components.alert')

            <div class="row g-4">
                <!-- Kolom Kiri: Jadwal Hari Ini dengan Tanggal -->
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i data-feather="calendar" class="me-2" width="18" height="18"></i>
                                Jadwal {{ $selectedHari }} - {{ $namaKelas }}
                                <span class="text-muted fs-6 ms-2">
                                    Semester {{ $selectedSemester }}
                                    | {{ $selectedTahunAjaran }}
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($jadwal->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach ($jadwal as $j)
                                        <div class="list-group-item px-0 py-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h5 class="mb-1 fw-semibold">
                                                        {{ $j->mataPelajaran->nama_mata_pelajaran }}
                                                    </h5>
                                                    <p class="mb-0 text-secondary fs-6">
                                                        <i data-feather="user"></i>
                                                        Pengajar: {{ $j->guru->nama_guru }}
                                                    </p>
                                                </div>
                                                <div class="ms-3">
                                                    <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                                                        {{ $j->sesi->nama_sesi }}
                                                        {{ $j->sesi->jam_mulai }} - {{ $j->sesi->jam_selesai }}
                                                    </span>
                                                </div>
                                                <div class="ms-2">
                                                    <button class="btn btn-sm btn-outline-primary btn-edit"
                                                        data-id="{{ $j->id_jadwal_pelajaran }}"
                                                        data-kelas="{{ $j->id_kelas }}"
                                                        data-mapel="{{ $j->id_mata_pelajaran }}"
                                                        data-guru="{{ $j->id_guru }}" data-hari="{{ $j->hari }}"
                                                        data-sesi="{{ $j->id_sesi }}"
                                                        data-semester="{{ $j->semester }}"
                                                        data-tahun_ajaran="{{ $j->tahun_ajaran }}">
                                                        <i data-feather="edit-2"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger btn-hapus"
                                                        data-id="{{ $j->id_jadwal_pelajaran }}">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                    Belum ada jadwal pelajaran
                                    untuk hari {{ $selectedHari }}
                                    semester {{ $selectedSemester }}.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan Mingguan -->
                <div class="col-md-5">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0 fw-semibold">
                                <i data-feather="bar-chart-2" class="me-2" width="18" height="18"></i>
                                Ringkasan Jadwal -
                                {{ $namaKelas }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        @foreach ($hariList as $hari)
                                            <tr>
                                                <td style="width: 30%"><strong class="fs-5">{{ $hari }}</strong>
                                                </td>
                                                <td style="width: 70%">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="progress flex-grow-1" style="height: 12px;">
                                                            @php
                                                                $maxPelajaran = max($ringkasan) ?: 1;
                                                                $percent = ($ringkasan[$hari] / $maxPelajaran) * 100;
                                                            @endphp
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: {{ $percent }}%;"
                                                                aria-valuenow="{{ $ringkasan[$hari] }}" aria-valuemin="0"
                                                                aria-valuemax="{{ $maxPelajaran }}"></div>
                                                        </div>
                                                        <span
                                                            class="badge bg-secondary fs-6 px-3 py-2">{{ $ringkasan[$hari] }}
                                                            pelajaran</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi catatan -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-light border shadow-sm mb-0" role="alert">
                        <i data-feather="info" class="me-2" width="16" height="16"></i>
                        Menampilkan jadwal kelas
                        <strong>{{ $namaKelas }}</strong>
                        pada hari
                        <strong>{{ $selectedHari }}</strong>
                        semester
                        <strong>{{ $selectedSemester }}</strong>
                        tahun ajaran
                        <strong>{{ $selectedTahunAjaran }}</strong>.
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Tambah Jadwal (sama seperti sebelumnya) -->
    <div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJadwalModalLabel">
                        <i data-feather="plus-circle" class="me-2" width="18" height="18"></i> Tambah Jadwal
                        Pelajaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jadwal.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <select class="form-select" name="id_kelas">
                                @if ($kelasList->isEmpty())
                                    <option disabled selected>Tidak ada kelas</option>
                                @else
                                    @foreach ($kelasList as $id => $kelas)
                                        <option value="{{ $id }}">{{ $kelas }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>
                            <select class="form-select" name="id_mata_pelajaran" id="mapelSelect">
                                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                @foreach ($mapelObject as $mapel)
                                    <option value="{{ $mapel->id_mata_pelajaran }}">

                                        {{ $mapel->nama_mata_pelajaran }}
                                        -
                                        {{ $mapel->kode_mapel }}

                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Guru Pengajar</label>
                            <select class="form-select" name="id_guru" id="guruSelect">

                                <option value="" disabled selected>
                                    Pilih Guru
                                </option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hari</label>
                            <select class="form-select" name="hari">
                                <option value="" disabled selected>Pilih Hari</option>
                                @foreach ($hariList as $hari)
                                    <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sesi Pelajaran</label>
                            <select class="form-select" name="id_sesi">
                                <option value="" disabled selected>Pilih Sesi Pelajaran</option>
                                @foreach ($sesiList as $sesi)
                                    <option value="{{ $sesi->id_sesi }}">
                                        {{ $sesi->nama_sesi }}
                                        ({{ $sesi->jam_mulai }} - {{ $sesi->jam_selesai }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-light border">

                            Jadwal akan otomatis disimpan
                            untuk:

                            <br>

                            <strong>
                                Semester {{ $selectedSemester }}
                            </strong>

                            |

                            <strong>
                                Tahun Ajaran
                                {{ $selectedTahunAjaran }}
                            </strong>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" class="me-1" width="16" height="16"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editJadwalModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="formEditJadwal">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Jadwal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="id_kelas" id="edit_kelas">

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Mata Pelajaran
                            </label>

                            <select name="id_mata_pelajaran" id="edit_mapel" class="form-select">

                                @foreach ($mapelObject as $mapel)
                                    <option value="{{ $mapel->id_mata_pelajaran }}">

                                        {{ $mapel->nama_mata_pelajaran }}
                                        -
                                        {{ $mapel->kode_mapel }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="mb-3">
                            <label>Guru</label>
                            <select name="id_guru" id="edit_guru" class="form-select"></select>
                        </div>
                        <div class="mb-3">
                            <label>Hari</label>
                            <select name="hari" id="edit_hari" class="form-select">
                                @foreach ($hariList as $hari)
                                    <option value="{{ $hari }}">
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Sesi Pelajaran</label>
                            <select name="id_sesi" id="edit_sesi" class="form-select">
                                @foreach ($sesiList as $sesi)
                                    <option value="{{ $sesi->id_sesi }}">
                                        {{ $sesi->nama_sesi }}
                                        ({{ $sesi->jam_mulai }}
                                        - {{ $sesi->jam_selesai }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hapusJadwalModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" id="formHapusJadwal">
                    @csrf
                    @method('DELETE')

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i data-feather="alert-triangle" class="me-2"></i>
                            Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body text-center">
                        <p class="mb-0">
                            Yakin ingin menghapus jadwal ini?
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <button type="submit" class="btn btn-danger">
                            Hapus
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        console.log('SCRIPT JALAN');

        document.addEventListener(
            'DOMContentLoaded',
            function() {

                console.log('DOM READY');

                const mapelSelect =
                    document.getElementById(
                        'mapelSelect'
                    );

                const guruSelect =
                    document.getElementById(
                        'guruSelect'
                    );

                console.log(mapelSelect);

                mapelSelect.addEventListener(
                    'change',
                    function() {

                        let mapelId = this.value;

                        console.log(mapelId);

                        guruSelect.innerHTML =
                            '<option value="">Loading...</option>';

                        console.log('FETCH JALAN');

                        fetch(
                                `{{ url('/guru-by-mapel') }}/${mapelId}`
                            )

                            .then(response => response.json())

                            .then(data => {

                                console.log(data);

                                guruSelect.innerHTML =
                                    '<option value="">-- Pilih Guru --</option>';

                                for (const id in data) {

                                    guruSelect.innerHTML += `
                                    <option value="${id}">
                                        ${data[id]}
                                    </option>
                                `;

                                }

                                $('#guruSelect').html(
                                    guruSelect.innerHTML
                                ).trigger('change');

                            })

                            .catch(error => {

                                console.error(error);

                            });

                    });

            });
    </script>

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                // =========================
                // EDIT JADWAL
                // =========================

                document.querySelectorAll(
                    '.btn-edit'
                ).forEach(button => {

                    button.addEventListener(
                        'click',
                        function() {

                            const id =
                                this.dataset.id;

                            // FORM ACTION
                            document.getElementById(
                                    'formEditJadwal'
                                ).action =
                                `/jadwal/${id}`;

                            // SET VALUE
                            document.getElementById(
                                    'edit_kelas'
                                ).value =
                                this.dataset.kelas;

                            document.getElementById(
                                    'edit_mapel'
                                ).value =
                                this.dataset.mapel;

                            document.getElementById(
                                    'edit_hari'
                                ).value =
                                this.dataset.hari;

                            document.getElementById(
                                    'edit_sesi'
                                ).value =
                                this.dataset.sesi;

                            // LOAD GURU BERDASARKAN MAPEL
                            fetch(
                                    `/guru-by-mapel/${this.dataset.mapel}`
                                )

                                .then(response =>
                                    response.json()
                                )

                                .then(data => {

                                    let guruSelect =
                                        document.getElementById(
                                            'edit_guru'
                                        );

                                    guruSelect.innerHTML = '';

                                    for (const id in data) {

                                        guruSelect.innerHTML += `
                                <option value="${id}">
                                    ${data[id]}
                                </option>
                            `;

                                    }

                                    guruSelect.value =
                                        button.dataset.guru;

                                });

                            // TAMPILKAN MODAL
                            new bootstrap.Modal(
                                document.getElementById(
                                    'editJadwalModal'
                                )
                            ).show();

                        });

                });

                // =========================
                // HAPUS JADWAL
                // =========================

                document.querySelectorAll(
                    '.btn-hapus'
                ).forEach(button => {

                    button.addEventListener(
                        'click',
                        function() {

                            const id =
                                this.dataset.id;

                            document.getElementById(
                                    'formHapusJadwal'
                                ).action =
                                `/jadwal/${id}`;

                            new bootstrap.Modal(
                                document.getElementById(
                                    'hapusJadwalModal'
                                )
                            ).show();

                        });

                });

                // =========================
                // CHANGE MAPEL EDIT
                // =========================

                document.getElementById(
                    'edit_mapel'
                ).addEventListener(
                    'change',
                    function() {

                        const mapelId =
                            this.value;

                        const guruSelect =
                            document.getElementById(
                                'edit_guru'
                            );

                        guruSelect.innerHTML =
                            '<option>Loading...</option>';

                        fetch(
                                `/guru-by-mapel/${mapelId}`
                            )

                            .then(response =>
                                response.json()
                            )

                            .then(data => {

                                guruSelect.innerHTML =
                                    '<option value="">Pilih Guru</option>';

                                for (const id in data) {

                                    guruSelect.innerHTML += `
                    <option value="${id}">
                        ${data[id]}
                    </option>
                `;

                                }

                            });

                    });

            });
    </script>
@endsection

@push('script')
@endpush
