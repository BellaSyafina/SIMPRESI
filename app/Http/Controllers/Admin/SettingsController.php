<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('Admin.settings.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . Auth::id(),
            ]);

            $user = Auth::user();
            $user->update($request->only('name', 'email'));

            return back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = Auth::user();

            if (!password_verify($request->current_password, $user->password)) {
                return back()->with('error', 'Password saat ini salah');
            }

            $user->update(['password' => bcrypt($request->new_password)]);

            return back()->with('success', 'Password berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui password: ' . $e->getMessage());
        }
    }

    public function updateSecurity(Request $request)
    {
        try {
            $request->validate([
                'login_verification' => 'required|boolean',
                'email_login_notification' => 'required|boolean',
            ]);

            $user = Auth::user();
            $user->update($request->only('login_verification', 'email_login_notification'));

            return back()->with('success', 'Pengaturan keamanan berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pengaturan keamanan: ' . $e->getMessage());
        }
    }

    public function logoutAll()
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();

            Auth::logout();

            return redirect()->route('login')->with('success', 'Semua sesi berhasil di logout');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat logout semua sesi: ' . $e->getMessage());
        }
    }
}
