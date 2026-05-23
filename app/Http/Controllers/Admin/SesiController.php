<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SesiPelajaran;
use Illuminate\Http\Request;

class SesiController extends Controller
{
    public function index(Request $request)
    {
        $query = SesiPelajaran::query();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where('nama_sesi', 'like', '%' . $request->search . '%');
        }

        // 🔍 FILTER HARI
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $sesiList = $query->orderBy('jam_mulai')->paginate(10)->withQueryString();

        return view('Admin.Sesi.index', compact('sesiList'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_sesi' => 'required|string|max:255',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ], [
                'nama_sesi.required' => 'Nama sesi pelajaran wajib diisi.',
                'jam_mulai.required' => 'Jam mulai wajib diisi.',
                'jam_selesai.required' => 'Jam selesai wajib diisi.',
                'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            ]);

            SesiPelajaran::create($request->all());

            return redirect()->back()->with('success', 'Sesi pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sesi = SesiPelajaran::findOrFail($id);
            $sesi->delete();

            return redirect()->back()->with('success', 'Sesi pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_sesi' => 'required|string|max:255',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ], [
                'nama_sesi.required' => 'Nama sesi pelajaran wajib diisi.',
                'jam_mulai.required' => 'Jam mulai wajib diisi.',
                'jam_selesai.required' => 'Jam selesai wajib diisi.',
                'jam_selesai.after' => 'Jam selesai harus setelah jam mulai.',
            ]);

            $sesi = SesiPelajaran::findOrFail($id);
            $sesi->update($request->all());

            return redirect()->back()->with('success', 'Sesi pelajaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
