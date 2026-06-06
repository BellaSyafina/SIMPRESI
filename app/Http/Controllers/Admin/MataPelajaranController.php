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
            $query->where(function ($q) use ($request) {
                $q->where('kode_mapel', 'like', '%' . $request->search . '%')->orWhere('nama_mata_pelajaran', 'like', '%' . $request->search . '%');
            });
        }

        $mapelAll = $query->orderByDesc('id_mata_pelajaran')->get();

        $mapelGroup = $mapelAll->groupBy(function ($item) {
            return preg_replace('/\sKelas\s[789]$/', '', $item->nama_mata_pelajaran);
        });

        $totalMapel = MataPelajaran::count();

        return view('Admin.MataPelajaran.index', compact('mapelGroup', 'totalMapel'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel',
                'nama_mata_pelajaran' => 'required',
            ]);

            MataPelajaran::create($request->all());

            return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->route('mata-pelajaran.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);

        try {
            $request->validate([
                'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel,' . $mataPelajaran->id_mata_pelajaran . ',id_mata_pelajaran',
                'nama_mata_pelajaran' => 'required',
            ]);

            $mataPelajaran->update($request->all());

            return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->route('mata-pelajaran.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
