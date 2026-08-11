<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JadwalMengajar;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
    'nama',
    'jenis_pegawai',
    'jabatan_id',
    'komponen_gaji_id',
    'tempat_lahir',
    'tanggal_lahir',
    'alamat',
    'gaji_pokok',
    'gaji_jabatan',
    'tarif_per_jam',
    'transport',
];

public function jabatan()
{
    return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
}

public function absensi()
{
    return $this->hasMany(Absensi::class);
}

public function penggajian()
{
    return $this->hasMany(Penggajian::class);
}

public function jadwalMengajar()
{
    return $this->hasMany(JadwalMengajar::class);
}

}
