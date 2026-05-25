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
        Schema::create('setting_sistem', function (Blueprint $table) {
            $table->id('id_setting');
            $table->string('nama_sekolah')->nullable();
            $table->enum('semester_aktif', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran_aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_sistem');
    }
};
