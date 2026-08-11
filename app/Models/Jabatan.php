<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
    'nama_jabatan',
    'gaji_jabatan',
    'transport',
    'jenis_pegawai'
];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'jabatan_id', 'id');
    }
}