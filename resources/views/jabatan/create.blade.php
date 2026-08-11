@extends('layouts.admin')

@section('title','Tambah Jabatan')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-6">
    Tambah Jabatan
</h2>

<div class="bg-white rounded-xl shadow p-8 max-w-3xl">

    <form action="{{ route('jabatan.store') }}" method="POST">

        @csrf

        <div class="mb-5">
            <label class="block font-semibold mb-2">
                Nama Jabatan
            </label>

            <input
                type="text"
                name="nama_jabatan"
                class="w-full border rounded-lg p-3">
        </div>

        <div class="mb-5">
            <label class="block font-semibold mb-2">
                Gaji Pokok
            </label>

            <input
                type="number"
                name="gaji_pokok"
                class="w-full border rounded-lg p-3">
        </div>

        
        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

            Simpan

        </button>

    </form>

</div>

@endsection