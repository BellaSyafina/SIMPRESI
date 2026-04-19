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
        Schema::create('notification', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_orang_tua');
            $table->text('pesan');
            $table->enum('status', ['pending', 'terkirim', 'gagal'])->default('pending');
            $table->integer('retry_count')->default(0);
            $table->timestamp('waktu_kirim')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_orang_tua')->references('id_orang_tua')->on('orang_tua')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
