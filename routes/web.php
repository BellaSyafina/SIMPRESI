<?php

use App\Http\Controllers\Admin\AbsensiSiswaController;
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
    Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
    Route::post('/guru/store', [GuruController::class, 'store'])->name('guru.store');
    Route::get('/guru/{guru}/edit', [GuruController::class, 'show'])->name('guru.show');
    Route::put('/guru/{guru}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::post('/guru/import', [GuruController::class, 'import'])->name('guru.import');

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/data-kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::post('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');

    // Orang Tua
    Route::get('/orangtua', [OrangTuaController::class, 'index'])->name('orangtua.index');

    // Jadwal Pelajaran
    Route::get('/jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');

    // Absensi Siswa
    Route::get('/absensi', [AbsensiSiswaController::class, 'index'])->name('absensi.index');

    // Laporan
    Route::get('/laporan-kehadiran', [LaporanController::class, 'index'])->name('laporan.index');
});
