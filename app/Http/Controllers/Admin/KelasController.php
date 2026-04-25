<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['guru'])
            ->withCount('siswa') // 🔥 ini kuncinya
            ->get();
        $guru = Guru::all()->pluck('nama_guru', 'id_guru'); // Ambil nama guru untuk dropdown (jika diperlukan)

        // Statistik
        $totalKelas = $kelas->count();
        $kelas7Count = $kelas->where('tingkat', '7')->count();
        $kelas8Count = $kelas->where('tingkat', '8')->count();
        $kelas9Count = $kelas->where('tingkat', '9')->count();

        return view('Admin.Kelas.index', compact('kelas', 'totalKelas', 'kelas7Count', 'kelas8Count', 'kelas9Count', 'guru'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_kelas' => 'required|string|max:255',
                'id_guru' => 'nullable|exists:guru,id_guru',
                'ruang' => 'nullable|string|max:255',
                'tingkat' => 'nullable|in:7,8,9',
            ]);

            Kelas::create($request->all());

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Terjadi kesalahan saat menambahkan kelas: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Kelas $kelas)
    {
        try {
            $request->validate([
                'nama_kelas' => 'required|string|max:255',
                'id_guru' => 'nullable|exists:guru,id_guru',
                'ruang' => 'nullable|string|max:255',
                'tingkat' => 'nullable|in:7,8,9',
            ]);

            $kelas->update($request->all());

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Terjadi kesalahan saat memperbarui kelas: ' . $e->getMessage());
        }
    }

    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();

            return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kelas: ' . $e->getMessage());
        }
    }

}
