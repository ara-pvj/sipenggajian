<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TahunPelajaran;
use App\Models\JadwalMengajar;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
    'pegawai_id',
    'tahun_pelajaran_id',
    'jadwal_mengajar_id',
    'tanggal',
    'jam_masuk',
    'jam_pulang',
    'jam_mengajar',
    'foto_masuk',
    'foto_pulang',
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

public function jadwalMengajar()
{
    return $this->belongsTo(JadwalMengajar::class);
}

}