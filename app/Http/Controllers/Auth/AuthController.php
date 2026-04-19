<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('Layouts.template-auth');
    }

    public function login(Request $request)
    {
        // validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ambil data login
        $credentials = $request->only('email', 'password');

        // cek login
        if (Auth::attempt($credentials, $request->remember)) {
            // regenerasi session (biar aman)
            $request->session()->regenerate();

            // 🔥 langsung ke dashboard
            return redirect('/dashboard');
        }

        // kalau gagal
        return back()->with('error', 'Email atau password salah');
    }

    // 🔥 LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
