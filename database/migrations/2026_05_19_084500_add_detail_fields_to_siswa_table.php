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
        Schema::table('siswa', function (Blueprint $table) {
            // 🔥 biodata siswa
            $table->string('tempat_lahir')->nullable();

            $table->date('tanggal_lahir')->nullable();

            $table->string('agama')->nullable();

            $table->string('foto')->nullable();

            // 🔥 email wali
            $table->string('email_wali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'agama',
                'foto',
                'email_wali'
            ]);
        });
    }
};
