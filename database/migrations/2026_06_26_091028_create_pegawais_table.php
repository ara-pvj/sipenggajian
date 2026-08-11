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
    Schema::create('pegawai', function (Blueprint $table) {

        $table->id();

        $table->string('nama');

        $table->enum('jenis_pegawai', ['guru', 'staf']);

        $table->string('tempat_lahir');

        $table->date('tanggal_lahir');

        $table->text('alamat');

        $table->timestamps();

    });
}

public function down(): void
{
    Schema::dropIfExists('pegawai');
}

};
