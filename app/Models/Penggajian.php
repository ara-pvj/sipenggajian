<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model

{
    protected $table = 'penggajian';
    protected $fillable = [
        'pegawai_id',
        'tahun_pelajaran_id',
        'periode',
        'total_jam',
        'jumlah_hadir',    // <-- TAMBAHKAN
        'jp_wajib',        // <-- TAMBAHKAN
        'gaji_mengajar',
        'gaji_jabatan',
        'gaji_pokok',
        'transport',
        'gaji_total',
        'status',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }
}