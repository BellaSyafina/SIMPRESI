<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user', 'mataPelajaran'); // 🔥 penting

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_guru', 'like', '%' . $request->search . '%');
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter jabatan
        if ($request->filled('mapel')) {
            $query->whereHas('mataPelajaran', function ($q) use ($request) {
                $q->where('mata_pelajaran.id_mata_pelajaran', $request->mapel);
            });
        }

        $gurus = $query->paginate(10)->withQueryString();

        $mapelList = MataPelajaran::pluck('nama_mata_pelajaran', 'id_mata_pelajaran');

        // Statistik
        $totalGuru = Guru::count();
        $guruLaki = Guru::where('jenis_kelamin', 'L')->count();
        $guruPerempuan = Guru::where('jenis_kelamin', 'P')->count();

        return view('Admin.Guru.index', compact('gurus', 'totalGuru', 'guruLaki', 'guruPerempuan', 'mapelList'));
    }

    public function create()
    {
        $mapelList = MataPelajaran::pluck('nama_mata_pelajaran', 'id_mata_pelajaran');

        return view('Admin.Guru.create', compact('mapelList'));
    }

    public function show($id)
    {
        $guru = Guru::findOrFail($id);

        $mapelList = MataPelajaran::pluck('nama_mata_pelajaran', 'id_mata_pelajaran');

        return view('Admin.Guru.update', compact('guru', 'mapelList'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'nama_guru' => 'required',
                    'nuptk' => 'required|unique:guru,nuptk',
                    'nip' => 'nullable|unique:guru,nip',
                    'jenis_kelamin' => 'required|in:L,P',
                    'alamat' => 'nullable',
                    'id_mata_pelajaran' => 'required|array', // 🔥 tambahan
                ],
                [
                    'nama_guru.required' => 'Nama guru wajib diisi.',
                    'nuptk.required' => 'NUPTK wajib diisi.',
                    'nuptk.unique' => 'NUPTK sudah digunakan.',
                    'nip.unique' => 'NIP sudah digunakan.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
                    'id_mata_pelajaran.required' => 'Mata pelajaran wajib dipilih.',
                    'id_mata_pelajaran.array' => 'Mata pelajaran harus berupa array.',
                ],
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // 🔥 generate email
            $email = Str::slug($request->nama_guru) . rand(100, 999) . '@gmail.com';

            // 🔥 buat user
            $user = User::create([
                'name' => $request->nama_guru,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'guru',
            ]);

            // 🔥 simpan guru
            $guru = Guru::create([
                'nama_guru' => $request->nama_guru,
                'nuptk' => $request->nuptk,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'id_user' => $user->id,
            ]);

            // 🔥 SIMPAN RELASI MAPEL
            $guru->mataPelajaran()->sync($request->id_mata_pelajaran);

            return redirect()
                ->route('guru.index')
                ->with('success', 'Data guru berhasil ditambahkan. Akun: ' . $email . ' | Password: password123');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $guru = Guru::findOrFail($id);

            $validator = Validator::make(
                $request->all(),
                [
                    'nama_guru' => 'required',
                    'nuptk' => 'required|unique:guru,nuptk,' . $id . ',id_guru',
                    'nip' => 'nullable|unique:guru,nip,' . $id . ',id_guru',
                    'jenis_kelamin' => 'required|in:L,P',
                    'alamat' => 'nullable',
                    'id_mata_pelajaran' => 'required|array', // 🔥 tambahan
                ],
                [
                    'nama_guru.required' => 'Nama guru wajib diisi.',
                    'nuptk.required' => 'NUPTK wajib diisi.',
                    'nuptk.unique' => 'NUPTK sudah digunakan.',
                    'nip.unique' => 'NIP sudah digunakan.',
                    'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
                    'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
                    'id_mata_pelajaran.required' => 'Mata pelajaran wajib dipilih.',
                    'id_mata_pelajaran.array' => 'Mata pelajaran harus berupa array.',
                ],
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // 🔥 update guru
            $guru->update([
                'nama_guru' => $request->nama_guru,
                'nuptk' => $request->nuptk,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
            ]);

            // 🔥 update user
            if ($guru->user) {
                $guru->user->update([
                    'name' => $request->nama_guru,
                    'role' => 'guru',
                ]);
            }

            // 🔥 UPDATE RELASI MAPEL
            $guru->mataPelajaran()->sync($request->id_mata_pelajaran);

            return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xls,xlsx|max:2048',
        ]);

        try {
            Excel::import(new GuruImport(), $request->file('file_excel'));

            return redirect()->route('guru.index')->with('success', 'Import data guru berhasil.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
