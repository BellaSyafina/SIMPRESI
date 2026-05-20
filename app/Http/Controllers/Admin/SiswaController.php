<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        // 🔍 Filter kelas
        if ($request->filled('kelas')) {
            $query->where('id_kelas', $request->kelas);
        }

        // 🔍 Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 🔥 sorting
        $query->orderBy('nama_siswa');

        $siswas = $query->paginate(10)->appends($request->all());

        // 📊 Statistik
        $totalSiswa = Siswa::count();

        $siswaLaki = Siswa::where('jenis_kelamin', 'L')->count();

        $siswaPerempuan = Siswa::where('jenis_kelamin', 'P')->count();

        // 🔥 dropdown kelas
        $kelas = Kelas::orderBy('nama_kelas')->pluck('nama_kelas', 'id_kelas');

        return view('Admin.Siswa.index', compact('siswas', 'kelas', 'totalSiswa', 'siswaLaki', 'siswaPerempuan'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->pluck('nama_kelas', 'id_kelas');

        return view('Admin.Siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'nisn' => 'required|unique:siswa,nisn',
                    'nis' => 'required|unique:siswa,nis',
                    'nama_siswa' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'agama' => 'nullable|string|max:50',
                    'tempat_lahir' => 'nullable|string|max:255',
                    'tanggal_lahir' => 'nullable|date',
                    'email_wali' => 'nullable|email',
                    'status' => 'required|in:aktif,lulus,pindah,keluar',
                ],
                [
                    'nisn.required' => 'NISN wajib diisi.',
                    'nisn.unique' => 'NISN sudah digunakan.',
                    'nis.required' => 'NIS wajib diisi.',
                    'nis.unique' => 'NIS sudah digunakan.',
                    'nama_siswa.required' => 'Nama siswa wajib diisi.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'id_kelas.required' => 'Kelas wajib dipilih.',
                    'email_wali.email' => 'Format email wali tidak valid.',
                ],
            );

            // 🔥 generate email dari NIS/NISN
            $emailLogin = $request->nisn . '@siswa.com';
            // 🔥 password default = tanggal lahir
            $passwordDefault = $request->tanggal_lahir ? \Carbon\Carbon::parse($request->tanggal_lahir)->format('dmY') : '12345678';

            // 🔥 buat akun user siswa
            $user = User::create([
                'name' => $request->nama_siswa,
                'email' => $emailLogin,
                'password' => Hash::make($passwordDefault),
                'role' => 'siswa',
            ]);

            // 🔥 simpan siswa
            Siswa::create([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'status' => $request->status ?? 'aktif',
                'id_kelas' => $request->id_kelas,
                'id_user' => $user->id,

                // 🔥 data ayah
                'nama_ayah' => $request->nama_ayah,
                'no_hp_ayah' => $request->no_hp_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,

                // 🔥 data ibu
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ibu' => $request->no_hp_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,

                // 🔥 data wali
                'nama_wali' => $request->nama_wali,
                'no_hp_wali' => $request->no_hp_wali,
                'email_wali' => $request->email_wali,
                'pekerjaan_wali' => $request->pekerjaan_wali,

                'alamat_orang_tua' => $request->alamat_orang_tua,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::orderBy('nama_kelas')->pluck('nama_kelas', 'id_kelas');

        return view('Admin.Siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $request->validate(
                [
                    'nisn' => 'required|unique:siswa,nisn,' . $siswa->id_siswa . ',id_siswa',
                    'nis' => 'required|unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
                    'nama_siswa' => 'required|string|max:255',
                    'jenis_kelamin' => 'required|in:L,P',
                    'id_kelas' => 'required|exists:kelas,id_kelas',
                    'agama' => 'nullable|string|max:50',
                    'tempat_lahir' => 'nullable|string|max:255',
                    'tanggal_lahir' => 'nullable|date',
                    'email_wali' => 'nullable|email',
                    'status' => 'required|in:aktif,lulus,pindah,keluar',
                ],
                [
                    'nisn.required' => 'NISN wajib diisi.',
                    'nisn.unique' => 'NISN sudah digunakan.',
                    'nis.required' => 'NIS wajib diisi.',
                    'nis.unique' => 'NIS sudah digunakan.',
                    'nama_siswa.required' => 'Nama siswa wajib diisi.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'id_kelas.required' => 'Kelas wajib dipilih.',
                    'email_wali.email' => 'Format email wali tidak valid.',
                ],
            );

            // 🔥 update akun login siswa
            if ($siswa->user) {
                $siswa->user->update([
                    'name' => $request->nama_siswa,
                    'email' => $request->nisn . '@siswa.com',
                ]);
            }

            // 🔥 update siswa
            $siswa->update([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama_siswa' => $request->nama_siswa,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'status' => $request->status,
                'id_kelas' => $request->id_kelas,

                // 🔥 data ayah
                'nama_ayah' => $request->nama_ayah,
                'no_hp_ayah' => $request->no_hp_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,

                // 🔥 data ibu
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ibu' => $request->no_hp_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,

                // 🔥 data wali
                'nama_wali' => $request->nama_wali,
                'no_hp_wali' => $request->no_hp_wali,
                'email_wali' => $request->email_wali,
                'pekerjaan_wali' => $request->pekerjaan_wali,

                'alamat_orang_tua' => $request->alamat_orang_tua,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
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

    public function resetPassword($id)
    {
        try {
            $siswa = Siswa::with('user')->findOrFail($id);

            if (!$siswa->user) {
                return back()->with('error', 'Akun siswa tidak ditemukan.');
            }

            // 🔥 password default
            $passwordDefault = $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('dmY') : '12345678';

            $siswa->user->update([
                'password' => Hash::make($passwordDefault),
            ]);

            return back()->with('success', 'Password berhasil direset.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
