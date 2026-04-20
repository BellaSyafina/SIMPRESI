@extends('Layouts.template-admin')

@section('title', 'Data Guru')

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
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h3>Data Guru</h3>
                <p class="text-muted">Kelola Data Guru</p>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    Import Guru
                </button>
                <a href="{{ route('guru.create') }}" class="btn btn-primary">
                    + Tambah Guru
                </a>
            </div>
        </div>

        {{-- DATA DUMMY --}}
        @php
            $guru = collect([
                (object) [
                    'id_guru' => 1,
                    'nuptk' => '1234567890123456',
                    'nip' => '198001012010011001',
                    'nama_guru' => 'Dr. Ahmad Fauzi, M.Pd',
                    'jenis_kelamin' => 'L',
                    'jabatan' => 'Kepala Sekolah',
                    'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                    'user' => (object) ['email' => 'ahmad.fauzi@sekolah.com', 'no_hp' => '081234567890'],
                ],
                (object) [
                    'id_guru' => 2,
                    'nuptk' => '2345678901234567',
                    'nip' => '198502122010012002',
                    'nama_guru' => 'Siti Aminah, S.Pd',
                    'jenis_kelamin' => 'P',
                    'jabatan' => 'Wakil Kepala Sekolah',
                    'alamat' => 'Jl. Sudirman No. 25, Bandung',
                    'user' => (object) ['email' => 'siti.aminah@sekolah.com', 'no_hp' => '082345678901'],
                ],
                (object) [
                    'id_guru' => 3,
                    'nuptk' => '3456789012345678',
                    'nip' => '198703152010012003',
                    'nama_guru' => 'Budi Santoso, S.Kom',
                    'jenis_kelamin' => 'L',
                    'jabatan' => 'Guru Informatika',
                    'alamat' => 'Jl. Pahlawan No. 7, Surabaya',
                    'user' => (object) ['email' => 'budi.santoso@sekolah.com', 'no_hp' => '083456789012'],
                ],
                (object) [
                    'id_guru' => 4,
                    'nuptk' => '4567890123456789',
                    'nip' => '198908202010012004',
                    'nama_guru' => 'Dewi Kartika, S.Pd',
                    'jenis_kelamin' => 'P',
                    'jabatan' => 'Guru Matematika',
                    'alamat' => 'Jl. Diponegoro No. 12, Semarang',
                    'user' => (object) ['email' => 'dewi.kartika@sekolah.com', 'no_hp' => '084567890123'],
                ],
                (object) [
                    'id_guru' => 5,
                    'nuptk' => '5678901234567890',
                    'nip' => '199105182010012005',
                    'nama_guru' => 'Eko Prasetyo, M.Pd',
                    'jenis_kelamin' => 'L',
                    'jabatan' => 'Guru Bahasa Indonesia',
                    'alamat' => 'Jl. Kartini No. 5, Yogyakarta',
                    'user' => (object) ['email' => 'eko.prasetyo@sekolah.com', 'no_hp' => '085678901234'],
                ],
                (object) [
                    'id_guru' => 6,
                    'nuptk' => '6789012345678901',
                    'nip' => '199307212010012006',
                    'nama_guru' => 'Fitri Handayani, S.Si',
                    'jenis_kelamin' => 'P',
                    'jabatan' => 'Guru IPA',
                    'alamat' => 'Jl. Cendrawasih No. 8, Malang',
                    'user' => (object) ['email' => 'fitri.handayani@sekolah.com', 'no_hp' => '086789012345'],
                ],
                (object) [
                    'id_guru' => 7,
                    'nuptk' => '7890123456789012',
                    'nip' => '198812052010012007',
                    'nama_guru' => 'Gunawan Wibisono, S.Pd',
                    'jenis_kelamin' => 'L',
                    'jabatan' => 'Guru Penjasorkes',
                    'alamat' => 'Jl. Melati No. 3, Denpasar',
                    'user' => (object) ['email' => 'gunawan.wibisono@sekolah.com', 'no_hp' => '087890123456'],
                ],
                (object) [
                    'id_guru' => 8,
                    'nuptk' => '8901234567890123',
                    'nip' => '199410102010012008',
                    'nama_guru' => 'Hani Zahra, S.Pd',
                    'jenis_kelamin' => 'P',
                    'jabatan' => 'Guru Bahasa Inggris',
                    'alamat' => 'Jl. Anggrek No. 15, Makassar',
                    'user' => (object) ['email' => 'hani.zahra@sekolah.com', 'no_hp' => '088901234567'],
                ],
                (object) [
                    'id_guru' => 9,
                    'nuptk' => '9012345678901234',
                    'nip' => '198602172010012009',
                    'nama_guru' => 'Irfan Hakim, S.Ag',
                    'jenis_kelamin' => 'L',
                    'jabatan' => 'Guru Agama Islam',
                    'alamat' => 'Jl. Kenanga No. 22, Medan',
                    'user' => (object) ['email' => 'irfan.hakim@sekolah.com', 'no_hp' => '089012345678'],
                ],
                (object) [
                    'id_guru' => 10,
                    'nuptk' => '0123456789012345',
                    'nip' => '199112302010012010',
                    'nama_guru' => 'Jihan Fadhilah, S.Pd',
                    'jenis_kelamin' => 'P',
                    'jabatan' => 'Guru Seni Budaya',
                    'alamat' => 'Jl. Mawar No. 30, Palembang',
                    'user' => (object) ['email' => 'jihan.fadhilah@sekolah.com', 'no_hp' => '081298765432'],
                ],
            ]);
        @endphp

        {{-- STATISTIK --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card p-3">
                    <small>Total Guru</small>
                    <h4>{{ $guru->count() }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <small>Guru Laki-laki</small>
                    <h4>{{ $guru->where('jenis_kelamin', 'L')->count() }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <small>Guru Perempuan</small>
                    <h4>{{ $guru->where('jenis_kelamin', 'P')->count() }}</h4>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table id="table-guru" class="display table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>NUPTK</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th>Jenis Kelamin</th>
                            <th>Jabatan</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th width="85">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guru as $g)
                            <tr>
                                <td>{{ $g->id_guru }}</td>
                                <td>{{ $g->nuptk ?? '-' }}</td>
                                <td>{{ $g->nip ?? '-' }}</td>
                                <td>{{ $g->nama_guru }}</td>
                                <td>{{ $g->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                                <td>{{ $g->jabatan ?? '-' }}</td>
                                <td>{{ $g->alamat ?? '-' }}</td>
                                <td>{{ optional($g->user)->email ?? '-' }}</td>
                                <td>{{ optional($g->user)->no_hp ?? '-' }}</td>
                                <td class="text-nowrap">
                                    <a href="#" class="btn btn-sm btn-outline-info me-1" title="Edit">
                                        <i data-feather="edit-2" style="width: 16px; height: 16px;"></i>
                                    </a>
                                    <form action="#" method="POST" class="d-inline-block" onsubmit="return false;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus"
                                            onclick="return confirm('Yakin hapus data dummy?')">
                                            <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- MODAL IMPORT --}}
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Upload File Excel</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">Format file: .xls atau .xlsx</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#table-guru')) {
                $('#table-guru').DataTable().destroy();
            }

            $('#table-guru').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 20, 50],
                dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rtip',
                language: {
                    lengthMenu: "Tampilkan _MENU_ baris",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    search: "Cari:",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "→",
                        previous: "←"
                    }
                },
                columnDefs: [{
                    targets: '_all',
                    defaultContent: '-'
                }]
            });

            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endpush
