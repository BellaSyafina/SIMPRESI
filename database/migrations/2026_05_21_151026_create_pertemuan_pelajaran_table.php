<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pertemuan_pelajaran', function (Blueprint $table) {
            $table->id('id_pertemuan');
            $table->foreignId('id_jadwal_pelajaran')->constrained('jadwal_pelajaran', 'id_jadwal_pelajaran')->cascadeOnDelete();
            // 🔥 pertemuan ke
            $table->integer('pertemuan_ke');
            // 🔥 tanggal realisasi
            $table->date('tanggal');
            // 🔥 materi
            $table->text('materi')->nullable();
            // 🔥 catatan guru
            $table->text('catatan')->nullable();
            // 🔥 status
            $table->enum('status', ['belum', 'selesai', 'dibatalkan'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan_pelajaran');
    }
};
