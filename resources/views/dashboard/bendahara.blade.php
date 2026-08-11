@extends('layouts.app')

@section('title', 'Dashboard Bendahara')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, Bendahara!')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

<!-- Header -->
<div class="bg-blue-700 rounded-lg p-5 text-white mb-5">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr(auth()->user()->name ?? 'B', 0, 2)) }}
        </div>
        <div>
            <h2 class="text-xl font-semibold">Halo, {{ auth()->user()->name }}</h2>
            <p class="text-blue-200 text-sm">Sistem Informasi Penggajian Guru dan Staff</p>
            <p class="text-blue-200 text-xs mt-1">{{ date('l, d F Y') }} | {{ date('H:i') }}</p>
        </div>
    </div>
</div>

<!-- Statistik Utama -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-600">Total Penggajian</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-blue-700">{{ $sudahDibayar ?? 0 }}</p>
        <p class="text-sm text-gray-600">Sudah Dibayar</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-red-600">{{ $belumDibayar ?? 0 }}</p>
        <p class="text-sm text-gray-600">Belum Dibayar</p>
    </div>
</div>

<!-- Absensi -->
@php
    $pegawai = auth()->user()->pegawai;

    $sudahAbsen = $pegawai
        ? \App\Models\Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', today())
            ->exists()
        : false;
@endphp

@if($sudahAbsen)

<div class="block bg-green-50 rounded-lg border border-green-200 p-4 mb-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Absensi Hari Ini</p>
            <p class="font-semibold text-green-700">Sudah Absen</p>
            <p class="text-sm text-gray-500">
                Absensi hari ini sudah berhasil dilakukan.
            </p>
        </div>
        <div class="text-green-600 text-xl font-bold">✓</div>
    </div>
</div>

@else

<a href="{{ route('absensi.kamera') }}"
   class="block bg-white rounded-lg border border-gray-200 p-4 mb-5 hover:bg-gray-50 transition">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Absensi Hari Ini</p>
            <p class="font-semibold text-blue-700">Scan Wajah</p>
            <p class="text-sm text-gray-500">Klik untuk melakukan absensi hari ini.</p>
        </div>
        <div class="text-gray-400">→</div>
    </div>
</a>

@endif

<!-- Informasi -->
<div class="bg-blue-50 rounded-lg border border-blue-200 p-4 mb-5">
    <div class="flex justify-between items-center mb-2">
        <h4 class="font-semibold text-gray-800">Informasi Penggajian</h4>
        @auth
            <button onclick="toggleEdit()" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                Edit
            </button>
        @endauth
    </div>
    <div id="infoDisplay" class="text-sm text-gray-700 leading-relaxed">
        @if($informasi)
            {!! nl2br(e($informasi->isi)) !!}
        @else
            <p class="text-gray-400">Belum ada informasi.</p>
        @endif
    </div>
    @auth
    <div id="infoForm" style="display:none; margin-top:12px;">
        <form action="{{ route('informasi.update') }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="isi" rows="4" class="w-full p-2 border border-gray-300 rounded text-sm" required>{{ $informasi ? $informasi->isi : '' }}</textarea>
            <div class="flex gap-2 mt-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-1.5 rounded text-sm">Simpan</button>
                <button type="button" onclick="toggleEdit()" class="bg-gray-300 text-gray-700 px-4 py-1.5 rounded text-sm">Batal</button>
            </div>
        </form>
    </div>
    @endauth
</div>

<!-- Penggajian Terbaru -->
@if(isset($penggajianTerbaru) && $penggajianTerbaru->count() > 0)
<div class="bg-white rounded-lg border border-gray-200 p-4">
    <h4 class="font-semibold text-gray-800 mb-3">Penggajian Terbaru</h4>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-2 text-gray-600 font-medium">Nama</th>
                    <th class="text-left py-2 text-gray-600 font-medium">Jumlah</th>
                    <th class="text-left py-2 text-gray-600 font-medium">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penggajianTerbaru as $gaji)
                <tr class="border-b border-gray-100">
                    <td class="py-2">{{ $gaji->pegawai->nama ?? '-' }}</td>
                    <td class="py-2">Rp {{ number_format($gaji->gaji_total, 0, ',', '.') }}</td>
                    <td class="py-2">
                        <span class="px-3 py-0.5 rounded-full text-xs font-medium 
                            {{ $gaji->status == 'Sudah Dibayar' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $gaji->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="bg-white rounded-lg border border-gray-200 p-4 text-center text-gray-500 text-sm">
    Belum ada data penggajian.
</div>
@endif

<script>
function toggleEdit() {
    var display = document.getElementById('infoDisplay');
    var form = document.getElementById('infoForm');
    if (display.style.display === 'none') {
        display.style.display = 'block';
        form.style.display = 'none';
    } else {
        display.style.display = 'none';
        form.style.display = 'block';
    }
}
</script>

@endsection