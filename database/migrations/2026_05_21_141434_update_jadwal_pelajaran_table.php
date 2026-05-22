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
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sesi')->after('hari');
            $table->string('semester')->nullable();
            $table->string('tahun_ajaran')->nullable();

            $table->dropColumn(['tanggal', 'jam_mulai', 'jam_selesai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->date('tanggal')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();

            $table->dropColumn(['id_sesi', 'semester', 'tahun_ajaran']);
        });
    }
};
