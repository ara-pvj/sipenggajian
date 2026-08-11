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
    Schema::create('penggajian', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pegawai_id')
              ->constrained('pegawai')
              ->onDelete('cascade');

        $table->date('periode');

        $table->integer('total_jam')->default(0);

        $table->bigInteger('gaji_pokok')->default(0);

        $table->bigInteger('transport')->default(0);

        $table->bigInteger('gaji_total');

        $table->enum('status', ['Belum Dibayar', 'Sudah Dibayar'])
              ->default('Belum Dibayar');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
