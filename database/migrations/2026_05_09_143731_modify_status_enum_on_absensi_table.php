<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('absensi')
            ->where('status', 'alfa')
            ->update(['status' => 'alpa']);

        DB::statement("ALTER TABLE absensi MODIFY status ENUM('hadir', 'izin', 'sakit', 'alpa') DEFAULT 'hadir'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE absensi MODIFY status ENUM('hadir', 'izin', 'sakit', 'alfa') DEFAULT 'hadir'");
    }
};
