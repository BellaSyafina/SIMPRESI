<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\PertemuanPelajaran;
use App\Models\SettingSistem;
use App\Models\Siswa;
use App\Models\SuratIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        $setting = SettingSistem::first();

        $siswa = Siswa::where('id_user', Auth::id())->first();

        $pengajuanList = SuratIzin::where('id_siswa', $siswa->id_siswa)

            ->latest()

            ->get();

        return view('Admin.PengajuanIzin.index', compact('pengajuanList', 'setting'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'tanggal' => 'required|date',

                    'jenis' => 'required|in:izin,sakit',

                    'keterangan' => 'nullable|string',

                    'file_surat' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
                ],
                [
                    'tanggal.required' => 'Tanggal wajib diisi.',

                    'jenis.required' => 'Jenis pengajuan wajib dipilih.',

                    'jenis.in' => 'Jenis pengajuan tidak valid.',

                    'file_surat.required' => 'File surat wajib diupload.',

                    'file_surat.mimes' => 'File harus berupa PDF, JPG, JPEG, atau PNG.',

                    'file_surat.max' => 'Ukuran file maksimal 2MB.',
                ],
            );

            $siswa = Siswa::where('id_user', Auth::id())->first();

            if (!$siswa) {
                return redirect()
                    ->back()

                    ->with('error', 'Data siswa tidak ditemukan.');
            }

            // 🔥 upload file
            $fileSurat = $request

                ->file('file_surat')

                ->store('surat-izin', 'public');

            // 🔥 simpan surat izin
            $surat = SuratIzin::create([
                'id_siswa' => $siswa->id_siswa,

                'tanggal' => $request->tanggal,

                'jenis' => $request->jenis,

                'keterangan' => $request->keterangan,

                'file_surat' => $fileSurat,

                'status_verifikasi' => 'pending',
            ]);

            // 🔥 cari pertemuan di tanggal tsb
            $pertemuanList = PertemuanPelajaran::whereDate('tanggal', $request->tanggal)->get();

            foreach ($pertemuanList as $pertemuan) {
                // 🔥 cek apakah siswa ada di kelas tsb
                if ($pertemuan->jadwal && $pertemuan->jadwal->id_kelas == $siswa->id_kelas) {
                    Absensi::updateOrCreate(
                        [
                            'id_siswa' => $siswa->id_siswa,

                            'id_pertemuan' => $pertemuan->id_pertemuan,
                        ],

                        [
                            'status' => $request->jenis,

                            'keterangan' => $request->keterangan,
                        ],
                    );
                }
            }

            return redirect()
                ->back()

                ->with('success', 'Pengajuan izin berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()
                ->back()

                ->with('error', 'Gagal mengirim pengajuan: ' . $e->getMessage());
        }
    }
}
