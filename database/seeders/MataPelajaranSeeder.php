<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            'PAI',
            'PKN',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Matematika',
            'IPA',
            'IPS',
            'Informatika',
            'Seni Budaya',
            'PJOK',
            'Bahasa Arab',
            'Bahasa Sunda',
            'BTQ',
        ];

        foreach ($mapel as $nama) {
            MataPelajaran::firstOrCreate([
                'nama' => $nama
            ]);
        }
    }
}