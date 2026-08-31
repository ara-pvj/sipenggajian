<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'nama',
    ];

    public function pegawai()
    {
        return $this->belongsToMany(
            Pegawai::class,
            'pegawai_mata_pelajaran',
            'mata_pelajaran_id',
            'pegawai_id'
        );
    }
}
