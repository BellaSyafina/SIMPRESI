<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Notifikasi Kehadiran</title>
</head>

<body>

    <h2>SIMPRESI SMPN 2 Saronggi</h2>

    <p>Yth. Bapak/Ibu Orang Tua/Wali,</p>

    <p>Berikut informasi kehadiran siswa:</p>

    <table>
        <tr>
            <td><strong>Nama Siswa</strong></td>
            <td>: {{ $data['nama_siswa'] }}</td>
        </tr>

        <tr>
            <td><strong>Kelas</strong></td>
            <td>: {{ $data['kelas'] }}</td>
        </tr>

        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>: {{ $data['mapel'] }}</td>
        </tr>

        <tr>
            <td><strong>Guru</strong></td>
            <td>: {{ $data['guru'] }}</td>
        </tr>

        <tr>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $data['tanggal'] }}</td>
        </tr>

        <tr>
            <td><strong>Jam Sesi</strong></td>
            <td>: {{ $data['jam'] }}</td>
        </tr>

        <tr>
            <td><strong>Status</strong></td>
            <td>: {{ ucfirst($data['status']) }}</td>
        </tr>
    </table>

    <br>

    <p>Email ini dikirim secara otomatis oleh Sistem Monitoring Kehadiran Siswa (SIMPRESI).</p>

    <p>Terima kasih.</p>

</body>

</html>
