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
    Schema::table('pegawai', function (Blueprint $table) {

        $table->string('jabatan')->nullable();

        $table->decimal('gaji_pokok',12,2)->nullable();

        $table->decimal('tunjangan_jabatan',12,2)->nullable();

        $table->decimal('tarif_per_jam',12,2)->nullable();

        $table->decimal('transport',12,2)->default(0);

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('pegawai', function (Blueprint $table) {

        $table->dropColumn([
            'jabatan',
            'gaji_pokok',
            'tunjangan_jabatan',
            'tarif_per_jam',
            'transport'
        ]);

    });
}
};
