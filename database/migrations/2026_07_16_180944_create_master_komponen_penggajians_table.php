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
        Schema::create('master_komponen_penggajians', function (Blueprint $table) {
    $table->id();

    $table->integer('tarif_jp_guru');
    $table->integer('tunjangan_jabatan');
    $table->integer('transport_guru');
    $table->integer('transport_staff');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_komponen_penggajians');
    }
};
