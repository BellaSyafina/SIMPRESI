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
        $selectedHari = $request->hari ?? 'Senin';

        $selectedDate = Carbon::now()->startOfWeek()->addDays(array_search($selectedHari, $hariList));
        $formattedDate = $selectedDate->translatedFormat('l, d F Y');

        // 🔥 DATA JADWAL REAL
        $jadwal = JadwalPelajaran::with(['guru', 'mataPelajaran'])
            ->where('id_kelas', $selectedKelas)
            ->where('hari', $selectedHari)
            ->orderBy('jam_mulai')
            ->get();

        // 🔥 RINGKASAN
        $ringkasan = [];
        foreach ($hariList as $hari) {
            $ringkasan[$hari] = JadwalPelajaran::where('id_kelas', $selectedKelas)->where('hari', $hari)->count();
        }

        // 🔥 DATA UNTUK MODAL
        $guruList = Guru::pluck('nama_guru', 'id_guru');
        $mapelList = MataPelajaran::pluck('nama_mata_pelajaran', 'id_mata_pelajaran');

        return view('Admin.jadwalPelajaran.index', compact('kelasList', 'hariList', 'jadwal', 'ringkasan', 'selectedKelas', 'selectedHari', 'formattedDate', 'selectedDate', 'guruList', 'mapelList'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
                    'jam_mulai' => 'required|date_format:H:i',
                    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                    'id_guru' => 'required|exists:guru,id_guru',
                    'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
                    'tanggal' => 'required|date',
                ],
                [
                    'id_kelas.required' => 'Kelas harus dipilih.',
                    'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
                    'hari.required' => 'Hari harus dipilih.',
                    'hari.in' => 'Hari yang dipilih tidak valid.',
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

            JadwalPelajaran::create($request->all());

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
                    'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
                    'jam_mulai' => 'required|date_format:H:i',
                    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
                    'id_guru' => 'required|exists:guru,id_guru',
                    'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
                    'tanggal' => 'required|date',
                ],
                [
                    'id_kelas.required' => 'Kelas harus dipilih.',
                    'id_kelas.exists' => 'Kelas yang dipilih tidak valid.',
                    'hari.required' => 'Hari harus dipilih.',
                    'hari.in' => 'Hari yang dipilih tidak valid.',
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

            $jadwal->update($request->all());

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
