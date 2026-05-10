<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kehadiran</title>

    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>

    <h2 style="text-align:center;">
        Laporan Kehadiran Siswa
    </h2>

    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
                <th>%</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($rekap as $item)
                <tr>
                    <td>{{ $item['nis'] }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['hadir'] }}</td>
                    <td>{{ $item['izin'] }}</td>
                    <td>{{ $item['sakit'] }}</td>
                    <td>{{ $item['alpa'] }}</td>
                    <td>{{ $item['persen'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
