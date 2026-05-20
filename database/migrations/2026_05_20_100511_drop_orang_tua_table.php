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
        // 🔥 hapus foreign key notification
        Schema::table('notification', function (Blueprint $table) {
            $table->dropForeign(['id_orang_tua']);
        });

        // 🔥 hapus kolomnya juga
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn('id_orang_tua');
        });

        Schema::dropIfExists('orang_tua');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id('id_orang_tua');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        // 🔥 kembalikan kolom id_orang_tua di notification
        Schema::table('notification', function (Blueprint $table) {
            $table->foreignId('id_orang_tua')->nullable()->after('id_siswa')->constrained('orang_tua')->nullOnDelete();
        });
    }
};
