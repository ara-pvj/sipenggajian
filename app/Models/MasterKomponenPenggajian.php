<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKomponenPenggajian extends Model
{
    protected $fillable = [
        'tarif_jp_guru',
        'transport_guru',
        'transport_staff',
        'tunjangan_jabatan',
    ];
}
