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
        Schema::table('kelas', function (Blueprint $table) {
            $table
                ->foreignId('id_guru')
                ->nullable()
                ->unique() // 🔥 ini yang bikin 1 guru cuma 1 kelas
                ->constrained('guru', 'id_guru')
                ->onDelete('set null');
            $table->string('ruang')->nullable();
            $table->enum('tingkat', ['7', '8', '9'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['id_guru', 'ruang', 'tingkat']);
        });
    }
};
