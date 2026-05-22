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
        Schema::table('absensi', function (Blueprint $table) {
            // 🔥 tambah relasi pertemuan
            $table->foreignId('id_pertemuan')->nullable()->after('id_absensi')->constrained('pertemuan_pelajaran', 'id_pertemuan')->cascadeOnDelete();
        });

        Schema::table('absensi', function (Blueprint $table) {
            // 🔥 hapus foreign jadwal
            $table->dropForeign(['id_jadwal_pelajaran']);

            // 🔥 hapus kolom lama
            $table->dropColumn(['id_jadwal_pelajaran', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('id_jadwal_pelajaran')->nullable();
            $table->date('tanggal')->nullable();
            $table->dropForeign(['id_pertemuan']);
            $table->dropColumn('id_pertemuan');
        });
    }
};
