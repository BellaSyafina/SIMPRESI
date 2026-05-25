<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingSistem;
use Illuminate\Http\Request;

class SettingSistemController extends Controller
{
    public function index()
    {
        $setting = SettingSistem::first();
        return view('Admin.settingSistem.index', compact('setting'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate(
                [
                    'nama_sekolah' => 'required|string|max:255',
                    'semester_aktif' => 'required|in:Genap,Ganjil',
                    'tahun_ajaran_aktif' => 'required|string|max:9',
                ],
                [
                    'nama_sekolah.required' => 'Nama sekolah wajib diisi',
                    'nama_sekolah.string' => 'Nama sekolah harus berupa teks',
                    'nama_sekolah.max' => 'Nama sekolah maksimal 255 karakter',

                    'semester_aktif.required' => 'Semester aktif wajib dipilih',
                    'semester_aktif.in' => 'Semester aktif tidak valid',

                    'tahun_ajaran_aktif.required' => 'Tahun ajaran aktif wajib diisi',
                    'tahun_ajaran_aktif.string' => 'Tahun ajaran aktif harus berupa teks',
                    'tahun_ajaran_aktif.max' => 'Tahun ajaran aktif maksimal 9 karakter (contoh: 2025/2026)',
                ],
            );

            $setting = SettingSistem::first();
            if ($setting) {
                $setting->update($request->only('nama_sekolah', 'semester_aktif', 'tahun_ajaran_aktif'));
            } else {
                SettingSistem::create($request->only('nama_sekolah', 'semester_aktif', 'tahun_ajaran_aktif'));
            }

            return redirect()->route('setting-sistem.index')->with('success', 'Setting sistem berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui setting sistem: ' . $e->getMessage());
        }
    }
}
