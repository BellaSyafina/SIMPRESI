<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PertemuanPelajaran;
use App\Models\SesiPelajaran;
use App\Models\SettingSistem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::pluck('nama_kelas', 'id_kelas');
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $sesiList = SesiPelajaran::orderBy('jam_mulai')->get();
        $semesterList = ['Ganjil', 'Genap'];
        $tahunAjaranList = $this->generateTahunAjaranList();

        // 🔥 default filter
        $selectedKelas = $request->kelas ?? $kelasList->keys()->first();
        $selectedHari = $request->hari ?? 'Senin';
        $setting = SettingSistem::first();

        $selectedSemester = $setting->semester_aktif;
        $selectedTahunAjaran = $setting->tahun_ajaran_aktif;

        // 🔥 ambil jadwal
        $jadwal = JadwalPelajaran::with(['guru', 'mataPelajaran', 'sesi'])
            ->where('id_kelas', $selectedKelas)
            ->where('hari', $selectedHari)
            ->where('semester', $selectedSemester)
            ->where('tahun_ajaran', $selectedTahunAjaran)
            ->orderBy('id_sesi')
            ->get();

        // 🔥 ringkasan mingguan
        $ringkasan = [];

        foreach ($hariList as $hari) {
            $ringkasan[$hari] = JadwalPelajaran::where('id_kelas', $selectedKelas)->where('hari', $hari)->where('semester', $selectedSemester)->where('tahun_ajaran', $selectedTahunAjaran)->count();
        }

        // 🔥 dropdown modal
        $guruList = Guru::orderBy('nama_guru')->pluck('nama_guru', 'id_guru');
        $mapelList = MataPelajaran::orderBy('nama_mata_pelajaran')->pluck('nama_mata_pelajaran', 'id_mata_pelajaran');
        $mapelObject = MataPelajaran::orderBy('nama_mata_pelajaran')->get();

        return view('Admin.jadwalPelajaran.index', compact('kelasList', 'hariList', 'jadwal', 'ringkasan', 'selectedKelas', 'selectedHari', 'selectedSemester', 'selectedTahunAjaran', 'guruList', 'mapelList', 'sesiList', 'semesterList', 'tahunAjaranList', 'mapelObject', 'setting'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                    'id_sesi' => 'required|exists:sesi_pelajaran,id_sesi',
                    'id_guru' => 'required|exists:guru,id_guru',
                    'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
                ],
                [
                    'id_kelas.required' => 'Kelas harus dipilih.',
                    'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
                    'hari.required' => 'Hari harus dipilih.',
                    'hari.in' => 'Hari yang dipilih tidak valid.',
                    'id_sesi.required' => 'Sesi harus dipilih.',
                    'id_sesi.exists' => 'Sesi yang dipilih tidak valid.',
                    'id_guru.required' => 'Guru harus dipilih.',
                    'id_guru.exists' => 'Guru yang dipilih tidak valid.',
                    'id_mata_pelajaran.required' => 'Mata pelajaran harus dipilih.',
                    'id_mata_pelajaran.exists' => 'Mata pelajaran yang dipilih tidak valid.',
                ],
            );

            $jadwalBentrok = JadwalPelajaran::where('id_kelas', $request->id_kelas)->where('hari', $request->hari)->where('id_sesi', $request->id_sesi)->where('semester', $request->semester)->where('tahun_ajaran', $request->tahun_ajaran)->exists();

            if ($jadwalBentrok) {
                return back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain pada kelas dan tanggal yang sama.');
            }

            $setting = SettingSistem::first();

            $jadwal = JadwalPelajaran::create([
                'id_kelas' => $request->id_kelas,
                'hari' => $request->hari,
                'id_sesi' => $request->id_sesi,
                'semester' => $setting->semester_aktif,
                'tahun_ajaran' => $setting->tahun_ajaran_aktif,
                'id_guru' => $request->id_guru,
                'id_mata_pelajaran' => $request->id_mata_pelajaran,
            ]);

            $this->generatePertemuan($jadwal);

            return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->route('jadwal.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function generatePertemuan($jadwal)
    {
        // 🔥 total pertemuan semester
        $totalPertemuan = 16;

        // 🔥 tentukan tanggal awal
        $tanggalMulai = now()->startOfWeek();

        // 🔥 mapping hari
        $hariMap = [
            'Senin' => Carbon::MONDAY,
            'Selasa' => Carbon::TUESDAY,
            'Rabu' => Carbon::WEDNESDAY,
            'Kamis' => Carbon::THURSDAY,
            'Jumat' => Carbon::FRIDAY,
            'Sabtu' => Carbon::SATURDAY,
        ];

        // 🔥 cari hari pertama sesuai jadwal
        $tanggal = $tanggalMulai->copy()->next($hariMap[$jadwal->hari]);

        for ($i = 1; $i <= $totalPertemuan; $i++) {
            PertemuanPelajaran::create([
                'id_jadwal_pelajaran' => $jadwal->id_jadwal_pelajaran,
                'pertemuan_ke' => $i,
                'tanggal' => $tanggal,
                'materi' => null,
                'catatan' => null,
                'status' => 'belum',
            ]);

            // 🔥 minggu berikutnya
            $tanggal->addWeek();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jadwal = JadwalPelajaran::findOrFail($id);

            $request->validate(
                [
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                    'id_sesi' => 'required|exists:sesi_pelajaran,id_sesi',
                    'id_guru' => 'required|exists:guru,id_guru',
                    'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
                ],
                [
                    'id_kelas.required' => 'Kelas harus dipilih.',
                    'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
                    'hari.required' => 'Hari harus dipilih.',
                    'hari.in' => 'Hari yang dipilih tidak valid.',
                    'id_sesi.required' => 'Sesi harus dipilih.',
                    'id_sesi.exists' => 'Sesi yang dipilih tidak valid.',
                    'id_guru.required' => 'Guru harus dipilih.',
                    'id_guru.exists' => 'Guru yang dipilih tidak valid.',
                    'id_mata_pelajaran.required' => 'Mata pelajaran harus dipilih.',
                    'id_mata_pelajaran.exists' => 'Mata pelajaran yang dipilih tidak valid.',
                ],
            );

            $jadwalBentrok = JadwalPelajaran::where('id_kelas', $request->id_kelas)->where('hari', $request->hari)->where('id_sesi', $request->id_sesi)->where('semester', $request->semester)->where('tahun_ajaran', $request->tahun_ajaran)->where('id_jadwal_pelajaran', '!=', $id)->exists();

            if ($jadwalBentrok) {
                return back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain pada kelas dan tanggal yang sama.');
            }

            $setting = SettingSistem::first();

            $jadwal->update([
                'id_kelas' => $request->id_kelas,
                'hari' => $request->hari,
                'id_sesi' => $request->id_sesi,
                'semester' => $setting->semester_aktif,
                'tahun_ajaran' => $setting->tahun_ajaran_aktif,
                'id_guru' => $request->id_guru,
                'id_mata_pelajaran' => $request->id_mata_pelajaran,
            ]);

            return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('jadwal.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function pertemuan($id)
    {
        $jadwal = JadwalPelajaran::with(['kelas', 'guru', 'mataPelajaran', 'sesi'])->findOrFail($id);
        $pertemuanList = PertemuanPelajaran::where('id_jadwal_pelajaran', $id)->orderBy('pertemuan_ke')->paginate(10);

        return view('Admin.jadwalPelajaran.pertemuan', compact('jadwal', 'pertemuanList'));
    }

    public function updatePertemuan(Request $request, $id)
    {
        try {
            $pertemuan = PertemuanPelajaran::findOrFail($id);

            $request->validate(
                [
                    'materi' => 'nullable|string|max:255',
                    'catatan' => 'nullable|string',
                    'status' => 'required|in:belum,selesai,dibatalkan',
                ],
                [
                    'materi.string' => 'Materi harus berupa teks.',
                    'materi.max' => 'Materi tidak boleh lebih dari 255 karakter.',
                    'catatan.string' => 'Catatan harus berupa teks.',
                    'status.required' => 'Status pertemuan harus dipilih.',
                    'status.in' => 'Status pertemuan tidak valid.',
                ],
            );

            $pertemuan->update([
                'materi' => $request->materi,
                'catatan' => $request->catatan,
                'status' => $request->status,
            ]);

            return redirect()->route('jadwal.pertemuan', $pertemuan->id_jadwal_pelajaran)->with('success', 'Pertemuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('jadwal.pertemuan', $pertemuan->id_jadwal_pelajaran)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function guruByMapel($id)
    {
        $mapel = MataPelajaran::findOrFail($id);

        // Ambil nama mata pelajaran utama tanpa tulisan "Kelas 7/8/9"
        $namaMapelUtama = preg_replace('/\sKelas\s[789]$/', '', $mapel->nama_mata_pelajaran);

        $guru = Guru::whereHas('mataPelajaran', function ($q) use ($namaMapelUtama) {
            $q->where('mata_pelajaran.nama_mata_pelajaran', 'like', '%' . $namaMapelUtama . '%');
        })
            ->orderBy('nama_guru')
            ->pluck('nama_guru', 'id_guru');

        return response()->json($guru);
    }

    private function generateTahunAjaranList()
    {
        $tahunSekarang = date('Y');
        $list = [];

        for ($i = -2; $i <= 2; $i++) {
            $awal = $tahunSekarang + $i;
            $akhir = $awal + 1;
            $list[] = $awal . '/' . $akhir;
        }

        return $list;
    }
}
