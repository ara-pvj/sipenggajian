<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('penggajian', function (Blueprint $table) {
        $table->integer('jumlah_hadir')->default(0)->after('total_jam');
        $table->integer('jp_wajib')->default(0)->after('jumlah_hadir');
        $table->bigInteger('gaji_jabatan')->default(0)->after('gaji_pokok');
        $table->bigInteger('gaji_mengajar')->default(0)->after('total_jam');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            //
        });
    }
};
