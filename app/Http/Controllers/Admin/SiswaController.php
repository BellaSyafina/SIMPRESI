<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        // 🔍 Search
        if ($request->filled('search')) {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        }

        // 🔍 Filter kelas
        if ($request->filled('kelas')) {
            $query->where('id_kelas', $request->kelas);
        }

        $siswas = $query->paginate(10)->appends($request->all());

        // 📊 Statistik
        $totalSiswa = Siswa::count();
        $siswaLaki = Siswa::where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = Siswa::where('jenis_kelamin', 'P')->count();

        // 🔥 dropdown kelas
        $kelas = Kelas::pluck('nama_kelas', 'id_kelas');

        return view('Admin.Siswa.index', compact('siswas', 'kelas', 'totalSiswa', 'siswaLaki', 'siswaPerempuan'));
    }

    public function create()
    {
        $kelas = Kelas::pluck('nama_kelas', 'id_kelas'); // Ambil nama kelas untuk dropdown
        $orangTua = OrangTua::all(); // Ambil nama orang tua untuk dropdown

        return view('Admin.Siswa.create', compact('kelas', 'orangTua'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'nisn' => 'required|unique:siswa,nisn',
                    'nis' => 'required|unique:siswa,nis',
                    'nama_siswa' => 'required',
                    'jenis_kelamin' => 'required|in:L,P',
                    'id_kelas' => 'required',
                ],
                [
                    'nisn.required' => 'NISN wajib diisi.',
                    'nisn.unique' => 'NISN sudah digunakan oleh siswa lain.',
                    'nis.required' => 'NIS wajib diisi.',
                    'nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
                    'nama_siswa.required' => 'Nama siswa wajib diisi.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
                    'id_kelas.required' => 'Kelas wajib dipilih.',
                ],
            );

            $idOrtu = null;

            if ($request->nama_orang_tua) {
                // 🔍 cek apakah sudah ada
                $ortu = OrangTua::where('nama_orang_tua', $request->nama_orang_tua)->first();

                if (!$ortu) {
                    // 🔥 buat akun user
                    $user = User::create([
                        'name' => $request->nama_orang_tua,
                        'email' => strtolower(str_replace(' ', '', $request->nama_orang_tua)) . rand(100, 999) . '@ortu.com',
                        'password' => Hash::make('12345678'),
                        'role' => 'orang_tua',
                    ]);

                    // 🔥 buat data orang tua
                    $ortu = OrangTua::create([
                        'nama_orang_tua' => $request->nama_orang_tua,
                        'id_user' => $user->id,
                    ]);
                }

                $idOrtu = $ortu->id_orang_tua;
            }

            // 🔥 simpan siswa
            Siswa::create([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'status' => $request->status ?? 'aktif',
                'id_kelas' => $request->id_kelas,
                'id_orang_tua' => $idOrtu,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->route('siswa.index')
                ->with('error', 'Terjadi kesalahan saat menambahkan siswa: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::pluck('nama_kelas', 'id_kelas'); // Ambil nama kelas untuk dropdown
        $orangTua = OrangTua::all(); // Ambil nama orang tua untuk dropdown

        return view('Admin.Siswa.edit', compact('siswa', 'kelas', 'orangTua'));
    }

    public function update(Request $request, $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $request->validate(
                [
                    'nisn' => 'required|unique:siswa,nisn,' . $siswa->id_siswa . ',id_siswa',
                    'nis' => 'required|unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
                    'nama_siswa' => 'required',
                    'jenis_kelamin' => 'required|in:L,P',
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                ],
                [
                    'nisn.required' => 'NISN wajib diisi.',
                    'nisn.unique' => 'NISN sudah digunakan oleh siswa lain.',
                    'nis.required' => 'NIS wajib diisi.',
                    'nis.unique' => 'NIS sudah digunakan oleh siswa lain.',
                    'nama_siswa.required' => 'Nama siswa wajib diisi.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
                    'id_kelas.required' => 'Kelas wajib dipilih.',
                    'id_kelas.exists' => 'Kelas tidak valid.',
                ],
            );

            // 🔥 HANDLE ORANG TUA
            $idOrtu = $siswa->id_orang_tua;

            if ($request->nama_orang_tua) {
                $ortu = OrangTua::where('nama_orang_tua', $request->nama_orang_tua)->first();

                if (!$ortu) {
                    // buat akun
                    $user = User::create([
                        'name' => $request->nama_orang_tua,
                        'email' => strtolower(str_replace(' ', '', $request->nama_orang_tua)) . rand(100, 999) . '@ortu.com',
                        'password' => Hash::make('12345678'),
                        'role' => 'orang_tua',
                    ]);

                    // buat data orang tua
                    $ortu = OrangTua::create([
                        'nama_orang_tua' => $request->nama_orang_tua,
                        'id_user' => $user->id,
                    ]);
                }

                $idOrtu = $ortu->id_orang_tua;
            }

            // 🔥 UPDATE SISWA
            $siswa->update([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'status' => $request->status ?? 'aktif',
                'id_kelas' => $request->id_kelas,
                'id_orang_tua' => $idOrtu, // 🔥 ini tambahan penting
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->route('siswa.index')
                ->with('error', 'Terjadi kesalahan saat memperbarui siswa: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('siswa.index')
                ->with('error', 'Terjadi kesalahan saat menghapus siswa: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx|max:2048',
        ]);

        try {
            Excel::import(new SiswaImport(), $request->file('file_excel'));

            return redirect()->route('siswa.index')->with('success', 'Import berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
