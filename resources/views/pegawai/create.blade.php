@extends('layouts.app')

@section('title','Tambah Pegawai')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Tambah Data Pegawai
</h2>

<div class="bg-white rounded-xl shadow p-8">

<form action="{{ route('pegawai.store') }}" method="POST">

    @csrf

    <div class="mb-4">
        <label class="block mb-2 font-semibold">Nama</label>
        <input type="text" name="nama" class="border rounded-lg w-full p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2 font-semibold">Jenis Pegawai</label>

        <select
            name="jenis_pegawai"
            id="jenis_pegawai"
            class="w-full border rounded-lg p-3">
            <option value="guru">Guru</option>
            <option value="staff">Staff</option>
        </select>
    </div>

    <div class="mb-4">
    <label class="block mb-2 font-semibold">Mata Pelajaran</label>

    <select
        name="mata_pelajaran[]"
        multiple
        class="w-full border rounded-lg p-3"
    >
        @foreach($mataPelajaran as $mapel)
            <option value="{{ $mapel->id }}">
                {{ $mapel->nama }}
            </option>
        @endforeach
    </select>

    <p class="text-sm text-gray-500 mt-1">
        Tekan Ctrl/Command untuk memilih lebih dari satu mata pelajaran.
    </p>
</div>

    <div class="mb-4">
        <label class="block mb-2 font-semibold">Jabatan</label>

        <select
            name="jabatan_id"
            id="jabatan_id"
            class="border rounded-lg w-full p-2">

        </select>
</div>

    <div class="mb-4">
        <label class="block mb-2 font-semibold">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="border rounded-lg w-full p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2 font-semibold">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="border rounded-lg w-full p-2">
    </div>

    <div class="mb-6">
        <label class="block mb-2 font-semibold">Alamat</label>
        <textarea name="alamat" rows="3" class="border rounded-lg w-full p-2"></textarea>
    </div>

    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        Simpan Pegawai

    </button>

</form>

</div>

<script>

const jabatan = document.getElementById('jabatan_id');

const semuaJabatan = [

@foreach($jabatan as $j)
{
    id: {{ $j->id }},
    nama: "{{ $j->nama_jabatan }}"
},
@endforeach

];

function loadJabatan(){

    jabatan.innerHTML = '<option value="">-- Pilih Jabatan --</option>';

    semuaJabatan.forEach(item => {

        jabatan.innerHTML += `
            <option value="${item.id}">
                ${item.nama}
            </option>
        `;

    });

}

loadJabatan();

</script>

@endsection