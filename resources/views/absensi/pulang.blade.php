@extends('layouts.admin')

@section('title','Absen Pulang')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-6">
    Absen Pulang
</h2>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">

    <form action="{{ route('absensi.updatePulang', $absensi->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Nama Pegawai
            </label>

            <input
                type="text"
                value="{{ $absensi->pegawai->nama }}"
                class="w-full rounded-lg border-gray-300 bg-gray-100"
                readonly>

        </div>

        <div class="mb-5">

            <label class="block mb-2 font-semibold">
                Tanggal
            </label>

            <input
                type="text"
                value="{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}"
                class="w-full rounded-lg border-gray-300 bg-gray-100"
                readonly>

        </div>

        <div class="mb-6">

            <label class="block mb-2 font-semibold">
                Upload Foto Selesai
            </label>

            <input
                type="file"
                name="foto_pulang"
                accept="image/*"
                class="w-full border rounded-lg p-2">

        </div>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

            📸 Simpan Absen Pulang

        </button>

    </form>

</div>

@endsection