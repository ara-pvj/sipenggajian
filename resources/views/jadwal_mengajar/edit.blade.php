@extends('layouts.app')

@section('title','Edit Jadwal Mengajar')
@section('page-title','Edit Jadwal Mengajar')
@section('page-subtitle','Ubah data jadwal mengajar guru')

@section('content')

<form action="{{ route('jadwal-mengajar.update',$jadwal->id) }}" method="POST">

@csrf
@method('PUT')

<div class="bg-white rounded-xl shadow p-6">

    <div class="mb-5">
        <label class="block font-semibold mb-2">Guru</label>

        <select name="pegawai_id" class="w-full border rounded-lg p-3">

            @foreach($guru as $item)

                <option
                    value="{{ $item->id }}"
                    {{ $jadwal->pegawai_id == $item->id ? 'selected' : '' }}>

                    {{ $item->nama }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Tahun Pelajaran
        </label>

        <select
            name="tahun_pelajaran_id"
            class="w-full border rounded-lg p-3">

            @foreach($tahun as $item)

                <option
                    value="{{ $item->id }}"
                    {{ $jadwal->tahun_pelajaran_id == $item->id ? 'selected' : '' }}>

                    {{ $item->tahun_ajaran }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Hari
        </label>

        <select name="hari" class="w-full border rounded-lg p-3">

            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)

                <option
                    value="{{ $hari }}"
                    {{ $jadwal->hari == $hari ? 'selected' : '' }}>

                    {{ $hari }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Kelas
        </label>

        <select name="kelas" class="w-full border rounded-lg p-3">

            @foreach(['VII','VIII','IX'] as $kelas)

                <option
                    value="{{ $kelas }}"
                    {{ $jadwal->kelas == $kelas ? 'selected' : '' }}>

                    {{ $kelas }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Mata Pelajaran
        </label>

        <select
            name="mata_pelajaran"
            class="w-full border rounded-lg p-3">

            @foreach([
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
                'BTQ'
            ] as $mapel)

                <option
                    value="{{ $mapel }}"
                    {{ $jadwal->mata_pelajaran == $mapel ? 'selected' : '' }}>

                    {{ $mapel }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="grid grid-cols-3 gap-5">

        <div>

            <label class="block font-semibold mb-2">
                Jam Mulai
            </label>

            <input
                type="time"
                id="jam_mulai"
                name="jam_mulai"
                value="{{ $jadwal->jam_mulai }}"
                class="w-full border rounded-lg p-3">

        </div>

        <div>

            <label class="block font-semibold mb-2">
                Jam Selesai
            </label>

            <input
                type="time"
                id="jam_selesai"
                name="jam_selesai"
                value="{{ $jadwal->jam_selesai }}"
                class="w-full border rounded-lg p-3">

        </div>

        <div>

            <label class="block font-semibold mb-2">
                Jumlah JP
            </label>

            <input
                type="number"
                id="jumlah_jp"
                name="jumlah_jp"
                value="{{ $jadwal->jumlah_jp }}"
                readonly
                class="w-full border rounded-lg p-3 bg-gray-100">

        </div>

    </div>

    <div class="flex flex-wrap gap-3 mt-8 pt-5 border-t border-gray-200">

        <button type="submit"
    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-semibold transition duration-200 flex items-center gap-2">

    ✓ Simpan Perubahan

</button>

       <a href="{{ route('jadwal-mengajar.index') }}"
   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-xl font-semibold transition duration-200 flex items-center gap-2">

    ✕ Batal

</a>

    </div>

</div>

</form>

<script>

const mulai = document.getElementById('jam_mulai');
const selesai = document.getElementById('jam_selesai');
const jp = document.getElementById('jumlah_jp');

function hitungJP(){

    if(mulai.value && selesai.value){

        let m1 = mulai.value.split(':');
        let m2 = selesai.value.split(':');

        let awal = new Date(0,0,0,m1[0],m1[1]);
        let akhir = new Date(0,0,0,m2[0],m2[1]);

        let selisih = (akhir-awal)/60000;

        jp.value = Math.round(selisih/45);

    }

}

mulai.addEventListener('change', hitungJP);
selesai.addEventListener('change', hitungJP);

</script>

@endsection