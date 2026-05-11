<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::pluck('nama_kelas', 'id_kelas');
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        if ($kelasList->isEmpty()) {
            return view('Admin.jadwalPelajaran.index', [
                'kelasList' => collect(),
                'hariList' => $hariList,
                'jadwal' => collect(),
                'ringkasan' => [],
                'selectedKelas' => null,
                'selectedHari' => 'Senin',
                'formattedDate' => now()->translatedFormat('l, d F Y'),
                'selectedDate' => now(),
                'guruList' => [],
                'mapelList' => [],
            ]);
        }

        $selectedKelas = $request->kelas ?? $kelasList->keys()->first();

        $selectedTanggal = $request->tanggal ?? now()->format('Y-m-d');

        $selectedDate = Carbon::parse($selectedTanggal);
        $selectedHari = $selectedDate->translatedFormat('l');
        $formattedDate = $selectedDate->translatedFormat('l, d F Y');

        // 🔥 DATA JADWAL REAL
        $jadwal = JadwalPelajaran::with(['guru', 'mataPelajaran'])
            ->where('id_kelas', $selectedKelas)
            ->whereDate('tanggal', $selectedTanggal)
            ->orderBy('jam_mulai')
            ->get();

        $startOfWeek = Carbon::parse($selectedTanggal)->startOfWeek(Carbon::MONDAY);

        $endOfWeek = Carbon::parse($selectedTanggal)->endOfWeek(Carbon::SATURDAY);

        $ringkasan = [];

        foreach ($hariList as $hari) {
            $ringkasan[$hari] = 0;
        }

        // 🔥 Ambil semua jadwal minggu ini
        $dataMingguan = JadwalPelajaran::where('id_kelas', $selectedKelas)
            ->whereBetween('tanggal', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->get();

        $mapHari = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        foreach ($dataMingguan as $item) {
            $hariEnglish = Carbon::parse($item->tanggal)->format('l');

            $namaHari = $mapHari[$hariEnglish] ?? null;

            if ($namaHari && isset($ringkasan[$namaHari])) {
                $ringkasan[$namaHari]++;
            }
        }

        // 🔥 DATA UNTUK MODAL
        $guruList = Guru::pluck('nama_guru', 'id_guru');
        $mapelList = MataPelajaran::pluck('nama_mata_pelajaran', 'id_mata_pelajaran');

        return view('Admin.jadwalPelajaran.index', compact('kelasList', 'hariList', 'jadwal', 'ringkasan', 'selectedKelas', 'selectedHari', 'selectedTanggal', 'formattedDate', 'selectedDate', 'guruList', 'mapelList', 'startOfWeek', 'endOfWeek'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'jam_mulai' => 'required|date_format:H:i',
                    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                    'id_guru' => 'required|exists:guru,id_guru',
                    'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
                    'tanggal' => 'required|date',
                ],
                [
                    'id_kelas.required' => 'Kelas harus dipilih.',
                    'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
                    'jam_mulai.required' => 'Jam mulai harus diisi.',
                    'jam_mulai.date_format' => 'Format jam mulai harus HH:mm.',
                    'jam_selesai.required' => 'Jam selesai harus diisi.',
                    'jam_selesai.date_format' => 'Format jam selesai harus HH:mm.',
                    'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
                    'id_guru.required' => 'Guru harus dipilih.',
                    'id_guru.exists' => 'Guru yang dipilih tidak valid.',
                    'id_mata_pelajaran.required' => 'Mata pelajaran harus dipilih.',
                    'id_mata_pelajaran.exists' => 'Mata pelajaran yang dipilih tidak valid.',
                    'tanggal.required' => 'Tanggal harus diisi.',
                    'tanggal.date' => 'Format tanggal tidak valid.',
                ],
            );

            $jadwalBentrok = JadwalPelajaran::where('id_kelas', $request->id_kelas)
                ->whereDate('tanggal', $request->tanggal)
                ->where(function ($query) use ($request) {
                    $query
                        ->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('jam_mulai', '<', $request->jam_selesai)->where('jam_selesai', '>', $request->jam_mulai);
                        });
                })
                ->exists();

            if ($jadwalBentrok) {
                return back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain pada kelas dan tanggal yang sama.');
            }

            JadwalPelajaran::create([
                'id_kelas' => $request->id_kelas,
                'hari' => Carbon::parse($request->tanggal)->translatedFormat('l'),
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'id_guru' => $request->id_guru,
                'id_mata_pelajaran' => $request->id_mata_pelajaran,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->route('jadwal.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $jadwal = JadwalPelajaran::findOrFail($id);

            $request->validate(
                [
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'jam_mulai' => 'required|date_format:H:i',
                    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                    'id_guru' => 'required|exists:guru,id_guru',
                    'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
                    'tanggal' => 'required|date',
                ],
                [
                    'id_kelas.required' => 'Kelas harus dipilih.',
                    'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
                    'jam_mulai.required' => 'Jam mulai harus diisi.',
                    'jam_mulai.date_format' => 'Format jam mulai harus HH:mm.',
                    'jam_selesai.required' => 'Jam selesai harus diisi.',
                    'jam_selesai.date_format' => 'Format jam selesai harus HH:mm.',
                    'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
                    'id_guru.required' => 'Guru harus dipilih.',
                    'id_guru.exists' => 'Guru yang dipilih tidak valid.',
                    'id_mata_pelajaran.required' => 'Mata pelajaran harus dipilih.',
                    'id_mata_pelajaran.exists' => 'Mata pelajaran yang dipilih tidak valid.',
                    'tanggal.required' => 'Tanggal harus diisi.',
                    'tanggal.date' => 'Format tanggal tidak valid.',
                ],
            );

            $jadwalBentrok = JadwalPelajaran::where('id_kelas', $request->id_kelas)
                ->whereDate('tanggal', $request->tanggal)
                ->where('id_jadwal_pelajaran', '!=', $id)
                ->where(function ($query) use ($request) {
                    $query
                        ->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('jam_mulai', '<', $request->jam_selesai)->where('jam_selesai', '>', $request->jam_mulai);
                        });
                })
                ->exists();

            if ($jadwalBentrok) {
                return back()->withInput()->with('error', 'Jadwal bentrok dengan jadwal lain pada kelas dan tanggal yang sama.');
            }

            $jadwal->update([
                'id_kelas' => $request->id_kelas,
                'hari' => Carbon::parse($request->tanggal)->translatedFormat('l'),
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'id_guru' => $request->id_guru,
                'id_mata_pelajaran' => $request->id_mata_pelajaran,
                'tanggal' => $request->tanggal,
            ]);

            return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('jadwal.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $jadwal = JadwalPelajaran::findOrFail($id);
            $jadwal->delete();

            return redirect()->route('jadwal.index')->with('success', 'Jadwal pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('jadwal.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
