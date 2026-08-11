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
    Schema::table('absensi', function (Blueprint $table) {
        $table->foreignId('jadwal_mengajar_id')
            ->nullable()
            ->after('tahun_pelajaran_id')
            ->constrained('jadwal_mengajars')
            ->nullOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('absensi', function (Blueprint $table) {
        $table->dropForeign(['jadwal_mengajar_id']);
        $table->dropColumn('jadwal_mengajar_id');
    });
}

};
