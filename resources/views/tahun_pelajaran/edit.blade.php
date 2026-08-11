@extends('layouts.app')

@section('title','Edit Tahun Pelajaran')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Edit Tahun Pelajaran
</h2>

<div class="bg-white rounded-xl shadow p-8">

<form action="{{ route('tahun-pelajaran.update',$tahun->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-5">

        <label class="block mb-2 font-semibold">
            Tahun Pelajaran
        </label>

        <input
            type="text"
            name="tahun_ajaran"
            value="{{ $tahun->tahun_ajaran }}"
            class="w-full rounded-lg border-gray-300">

    </div>

    <div class="mb-5">

    <label class="block mb-2 font-semibold">
        Semester
    </label>

    <select
        name="semester"
        class="w-full rounded-lg border-gray-300">

        <option value="ganjil"
            {{ $tahun->semester == 'ganjil' ? 'selected' : '' }}>
            Ganjil
        </option>

        <option value="genap"
            {{ $tahun->semester == 'genap' ? 'selected' : '' }}>
            Genap
        </option>

    </select>

</div>

    <div class="mb-6">

        <label class="block mb-2 font-semibold">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border-gray-300">

            <option value="Aktif"
                {{ $tahun->status == 'Aktif' ? 'selected' : '' }}>
                Aktif
            </option>

            <option value="Nonaktif"
                {{ $tahun->status == 'Nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>

        </select>

    </div>

    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        💾 Update

    </button>

</form>

</div>

@endsection