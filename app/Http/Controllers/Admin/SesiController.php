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
}
