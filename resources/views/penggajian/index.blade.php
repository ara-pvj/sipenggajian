@extends('layouts.app')

@section('title','Data Penggajian')

@section('content')

@if($monitoring)
    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded mb-4">
        <strong>Mode Monitoring:</strong> Data ini adalah estimasi real-time berdasarkan absensi yang sudah tercatat.
        Penggajian resmi akan diproses pada akhir bulan.
    </div>
@endif

@php
    $today = \Carbon\Carbon::today();
    $lastDay = \Carbon\Carbon::today()->endOfMonth();

    $allowProcess = $today->greaterThanOrEqualTo(
        $lastDay->copy()->subDay()
    );
@endphp

<div class="flex items-start justify-between mb-6">

    <div>
        <h1 class="text-4xl font-bold text-gray-800">
            Pengelolaan Penggajian
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola proses penggajian guru dan staff berdasarkan data absensi.
        </p>
    </div>

<div class="flex gap-3 mb-6">

    @if($allowProcess)

    <a href="{{ route('penggajian.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold">
        Proses Penggajian
    </a>

    @endif

</div>

</div>

<div class="grid grid-cols-3 gap-4 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500 text-sm">Guru</p>
        <p class="text-3xl font-bold">
            {{ $penggajianGuru->count() }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500 text-sm">Staff</p>
        <p class="text-3xl font-bold">
            {{ $penggajianStaff->count() }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-gray-500 text-sm">Total Penggajian</p>
        <p class="text-2xl font-bold text-green-600">

            Rp {{ number_format(
                $penggajianGuru->sum('gaji_total')
                +
                $penggajianStaff->sum('gaji_total'),
            0,',','.') }}

        </p>
    </div>

</div>

<form method="GET" action="{{ route('penggajian.index') }}" class="mb-6">

    <div class="flex items-center gap-3">

        <label class="font-semibold text-blue-700">
            Periode
        </label>

        <input
            type="month"
            name="periode"
            value="{{ $periode }}"
            class="border rounded-lg px-3 py-2"
        >

        <input
            type="hidden"
            name="filter"
            value="{{ $filter }}"
        >

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
        >
            Tampilkan
        </button>

    </div>

</form>

<div class="flex gap-3 mb-8">

    <a href="{{ route('penggajian.index',[
    'filter' => 'semua',
    'periode' => $periode
]) }}"
       class="px-5 py-2 rounded-xl {{ request('filter','semua')=='semua' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Semua
    </a>

    <a href="{{ route('penggajian.index',[
    'filter' => 'guru',
    'periode' => $periode
]) }}"
       class="px-5 py-2 rounded-xl {{ request('filter')=='guru' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Guru
    </a>

    <a href="{{ route('penggajian.index',[
    'filter' => 'staff',
    'periode' => $periode
]) }}"
       class="px-5 py-2 rounded-xl {{ request('filter')=='staff' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Staff
    </a>

</div>

@if($filter == 'semua' || $filter == 'guru')

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-2xl font-bold text-blue-600 mb-4">
    Penggajian Guru
</h3>

<div class="overflow-x-auto mb-10">

    <table class="min-w-full">

        <thead class="bg-blue-600 text-white">

            <tr>
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3 text-center">Periode</th>
                <th class="px-4 py-3 text-center">Total JP</th>
                <th class="px-4 py-3 text-center">Hari Hadir</th>
                <th class="px-4 py-3 text-center">Gaji Mengajar</th>
                <th class="px-4 py-3 text-center">Gaji Jabatan</th>
                <th class="px-4 py-3 text-center">Transport</th>
                <th class="px-4 py-3 text-center">Total</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>

        </thead>

        <tbody>

        @forelse($penggajianGuru as $item)

<tr class="border-b">

    <td class="text-center py-3">
        {{ $loop->iteration }}
    </td>

    <td>{{ $item->pegawai->nama }}</td>

    <td class="text-center">
        {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}
    </td>

    <td class="text-center">
        {{ $item->total_jam }}
    </td>

    <td class="text-center">
    {{ $item->jumlah_hadir }} Hari
</td>


    <td class="text-center">
        Rp {{ number_format($item->gaji_mengajar,0,',','.') }}
    </td>


    <td class="text-center">
        Rp {{ number_format($item->gaji_jabatan,0,',','.') }}
    </td>

    <td class="text-center">
        Rp {{ number_format($item->transport,0,',','.') }}
    </td>

    <td class="text-center font-bold text-green-600">
        Rp {{ number_format($item->gaji_total,0,',','.') }}
    </td>

    <td class="text-center">

    @if($monitoring)

    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
        Monitoring
    </span>

