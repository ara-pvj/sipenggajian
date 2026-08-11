<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('tahun_pelajaran_id')
                ->nullable()
                ->after('pegawai_id')
                ->constrained('tahun_pelajarans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['tahun_pelajaran_id']);
            $table->dropColumn('tahun_pelajaran_id');
        });
    }
};