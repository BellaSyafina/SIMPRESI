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
        use Carbon\Carbon;

        // DAFTAR KELAS
        $kelasList = ['7A', '7B', '7C', '7D', '8A', '8B', '8C', '9A', '9B', '9C', '9D'];

        // DAFTAR HARI
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // DATA GURU DUMMY
        $guruList = [
            1 => 'Budi Santoso, S.Pd',
            2 => 'Siti Aminah, S.Pd',
            3 => 'Dedi Kurniawan, S.Si',
            4 => 'Rina Safitri, S.Pd',
            5 => 'Ahmad Fauzi, S.Ag',
            6 => 'Lestari Handayani, S.Pd',
        ];

        // DATA MATA PELAJARAN DUMMY
        $mapelList = [
            1 => 'Matematika',
            2 => 'Bahasa Indonesia',
            3 => 'IPA',
            4 => 'IPS',
            5 => 'Agama',
            6 => 'Bahasa Inggris',
            7 => 'PJOK',
        ];

        // DATA JADWAL DUMMY (tanpa tanggal, nanti kita generate tanggal otomatis)
        $jadwalDummy = [
            // Kelas 7A
            ['7A', 'Senin', 1, 1, '07:30', '08:30'],
            ['7A', 'Senin', 2, 2, '08:30', '09:30'],
            ['7A', 'Senin', 3, 3, '10:00', '11:00'],
            ['7A', 'Selasa', 4, 4, '07:30', '08:30'],
            ['7A', 'Selasa', 5, 5, '08:30', '09:30'],
            ['7A', 'Rabu', 1, 1, '07:30', '08:30'],
            ['7A', 'Kamis', 2, 2, '07:30', '08:30'],
            // Kelas 7B
            ['7B', 'Senin', 3, 3, '07:30', '08:30'],
            ['7B', 'Senin', 4, 4, '08:30', '09:30'],
            ['7B', 'Selasa', 5, 5, '07:30', '08:30'],
            ['7B', 'Rabu', 1, 1, '07:30', '08:30'],
            // Kelas 8A
            ['8A', 'Senin', 1, 1, '07:30', '08:30'],
            ['8A', 'Rabu', 2, 2, '07:30', '08:30'],
            ['8A', 'Jumat', 3, 3, '07:30', '08:30'],
            // Kelas 9C
            ['9C', 'Selasa', 4, 4, '07:30', '08:30'],
            ['9C', 'Kamis', 5, 5, '07:30', '08:30'],
            ['9C', 'Sabtu', 1, 1, '07:30', '08:30'],
        ];

        // Fungsi untuk mendapatkan tanggal terdekat dari hari tertentu (misal: Senin minggu ini)
        function getDateByDay($dayName)
        {
            $now = Carbon::now();
            $dayMap = [
                'Senin' => Carbon::MONDAY,
                'Selasa' => Carbon::TUESDAY,
                'Rabu' => Carbon::WEDNESDAY,
                'Kamis' => Carbon::THURSDAY,
                'Jumat' => Carbon::FRIDAY,
                'Sabtu' => Carbon::SATURDAY,
            ];
            $targetDay = $dayMap[$dayName] ?? Carbon::MONDAY;
            $date = $now
                ->copy()
                ->startOfWeek()
                ->addDays($targetDay - Carbon::MONDAY);
            // Jika hari sudah lewat dalam minggu ini, ambil minggu depan? Lebih baik tampilkan minggu ini (bisa jadi sudah lewat)
            // Agar tidak membingungkan, kita gunakan tanggal yang paling mendekati (bisa minggu ini atau minggu depan)
            if ($date->isPast() && !$date->isToday()) {
                $date = $date->addWeek();
            }
            return $date;
        }

        $selectedKelas = request()->get('kelas', '7A');
        $selectedHari = request()->get('hari', 'Senin');

        // Tanggal untuk hari yang dipilih
        $selectedDate = getDateByDay($selectedHari);
        $formattedDate = $selectedDate->translatedFormat('l, d F Y'); // Misal: Senin, 21 April 2026

        // Filter jadwal berdasarkan kelas dan hari
        $jadwalFiltered = array_filter($jadwalDummy, function ($item) use ($selectedKelas, $selectedHari) {
            return $item[0] == $selectedKelas && $item[1] == $selectedHari;
        });

        // Hitung ringkasan mingguan untuk kelas terpilih
        $ringkasan = [];
        foreach ($hariList as $hari) {
            $count = 0;
            foreach ($jadwalDummy as $j) {
                if ($j[0] == $selectedKelas && $j[1] == $hari) {
                    $count++;
                }
            }
            $ringkasan[$hari] = $count;
        }
    @endphp

    <div class="container-fluid px-0">
        <!-- Filter dan Tombol Tambah -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pilih Kelas</label>
                        <select name="kelas" class="form-select" onchange="this.form.submit()">
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $selectedKelas == $kelas ? 'selected' : '' }}>
                                    {{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Pilih Hari</label>
                        <select name="hari" class="form-select" onchange="this.form.submit()">
                            @foreach ($hariList as $hari)
                                <option value="{{ $hari }}" {{ $selectedHari == $hari ? 'selected' : '' }}>
                                    {{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="btn btn-outline-secondary w-100"
                            onclick="alert('Reset filter (demo)'); return false;">
                            <i data-feather="refresh-cw" class="me-1" width="16" height="16"></i> Reset
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#tambahJadwalModal">
                            <i data-feather="plus" class="me-1" width="16" height="16"></i> Tambah Jadwal Pelajaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <!-- Kolom Kiri: Jadwal Hari Ini dengan Tanggal -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-semibold">
                            <i data-feather="calendar" class="me-2" width="18" height="18"></i>
                            Jadwal {{ $selectedHari }} - {{ $selectedKelas }}
                            <span class="text-muted fs-6 ms-2">({{ $formattedDate }})</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (count($jadwalFiltered) > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($jadwalFiltered as $j)
                                    @php
                                        $namaGuru = $guruList[$j[2]] ?? 'Guru tidak ditemukan';
                                        $namaMapel = $mapelList[$j[3]] ?? 'Mapel tidak ditemukan';
                                        $jamMulai = $j[4];
                                        $jamSelesai = $j[5];
                                    @endphp
                                    <div class="list-group-item px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1 fw-semibold">{{ $namaMapel }}</h5>
                                                <p class="mb-0 text-secondary fs-6">
                                                    <i data-feather="user" class="me-1" width="16" height="16"></i>
                                                    Pengajar: {{ $namaGuru }}
                                                </p>
                                            </div>
                                            <div class="ms-3">
                                                <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                                                    <i data-feather="clock" class="me-1" width="14"
                                                        height="14"></i>
                                                    {{ $jamMulai }} - {{ $jamSelesai }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i data-feather="inbox" width="48" height="48" class="mb-3"></i><br>
                                Tidak ada jadwal pelajaran untuk hari {{ $selectedHari }} di kelas {{ $selectedKelas }}.
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
                            Ringkasan Mingguan - {{ $selectedKelas }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tbody>
                                    @foreach ($hariList as $hari)
                                        <tr>
                                            <td style="width: 30%"><strong class="fs-5">{{ $hari }}</strong></td>
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
                                                    <span class="badge bg-secondary fs-6 px-3 py-2">{{ $ringkasan[$hari] }}
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
                    Menampilkan jadwal untuk kelas <strong>{{ $selectedKelas }}</strong> pada hari
                    <strong>{{ $selectedHari }}</strong> ({{ $formattedDate }}). Ringkasan mingguan dihitung berdasarkan
                    jumlah mata pelajaran per hari.
                </div>
            </div>
        </div>
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
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <select class="form-select" name="kelas">
                                @foreach ($kelasList as $kelas)
                                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hari</label>
                            <select class="form-select" name="hari">
                                @foreach ($hariList as $hari)
                                    <option value="{{ $hari }}">{{ $hari }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mata Pelajaran</label>
                            <select class="form-select" name="mapel">
                                @foreach ($mapelList as $id => $mapel)
                                    <option value="{{ $id }}">{{ $mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Guru Pengajar</label>
                            <select class="form-select" name="guru">
                                @foreach ($guruList as $id => $guru)
                                    <option value="{{ $id }}">{{ $guru }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jam Mulai</label>
                                <input type="time" class="form-control" name="jam_mulai" value="07:30">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jam Selesai</label>
                                <input type="time" class="form-control" name="jam_selesai" value="08:30">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal (sesuai hari)</label>
                            <input type="date" class="form-control" name="tanggal"
                                value="{{ $selectedDate->format('Y-m-d') }}">
                            <div class="form-text">Tanggal akan otomatis disesuaikan dengan hari yang dipilih.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"
                            onclick="alert('Demo: Jadwal akan ditambahkan (fitur belum tersedia).'); return false;">
                            <i data-feather="save" class="me-1" width="16" height="16"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
@endpush
