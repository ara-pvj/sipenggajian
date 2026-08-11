@extends('layouts.app')

@section('title', 'Rekap Absensi')
@section('page-title', 'Rekap Absensi')
@section('page-subtitle', 'Rekap absensi guru dan staff SMP Roudhotul Mardhiyyah')

@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-5xl font-extrabold tracking-widest text-blue-600">
            REKAP ABSENSI
        </h1>
        <p class="text-gray-500 mt-2">
            Rekap absensi guru dan staff SMP Roudhotul Mardhiyyah.
        </p>
    </div>
</div>

@if(request('bulan'))

<p class="text-gray-500">
    Periode :
    <b>
        {{ \Carbon\Carbon::createFromDate(null, (int) request('bulan'), 1)->translatedFormat('F') }}
        {{ date('Y') }}
    </b>
</p>

@endif

<form method="GET" action="{{ route('absensi.rekap') }}" class="bg-white rounded-3xl shadow-lg border border-blue-100 p-4 mb-6">
    <div class="flex items-center gap-4">

        <label class="font-semibold">
            Bulan :
        </label>

        <select name="bulan"
            class="px-4 py-2 border rounded-xl">

            <option value="">Semua Bulan</option>

            @foreach(range(1,12) as $bulan)
                <option value="{{ $bulan }}"
                    {{ request('bulan') == $bulan ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                </option>
            @endforeach

        </select>

        <button
            class="bg-blue-600 text-white px-5 py-2 rounded-xl">

            Filter

        </button>

    </div>
</form>

<div class="flex justify-between items-center mb-6">

    @if(auth()->user()->role === 'tata_usaha')
    <a href="{{ route('absensi.cetak', request('bulan') ? ['bulan' => request('bulan')] : []) }}"
       target="_blank"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold transition">
        🖨️ Cetak Rekap
    </a>
@endif

</div>

<!-- Tabel -->
<div class="bg-white rounded-3xl shadow-xl border border-blue-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-white uppercase tracking-wide">
    <tr>
        <th class="px-6 py-4 text-center">No</th>
        <th class="px-6 py-4">Nama Pegawai</th>
        <th class="px-6 py-4 text-center">Jenis Pegawai</th>
        <th class="px-6 py-4 text-center">Jumlah Hadir</th>
        <th class="px-6 py-4 text-center">Total JP</th>
    </tr>
</thead>
            <tbody>
    @forelse($data as $item)
    <tr class="border-b hover:bg-blue-50 duration-300">
        <td class="text-center py-4">
            {{ $loop->iteration }}
        </td>

        <td class="font-semibold text-gray-800">
            {{ $item->pegawai->nama }}
        </td>

        <td class="text-center">
            {{ ucfirst($item->jenis) }}
        </td>

        <td class="text-center">
    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
        {{ $item->jumlah_hadir }}
    </span>
</td>

        <td class="text-center">
            @if($item->jenis == 'guru')
                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">
                    {{ $item->total_jp }} JP
                </span>
            @else
                -
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="text-center py-10 text-gray-500">
            Belum ada data rekap absensi.
        </td>
    </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>

<script>
    function filterAbsensi() {
        const tanggal = document.getElementById('filterTanggal').value;
        const status = document.getElementById('filterStatus').value;
        
        let url = '{{ route("absensi.index") }}?';
        if (tanggal) url += 'tanggal=' + tanggal + '&';
        if (status) url += 'status=' + status;
        
        window.location.href = url;
    }
    
    function resetFilter() {
        window.location.href = '{{ route("absensi.index") }}';
    }
</script>

@endsection