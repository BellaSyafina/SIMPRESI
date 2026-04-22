<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan-absensi', function (Blueprint $table) {
        $table->id('id_laporan');
        $table->unsignedBigInteger('id_siswa');
        $table->date('tanggal');
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_absensis');
    }
};
