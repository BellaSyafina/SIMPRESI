<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\PertemuanPelajaran;
use App\Models\SettingSistem;
use App\Models\Siswa;
use App\Models\SuratIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\NotifikasiAbsensiMail;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendWhatsAppJob; // <- Tambahkan ini

class AbsensiSiswaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'id_pertemuan' => 'required|exists:pertemuan_pelajaran,id_pertemuan',
                    'status' => 'required|array',
                    'status.*' => 'required|in:hadir,izin,sakit,alpa',
                    'keterangan' => 'nullable|array',
                ],
                [
                    'id_pertemuan.required' => 'Pertemuan harus dipilih',
                    'id_pertemuan.exists' => 'Pertemuan tidak valid',

                    'status.required' => 'Data absensi tidak ditemukan',
                    'status.array' => 'Format status tidak valid',

                    'status.*.required' => 'Status absensi wajib diisi',
                    'status.*.in' => 'Status absensi tidak valid',
                ],
            );

            $pertemuan = PertemuanPelajaran::findOrFail($request->id_pertemuan);

            foreach ($request->status as $idSiswa => $status) {
                $absensi = Absensi::updateOrCreate(
                    [
                        'id_pertemuan' => $request->id_pertemuan,
                        'id_siswa' => $idSiswa,
                    ],
                    [
                        'status' => $status,
                        'keterangan' => $request->keterangan[$idSiswa] ?? null,
                    ],
                );

                $siswa = Siswa::with('kelas')->find($idSiswa);
                $jadwal = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi', 'guru'])->find($pertemuan->id_jadwal_pelajaran);

                if ($siswa && $jadwal && in_array($status, ['izin', 'sakit', 'alpa'])) {
                    // ===== EMAIL (TIDAK DIUBAH) =====

                    // $emailTujuan = $siswa->email_wali ?: env('MAIL_TEST_RECEIVER');
                    $emailTujuan = env('MAIL_TEST_RECEIVER');

                    if ($emailTujuan) {
                        Mail::to($emailTujuan)->send(
                            new NotifikasiAbsensiMail([
                                'nama_siswa' => $siswa->nama_siswa,
                                'kelas' => $siswa->kelas->nama_kelas ?? '-',
                                'mapel' => $jadwal->mataPelajaran->nama_mata_pelajaran ?? '-',
                                'guru' => $jadwal->guru->nama_guru ?? '-',
                                'tanggal' => \Carbon\Carbon::parse($pertemuan->tanggal)->format('d-m-Y'),
                                'jam' => \Carbon\Carbon::parse($jadwal->sesi->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($jadwal->sesi->jam_selesai)->format('H:i'),
                                'status' => $status,
                            ]),
                        );
                    }

                    // ===== WHATSAPP (QUEUE + DELAY) =====

                    // Ambil nomor HP wali
                    //$nomorTujuan = $siswa->no_hp_wali ?: ($siswa->no_hp_ayah ?: $siswa->no_hp_ibu);

                    // (Opsional) Untuk testing ke nomor teman, aktifkan baris ini:
                    $nomorTujuan = '6287714358035';

                    if ($nomorTujuan) {
                        // Bersihkan nomor
                        $nomorTujuan = preg_replace('/[^0-9]/', '', $nomorTujuan);
                        if (substr($nomorTujuan, 0, 1) == '0') {
                            $nomorTujuan = '62' . substr($nomorTujuan, 1);
                        }

                        // Buat pesan WhatsApp
                        $pesanWa = "📢 SIMPRESI SMPN 2 SARONGGI\n\n" . "Yth. Orang Tua/Wali Siswa\n\n" . "Berikut informasi kehadiran siswa:\n\n" . "Nama Siswa : {$siswa->nama_siswa}\n" . 'Kelas : ' . ($siswa->kelas->nama_kelas ?? '-') . "\n" . 'Mata Pelajaran : ' . ($jadwal->mataPelajaran->nama_mata_pelajaran ?? '-') . "\n" . 'Guru : ' . ($jadwal->guru->nama_guru ?? '-') . "\n" . 'Tanggal : ' . \Carbon\Carbon::parse($pertemuan->tanggal)->format('d-m-Y') . "\n" . 'Jam Sesi : ' . \Carbon\Carbon::parse($jadwal->sesi->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($jadwal->sesi->jam_selesai)->format('H:i') . "\n" . 'Status Kehadiran : ' . strtoupper($status) . "\n\n" . 'Pesan ini dikirim otomatis oleh Sistem Monitoring Kehadiran Siswa.';

                        // Simpan notifikasi ke database
                        $notifikasi = Notification::create([
                            'id_siswa' => $siswa->id_siswa,
                            'pesan' => $pesanWa,
                            'status' => 'pending',
                            'retry_count' => 0,
                        ]);

                        // Dispatch ke queue dengan delay acak 2-5 menit
                        $delay = rand(120, 300);
                        dispatch(
                            new SendWhatsAppJob(
                                $nomorTujuan,
                                $pesanWa,
                                $notifikasi->id_notifikasi, // Primary key tabel notification
                            ),
                        )->delay(now()->addSeconds($delay));
                    }
                    // ===== AKHIR WHATSAPP =====
                }

                // ===== SURAT IZIN (TIDAK DIUBAH) =====
                $surat = SuratIzin::where('id_siswa', $idSiswa)->whereDate('tanggal', $pertemuan->tanggal)->first();

                if ($surat) {
                    if (in_array($status, ['izin', 'sakit'])) {
                        $surat->update([
                            'status_verifikasi' => 'diterima',
                        ]);
                    } else {
                        $surat->update([
                            'status_verifikasi' => 'ditolak',
                        ]);
                    }
                }
            }

            return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menyimpan absensi: ' . $e->getMessage());
        }
    }

    // ===== METHOD JADWAL MENGAJAR (TIDAK DIUBAH) =====
    public function jadwalMengajar()
    {
        $guru = Guru::where('id_user', Auth::id())->first();

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $hariIni = $hariMap[now()->format('l')] ?? null;
        $setting = SettingSistem::first();
        $jadwalList = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi'])
            ->where('id_guru', $guru->id_guru)
            ->where('hari', $hariIni)
            ->where('semester', $setting->semester_aktif)
            ->where('tahun_ajaran', $setting->tahun_ajaran_aktif)
            ->orderBy('id_sesi')
            ->get();

        foreach ($jadwalList as $jadwal) {
            PertemuanPelajaran::firstOrCreate(
                [
                    'id_jadwal_pelajaran' => $jadwal->id_jadwal_pelajaran,
                    'tanggal' => now()->toDateString(),
                ],
                [
                    'pertemuan_ke' => 1,
                ],
            );
        }
        // Hitung pengajuan izin/sakit baru untuk jadwal guru hari ini
        $kelasGuruHariIni = $jadwalList->pluck('id_kelas')->unique();

        $siswaGuruHariIni = Siswa::whereIn('id_kelas', $kelasGuruHariIni)->pluck('id_siswa');

        $jumlahPengajuanBaru = SuratIzin::whereIn('id_siswa', $siswaGuruHariIni)
            ->whereDate('tanggal', now()->toDateString())
            ->whereIn('status_verifikasi', ['pending', 'diterima'])
            ->count();

        return view('Admin.absensiSiswa.jadwal', compact('jadwalList', 'jumlahPengajuanBaru'));
    }

    // ===== METHOD FORM ABSENSI =====
    public function formAbsensi($idJadwal, $idPertemuan)
    {
        $guru = Auth::user()->guru;

        // 🔥 Jadwal aktif
        $jadwalAktif = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'sesi'])
            ->where('id_jadwal_pelajaran', $idJadwal)
            ->where('id_guru', $guru->id_guru)
            ->firstOrFail();

        // 🔥 Pertemuan aktif
        $pertemuan = PertemuanPelajaran::where('id_pertemuan', $idPertemuan)->where('id_jadwal_pelajaran', $idJadwal)->firstOrFail();

        // 🔥 Siswa
        $siswa = Siswa::where('id_kelas', $jadwalAktif->id_kelas)->orderBy('nama_siswa')->get();

        // 🔥 Absensi existing
        $absensi = Absensi::with(['suratIzin'])
            ->where('id_pertemuan', $idPertemuan)
            ->get()
            ->keyBy('id_siswa');

        // 🔥 Surat izin/sakit dari orang tua berdasarkan tanggal pertemuan
        $suratIzin = SuratIzin::whereDate('tanggal', $pertemuan->tanggal)->whereIn('id_siswa', $siswa->pluck('id_siswa'))->get()->keyBy('id_siswa');

        // 🔥 Statistik
        $totalSiswa = $siswa->count();
        $totalHadir = $absensi->where('status', 'hadir')->count();
        $totalIzin = $absensi->where('status', 'izin')->count();
        $totalSakit = $absensi->where('status', 'sakit')->count();
        $totalAlpha = $absensi->where('status', 'alpa')->count();
        $persenHadir = $totalSiswa > 0 ? round(($totalHadir / $totalSiswa) * 100, 1) : 0;

        $kelasList = Kelas::orderBy('nama_kelas')->pluck('nama_kelas', 'id_kelas');

        return view('Admin.absensiSiswa.form', compact('jadwalAktif', 'pertemuan', 'siswa', 'absensi', 'suratIzin', 'totalSiswa', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'persenHadir', 'kelasList'));
    }
}
