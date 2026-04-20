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
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('wali_kelas')->nullable()->after('nama_kelas');
            $table->string('ruang')->nullable()->after('wali_kelas');
            $table->integer('jumlah_siswa')->default(0)->after('ruang');
            $table->enum('tingkat', ['7', '8', '9'])->nullable()->after('jumlah_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['wali_kelas', 'ruang', 'jumlah_siswa', 'tingkat']);
        });
    }
};
