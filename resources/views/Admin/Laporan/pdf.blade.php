<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kehadiran</title>

    <style>
        @page {
            margin: 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 80px;
        }

        .judul {
            text-align: center;
        }

        .judul h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .judul h3 {
            margin: 5px 0;
            font-size: 16px;
        }

        .judul p {
            margin: 0;
            font-size: 12px;
        }

        .line {
            border-top: 3px solid #000;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            border: none;
        }

        .info td {
            border: none;
            padding: 2px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 7px;
        }

        table.data th {
            background: #d9d9d9;
            text-align: center;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .footer {
            margin-top: 60px;
            width: 100%;
        }

        .ttd {
            width: 250px;
            float: right;
            text-align: center;
        }

        .ttd p {
            margin: 0;
        }

        .nama {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td width="15%">
                    <img src="{{ public_path('assets/images/logo/smpn.png') }}" class="logo">
                </td>

                <td class="judul">
                    <h2>SMP NEGERI 2 SARONGGI</h2>
                    <h3>LAPORAN KEHADIRAN SISWA</h3>

                    <p>
                        Semester
                        {{ $selectedSemester ?? '-' }}

                        |

                        Tahun Ajaran
                        {{ $selectedTahunAjaran ?? '-' }}
                    </p>
                </td>
            </tr>
        </table>

        <div class="line"></div>
    </div>

    {{-- INFO --}}
    <div class="info">
        <table>
            <tr>
                <td width="60">
                    <strong>Kelas</strong>
                </td>

                <td width="10">:</td>

                <td>
                    {{ $kelas->nama_kelas ?? '-' }}
                </td>
            </tr>
            <tr>
                <td width="60">
                    <strong>Mapel</strong>
                </td>

                <td width="10">:</td>

                <td>
                    {{ $mataPelajaran ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    {{-- TABEL --}}
    <table class="data">
        <thead>
            <tr>
                <th width="6%">No</th>
                <th width="12%">NIS</th>
                <th width="28%">Nama Siswa</th>
                <th width="10%">Hadir</th>
                <th width="10%">Izin</th>
                <th width="10%">Sakit</th>
                <th width="10%">Alpa</th>
                <th width="14%">% Kehadiran</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($rekap as $item)
                <tr>
                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="center">
                        {{ $item['nis'] }}
                    </td>

                    <td class="left">
                        {{ $item['nama'] }}
                    </td>

                    <td class="center">
                        {{ $item['hadir'] }}
                    </td>

                    <td class="center">
                        {{ $item['izin'] }}
                    </td>

                    <td class="center">
                        {{ $item['sakit'] }}
                    </td>

                    <td class="center">
                        {{ $item['alpa'] }}
                    </td>

                    <td class="center">
                        {{ $item['persen'] }}%
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" class="center">
                        Tidak ada data laporan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <div class="ttd">
            <p>Mengetahui,</p>
            <p>Wali Kelas</p>

            <br><br><br>

            <p class="nama">
                {{ optional($kelas->guru)->nama_guru ?? '________________' }}
            </p>

            <p>
                NIP.
                {{ optional($kelas->guru)->nip ?? '-' }}
            </p>
        </div>
    </div>

</body>

</html>