@elseif($item->status == 'Belum Dibayar')

    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
        Belum Dibayar
    </span>

@else

    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
        Sudah Dibayar
    </span>

@endif

</td>

<td class="text-center">

    @if($monitoring)

    -

@elseif($item->status == 'Belum Dibayar')

    <button type="button"
    onclick="openBayarModal({{ $item->id }}, '{{ $item->pegawai->nama }}')"
    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
    Bayar
</button>

@else

    <span class="text-green-600">
        ✔
    </span>

@endif

</td>

</tr>

@empty

<tr>
    <td colspan="10" class="text-center py-5">
        Belum ada data guru.
    </td>
</tr>

@endforelse

        </tbody>

    </table>

</div>

@endif

@if($filter == 'semua' || $filter == 'staff')

<h3 class="text-2xl font-bold text-blue-600 mb-4">
    Penggajian Staff
</h3>

<div class="overflow-x-auto">

    <table class="min-w-full">

        <thead class="bg-blue-600 text-white">

            <tr>
                <th class="px-4 py-3 text-center">No</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3 text-center">Periode</th>
                <th class="px-4 py-3 text-center">Gaji Pokok</th>
                <th class="px-4 py-3 text-center">Hari Hadir</th>
                <th class="px-4 py-3 text-center">Transport</th>
                <th class="px-4 py-3 text-center">Total</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>

        </thead>

        <tbody>

        @forelse($penggajianStaff as $item)

<tr class="border-b">

    <td class="text-center py-3">
        {{ $loop->iteration }}
    </td>

    <td>{{ $item->pegawai->nama }}</td>

    <td class="text-center">
        {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}
    </td>

    <td class="text-center">
        Rp {{ number_format($item->gaji_pokok,0,',','.') }}
    </td>

    <td class="text-center">
    {{ $item->hari_hadir }} Hari
</td>

    <td class="text-center">
        Rp {{ number_format($item->transport,0,',','.') }}
    </td>

    <td class="text-center font-bold text-green-600"style="white-space: nowrap;">
        Rp {{ number_format($item->gaji_total,0,',','.') }}
    </td>

    <td class="text-center">

   @if($monitoring)

    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
        Monitoring
    </span>

@elseif($item->status == 'Belum Dibayar')

    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
        Belum Dibayar
    </span>

@else

    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
        Sudah Dibayar
    </span>

@endif

</td>

<td class="text-center">

    @if($monitoring)

    -

@elseif($item->status == 'Belum Dibayar')

<button type="button"
    onclick="openBayarModal({{ $item->id }}, '{{ $item->pegawai->nama }}')"
    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
    Bayar
</button>

@else

<span class="text-green-600 text-lg">
    ✔
</span>

@endif

</td>

</tr>

@empty

<tr>

    <td colspan="8" class="text-center py-5">
        Belum ada data staff.
    </td>

</tr>

@endforelse

        </tbody>

    </table>

</div>
@endif

@endsection

@endif


<!-- Modal Konfirmasi Pembayaran -->
<div id="bayarModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">

        <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-5 text-white">
            <h3 class="text-xl font-bold">
                Konfirmasi Pembayaran
            </h3>

            <p class="text-blue-100 text-sm mt-1">
                Pastikan pembayaran gaji sudah dilakukan.
            </p>
        </div>

        <div class="p-6">

            <div class="bg-blue-50 rounded-xl p-4 mb-5">
                <p class="text-sm text-gray-500">
                    Pegawai
                </p>

                <p id="namaPegawaiBayar"
                    class="font-bold text-gray-800 text-lg">
                </p>
            </div>

            <p class="text-gray-600 text-sm leading-relaxed">
                Apakah gaji pegawai ini sudah benar-benar dibayarkan?
                Setelah dikonfirmasi, status akan berubah menjadi
                <span class="font-semibold text-green-600">
                    Sudah Dibayar
                </span>.
            </p>

        </div>

        <div class="px-6 pb-6 flex justify-end gap-3">

            <button type="button"
                onclick="closeBayarModal()"
                class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold">
                Batal
            </button>

            <form id="formBayar" method="POST">
                @csrf
                @method('PUT')

                <button type="submit"
                    class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold">
                    Bayar Sekarang
                </button>

            </form>

        </div>

    </div>

</div>


<script>

function openBayarModal(id, nama)
{
    document.getElementById('namaPegawaiBayar').textContent = nama;

    document.getElementById('formBayar').action =
        '/penggajian/' + id + '/bayar';

    const modal = document.getElementById('bayarModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}


function closeBayarModal()
{
    const modal = document.getElementById('bayarModal');

    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

</script>

@endsection