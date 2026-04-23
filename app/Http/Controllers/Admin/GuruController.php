<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\Guru;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_guru', 'like', '%' . $request->search . '%');
        }

        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan', 'like', '%' . $request->jabatan . '%');
        }

        $gurus = $query->paginate(10)->appends($request->all());

        // Statistik
        $totalGuru = Guru::count();
        $guruLaki = Guru::where('jenis_kelamin', 'L')->count();
        $guruPerempuan = Guru::where('jenis_kelamin', 'P')->count();

        return view('Admin.Guru.index', compact('gurus', 'totalGuru', 'guruLaki', 'guruPerempuan'));
    }

    public function create()
    {
        return view('Admin.Guru.create');
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('Admin.Guru.edit', compact('guru'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_guru' => 'required',
            'nuptk' => 'required|unique:guru,nuptk', // wajib & unik
            'nip' => 'nullable|unique:guru,nip', // boleh kosong & unik
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'nullable',
            'alamat' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['id_user'] = 1;

        Guru::create($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_guru' => 'required',
            'nuptk' => 'required|unique:guru,nuptk,' . $id . ',id_guru',
            'nip' => 'nullable|unique:guru,nip,' . $id . ',id_guru',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'nullable',
            'alamat' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['id_user'] = $guru->id_user;

        $guru->update($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
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
            'file_excel' => 'required|mimes:xls,xlsx|max:2048',
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
