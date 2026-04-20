<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;

        $guru = Guru::with('user')->paginate($limit);

        return view('Admin.Guru.index', compact('guru'));
    }
}
