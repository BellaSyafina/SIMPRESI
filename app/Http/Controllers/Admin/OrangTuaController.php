<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Imports\OrangTuaImport;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    public function index(Request $request)
    {
        $query = OrangTua::query();

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where('nama_orang_tua', 'like', '%' . $request->search . '%');
        }

        $orangTua = $query->paginate(10)->appends($request->all());

        // 📊 Statistik
        $total = OrangTua::count();
        $ortuLaki = OrangTua::where('jenis_kelamin', 'L')->count();
        $ortuPerempuan = OrangTua::where('jenis_kelamin', 'P')->count();
        $memilikiHp = OrangTua::whereNotNull('no_hp')->count();

        return view('Admin.OrangTua.index', compact('orangTua', 'total', 'ortuLaki', 'ortuPerempuan', 'memilikiHp'));
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file_excel' => 'required|file|mimes:xls,xlsx|max:2048',
        ]);

        try {
            // Proses import menggunakan SiswaImport
            Excel::import(new OrangTuaImport(), $request->file('file_excel'));

            return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()
                ->route('orangtua.index')
                ->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('Admin.OrangTua.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_orang_tua' => 'required',
                'jenis_kelamin' => 'required|in:L,P',
            ], [
                'nama_orang_tua.required' => 'Nama orang tua wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            ]);

            // 🔥 BUAT USER
            $user = User::create([
                'name' => $request->nama_orang_tua,
                'email' => strtolower(str_replace(' ', '', $request->nama_orang_tua)) . rand(100, 999) . '@ortu.com',
                'password' => Hash::make('12345678'), // default password
                'role' => 'orang_tua',
            ]);

            // 🔥 SIMPAN ORANG TUA
            OrangTua::create([
                'nama_orang_tua' => $request->nama_orang_tua,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'id_user' => $user->id,
            ]);

            return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->route('orangtua.index')
                ->with('error', 'Terjadi kesalahan saat menambahkan orang tua: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $orangTua = OrangTua::findOrFail($id);
        return view('Admin.OrangTua.edit', compact('orangTua'));
    }

    public function update(Request $request, $id)
    {
        try {
            $orangTua = OrangTua::findOrFail($id);

            $request->validate(
                [
                    'nama_orang_tua' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
                    'no_hp' => 'nullable|string|max:20',
                ],
                [
                    'nama_orang_tua.required' => 'Nama orang tua wajib diisi.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
                    'no_hp.max' => 'No. HP maksimal 20 karakter.',
                ],
            );

            // 🔥 Update data orang tua
            $orangTua->update([
                'nama_orang_tua' => $request->nama_orang_tua,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);

            return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $orangTua = OrangTua::findOrFail($id);
            $orangTua->delete();

            return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('orangtua.index')
                ->with('error', 'Terjadi kesalahan saat menghapus orang tua: ' . $e->getMessage());
        }
    }
}
