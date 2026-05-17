<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activities = $user->loginActivities()->latest()->take(5)->get();

        return view('Admin.Account.index', compact('user', 'activities'));
    }

    public function uploadFoto(Request $request)
    {
        try {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user = Auth::user();

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/foto'), $filename);

                // Hapus foto lama jika ada
                if ($user->foto) {
                    @unlink(public_path('uploads/foto/' . $user->foto));
                }

                // Simpan nama file baru ke database
                $user->update(['foto' => $filename]);
            }

            return back()->with('success', 'Foto profil berhasil diunggah');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengunggah foto: ' . $e->getMessage());
        }
    }
}
