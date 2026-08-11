<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->foreignId('komponen_gaji_id')
                  ->nullable()
                  ->constrained('master_komponen_penggajians')
                  ->onDelete('set null')
                  ->after('jabatan_id');
        });
    }

    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['komponen_gaji_id']);
            $table->dropColumn('komponen_gaji_id');
        });
    }
};