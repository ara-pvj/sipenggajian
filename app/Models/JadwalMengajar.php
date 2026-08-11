<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Absensi;

class JadwalMengajar extends Model
{
    protected $table = 'jadwal_mengajars';

    protected $fillable = [
    'pegawai_id',
    'tahun_pelajaran_id',
    'kelas',
    'mata_pelajaran',
    'hari',
    'jam_mulai',
    'jam_selesai',
    'jumlah_jp',
];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function tahunPelajaran()
{
    return $this->belongsTo(TahunPelajaran::class);
}

public function absensi()
{
    return $this->hasMany(Absensi::class);
}

}