@extends('layouts.app')

@section('title','Laporan Penggajian')

@section('content')

<h2 class="text-3xl font-bold text-gray-800">
    Laporan Penggajian
</h2>

<p class="text-gray-500 mt-2">
    SMP Roudhotul Mardhiyyah
</p>

<p class="text-gray-500 mb-8">
    Rekapitulasi Penggajian Guru dan Staff
</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-green-600 text-white rounded-xl p-6 shadow">

    <p class="text-lg">
        Total Pegawai Digaji
    </p>

    <h2 class="text-3xl font-bold mt-3">

        {{ $penggajian->count() }} Orang

    </h2>

</div>

    <div class="bg-blue-600 text-white rounded-xl p-6 shadow">

        <p class="text-lg">
            Total Penggajian
        </p>

        <h2 class="text-3xl font-bold mt-3">

            Rp {{ number_format($totalPenggajian,0,',','.') }}

        </h2>

    </div>

</div>

<div class="flex justify-between items-center mb-6">

    <form method="GET" action="{{ route('laporan.index') }}" class="flex gap-3">

        <select
            name="periode"
            class="border rounded-lg px-4 py-2">

            <option value="">
                Semua Periode
            </option>

            @foreach($periode as $item)

                <option
                    value="{{ $item->periode }}"
                    {{ request('periode') == $item->periode ? 'selected' : '' }}>

                    {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}

                </option>

            @endforeach

        </select>

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 rounded-lg">

            Tampilkan

        </button>

    </form>

    @if(auth()->user()->role === 'bendahara')
    <button
        onclick="window.open('{{ route('laporan.cetak', ['periode' => request('periode')]) }}','_blank')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        Cetak Laporan

    </button>
@endif

</div>

<div class="bg-white rounded-xl shadow p-6">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-blue-600 text-white">

                <tr>

    <th class="px-4 py-3 text-center">No</th>

    <th class="px-4 py-3">Nama Pegawai</th>

    <th class="px-4 py-3">Jabatan</th>

    <th class="px-4 py-3 text-center">Jenis</th>

    <th class="px-4 py-3 text-center">Periode</th>

    <th class="px-4 py-3 text-center">JP</th>

    <th class="px-4 py-3 text-right whitespace-nowrap">
        Gaji Mengajar
    </th>

    <th class="px-4 py-3 text-right whitespace-nowrap">
        Gaji Jabatan
    </th>

    <th class="px-4 py-3 text-right whitespace-nowrap">
        Gaji Pokok
    </th>

    <th class="px-4 py-3 text-right whitespace-nowrap">
        Transport
    </th>

    <th class="px-4 py-3 text-right whitespace-nowrap">
        Total Gaji
    </th>

    <th class="px-4 py-3 text-center whitespace-nowrap">
        Status
    </th>

</tr>
            </thead>

            <tbody>

            @forelse($penggajian as $item)

                <tr class="border-b hover:bg-gray-50">

    <td class="text-center py-3">
        {{ $loop->iteration }}
    </td>

    <td class="whitespace-nowrap">
    {{ $item->pegawai->nama }}
    </td>

    <td class="whitespace-nowrap">
    {{ $item->pegawai->jabatan->nama_jabatan ?? '-' }}
    </td>

    <td class="text-center">
        {{ ucfirst($item->pegawai->jenis_pegawai) }}
    </td>

    <td class="text-center">
        {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}
    </td>

    <td class="text-center">

        @if($item->pegawai->jenis_pegawai=='guru')

            {{ $item->total_jam }}

        @else

            -

        @endif

    </td>

    <td class="text-right whitespace-nowrap">

        Rp {{ number_format($item->gaji_mengajar,0,',','.') }}

    </td>

    <td class="text-right whitespace-nowrap">

        Rp {{ number_format($item->gaji_jabatan,0,',','.') }}

    </td>

    <td class="text-right whitespace-nowrap">

        Rp {{ number_format($item->gaji_pokok,0,',','.') }}

    </td>

    <td class="text-right whitespace-nowrap">

        Rp {{ number_format($item->transport,0,',','.') }}

    </td>

    <td class="pl-6 text-right font-bold text-green-600 whitespace-nowrap">

        Rp {{ number_format($item->gaji_total,0,',','.') }}

    </td>

    <td class="text-center whitespace-nowrap">

        @if($item->status=='Belum Dibayar')

            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                {{ $item->status }}

            </span>

        @else

            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                {{ $item->status }}

            </span>

        @endif

    </td>

</tr>

            @empty

                <tr>

                    <td colspan="12" class="text-center py-5">

                        Belum ada data penggajian.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<style>

@media print{

button{
display:none;
}

body{
background:white;
}

.shadow{
box-shadow:none!important;
}

}

</style>

@endsection