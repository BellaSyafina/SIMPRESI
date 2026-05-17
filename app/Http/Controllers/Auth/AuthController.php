<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginActivity;
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
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password wajib diisi',
            ],
        );

        // ambil data login
        $credentials = $request->only('email', 'password');

        // cek login
        if (Auth::attempt($credentials, $request->remember)) {
            // regenerasi session (biar aman)
            $request->session()->regenerate();

            Auth::user()->update([
                'last_login_at' => now(),
            ]);

            LoginActivity::create([
                'user_id' => Auth::id(),
                'activity' => 'Login Berhasil',
                'description' => 'Login ke sistem SIMPRESI',
            ]);

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

        return redirect()->to('/login');
    }
}
