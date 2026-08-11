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
    Schema::create('absensi', function (Blueprint $table) {

        $table->id();

        $table->foreignId('pegawai_id')
              ->constrained('pegawai')
              ->cascadeOnDelete();

        $table->date('tanggal');

        $table->time('jam_masuk')->nullable();

        $table->time('jam_pulang')->nullable();

        $table->integer('jam_mengajar')->default(0);

        $table->string('foto_masuk')->nullable();

        $table->string('foto_pulang')->nullable();

        $table->enum('status',[
            'Hadir',
            'Izin',
            'Sakit',
            'Alpha'
        ])->default('Hadir');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
