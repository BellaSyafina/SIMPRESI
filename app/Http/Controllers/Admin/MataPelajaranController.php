<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::query();

        if ($request->search) {
            $query->where('nama_mata_pelajaran', 'like', '%' . $request->search . '%');
        }

        $mapel = $query->paginate(10)->appends($request->all());
        $totalMapel = MataPelajaran::count();

        return view('Admin.MataPelajaran.index', compact('mapel', 'totalMapel'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_mata_pelajaran' => 'required|unique:mata_pelajaran,nama_mata_pelajaran',
            ]);

            MataPelajaran::create($request->all());

            return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        try {
            $request->validate([
                'nama_mata_pelajaran' => 'required|unique:mata_pelajaran,nama_mata_pelajaran,' . $mataPelajaran->id_mata_pelajaran . ',id_mata_pelajaran',
            ]);

            $mataPelajaran->update($request->all());

            return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        try {
            $mataPelajaran->delete();

            return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('mata-pelajaran.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
