<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa; // import model Siswa

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas')->get(); // ambil semua siswa + nama kelas
        return view('Admin.Siswa.index', compact('siswa'));
    }

    // Tambahkan method untuk form import (opsional, jika pakai file terpisah)
    public function importForm()
    {
        return view('Admin.Siswa.import');
    }

    // Method proses import (butuh package maatwebsite/excel)
    public function importProcess(Request $request)
    {
        // validasi dan import
    }

    // Method create, store, edit, update, destroy (CRUD)
}
