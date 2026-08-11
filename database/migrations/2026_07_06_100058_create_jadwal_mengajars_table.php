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
        Schema::create('jadwal_mengajars', function (Blueprint $table) {

            $table->id();

$table->foreignId('pegawai_id')
      ->constrained('pegawai')
      ->onDelete('cascade');

$table->string('kelas');

$table->string('mata_pelajaran');

$table->enum('hari',[
    'Senin',
    'Selasa',
    'Rabu',
    'Kamis',
    'Jumat',
    'Sabtu'
]);

$table->time('jam_mulai');

$table->time('jam_selesai');

$table->integer('jumlah_jp');

$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mengajars');
    }
};