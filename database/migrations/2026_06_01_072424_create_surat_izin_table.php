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
        Schema::create('surat_izin', function (Blueprint $table) {
            $table->id('id_surat_izin');

            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->cascadeOnDelete();

            $table->date('tanggal');

            $table->enum('jenis', ['izin', 'sakit']);

            $table->text('keterangan')->nullable();

            $table->string('file_surat');

            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_izin');
    }
};
