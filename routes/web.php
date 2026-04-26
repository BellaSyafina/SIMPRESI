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
    Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'show'])->name('siswa.show');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');

    // Orang Tua
    Route::get('/orangtua', [OrangTuaController::class, 'index'])->name('orangtua.index');
    Route::get('/orangtua/create', [OrangTuaController::class, 'create'])->name('orangtua.create');
    Route::post('/orangtua/store', [OrangTuaController::class, 'store'])->name('orangtua.store');
    Route::post('/orangtua/import', [OrangTuaController::class, 'import'])->name('orangtua.import');
    Route::get('/orangtua/{orangTua}/edit', [OrangTuaController::class, 'edit'])->name('orangtua.edit');
    Route::put('/orangtua/{orangTua}', [OrangTuaController::class, 'update'])->name('orangtua.update');
    Route::delete('/orangtua/{orangTua}', [OrangTuaController::class, 'destroy'])->name('orangtua.destroy');

    // Jadwal Pelajaran
    Route::get('/jadwal', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');

    // Absensi Siswa
    Route::get('/absensi', [AbsensiSiswaController::class, 'index'])->name('absensi.index');

    // Laporan
    Route::get('/laporan-kehadiran', [LaporanController::class, 'index'])->name('laporan.index');
});
