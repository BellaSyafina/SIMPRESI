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
        Schema::table('siswa', function (Blueprint $table) {
            // 🔥 hapus foreign key dulu
            $table->dropForeign(['id_orang_tua']);

            // 🔥 baru hapus kolom
            $table->dropColumn('id_orang_tua');

            // 🔥 data ayah
            $table->string('nama_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();

            // 🔥 data ibu
            $table->string('nama_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();

            // 🔥 data wali
            $table->string('nama_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();

            // 🔥 alamat keluarga
            $table->text('alamat_orang_tua')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            // 🔥 kembalikan relasi lama
            $table->unsignedBigInteger('id_orang_tua')->nullable();

            // 🔥 hapus kolom baru
            $table->dropColumn(['nama_ayah', 'no_hp_ayah', 'pekerjaan_ayah', 'nama_ibu', 'no_hp_ibu', 'pekerjaan_ibu', 'nama_wali', 'no_hp_wali', 'pekerjaan_wali', 'alamat_orang_tua']);
        });
    }
};
