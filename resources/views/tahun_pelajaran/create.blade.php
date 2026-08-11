@extends('layouts.app')

@section('title','Tambah Tahun Pelajaran')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Tambah Tahun Pelajaran
</h2>

<div class="bg-white rounded-xl shadow p-8">

<form action="{{ route('tahun-pelajaran.store') }}" method="POST">

    @csrf

    <div class="mb-5">

        <label class="block mb-2 font-semibold">
            Tahun Pelajaran
        </label>

        <input
            type="text"
            name="tahun_ajaran"
            placeholder="Contoh : 2025/2026"
            class="w-full rounded-lg border-gray-300">

    </div>

    <div class="mb-5">

    <label class="block mb-2 font-semibold">
        Semester
    </label>

    <select
        name="semester"
        class="w-full rounded-lg border-gray-300">

        <option value="">-- Pilih Semester --</option>
        <option value="ganjil">Ganjil</option>
        <option value="genap">Genap</option>

    </select>

</div>

    <div class="mb-6">

        <label class="block mb-2 font-semibold">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border-gray-300">

            <option value="Aktif">Aktif</option>
            <option value="Nonaktif">Nonaktif</option>

        </select>

    </div>

    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        💾 Simpan

    </button>

</form>

</div>

@endsection