<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalMengajar;

class TahunPelajaran extends Model
{
    protected $fillable = [
    'tahun_ajaran',
    'semester',
    'status',
];

    public function jadwalMengajar()
    {
        return $this->hasMany(JadwalMengajar::class);
    }
}