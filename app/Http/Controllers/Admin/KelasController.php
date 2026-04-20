<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        // Ambil semua data kelas
        $kelas = Kelas::all();

        // Hitung total kelas
        $totalKelas = $kelas->count();

        // Hitung kelas berdasarkan tingkat
        $kelas7Count = $kelas->where('tingkat', '7')->count();
        $kelas8Count = $kelas->where('tingkat', '8')->count();
        $kelas9Count = $kelas->where('tingkat', '9')->count();

        // Kirim ke view
        return view('Admin.Kelas.index', compact('kelas', 'totalKelas', 'kelas7Count', 'kelas8Count', 'kelas9Count'));
    }
}
