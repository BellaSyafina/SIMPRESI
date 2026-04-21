<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalPelajaranController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\OrangTuaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login.index');
});

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'index'])->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Guru
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    // Route untuk menampilkan data kelas
    Route::get('/data-kelas', [KelasController::class, 'index'])->name('kelas.index');
    // Route untuk menyimpan data kelas baru
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');

    // Orang Tua
    Route::get('/orangtua', [OrangTuaController::class, 'index'])->name('orangtua.index');

    // Jadwal Pelajaran
    Route::get('/jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');

    // Laporan
    Route::get('/laporan-kehadiran', [LaporanController::class, 'index'])->name('laporan.index');
});
