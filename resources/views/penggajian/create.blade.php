@extends('layouts.app')

@section('title','Proses Penggajian')

@section('content')

@php
    use Carbon\Carbon;

    $today = Carbon::today();
    $lastDay = Carbon::today()->endOfMonth();

    $allowProcess = $today->greaterThanOrEqualTo($lastDay->copy()->subDay());
@endphp

<h2 class="text-3xl font-bold mb-6">
    Proses Penggajian
</h2>

<div class="bg-white rounded-xl shadow p-6">

    <form action="{{ route('penggajian.store') }}" method="POST">

    @csrf

    <div class="mb-6">

        <label class="block mb-2 font-semibold">
            Periode Penggajian
        </label>

        <input
            type="month"
            name="periode"
            class="border rounded-lg w-full p-3"
            required>

    </div>

    </div>

    <div class="bg-blue-50 rounded-xl p-4 mb-6">

        <h3 class="font-bold text-blue-700 mb-2">
            Informasi
        </h3>

        <ul class="list-disc ml-5 text-gray-700 space-y-1">

            <li>Guru dihitung berdasarkan total JP hadir.</li>

            <li>Staff dihitung berdasarkan gaji pokok.</li>

            <li>Transport akan ditambahkan otomatis.</li>

        </ul>

    </div>

   @if($allowProcess)

<button
    type="submit"
    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

    💰 Proses Penggajian

</button>

@else

<div class="bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-lg p-4">
    <strong>Informasi</strong><br>
    Proses penggajian hanya dapat dilakukan mulai H-1 hingga hari terakhir setiap bulan.
</div>

@endif

</form>

</div>

@endsection