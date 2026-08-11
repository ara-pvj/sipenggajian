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
    Schema::table('jadwal_mengajars', function (Blueprint $table) {

        $table->foreignId('tahun_pelajaran_id')
              ->after('pegawai_id')
              ->constrained('tahun_pelajarans')
              ->cascadeOnDelete();

    });
}

public function down(): void
{
    Schema::table('jadwal_mengajars', function (Blueprint $table) {

        $table->dropForeign(['tahun_pelajaran_id']);
        $table->dropColumn('tahun_pelajaran_id');

    });
}
};
