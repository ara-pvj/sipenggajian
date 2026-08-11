@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, Tata Usaha!')

@section('content')

<!-- Header -->
<div class="bg-blue-700 rounded-lg p-5 text-white mb-5">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr(auth()->user()->name ?? 'TU', 0, 2)) }}
        </div>
        <div>
            <h2 class="text-xl font-semibold">Halo, {{ auth()->user()->name }}</h2>
            <p class="text-blue-200 text-sm">Sistem Informasi Penggajian Guru dan Staff</p>
            <p class="text-blue-200 text-xs mt-1">{{ date('l, d F Y') }} | {{ date('H:i') }}</p>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-blue-700">{{ $totalGuru ?? 0 }}</p>
        <p class="text-sm text-gray-600">Total Guru</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-green-700">{{ $totalStaff ?? 0 }}</p>
        <p class="text-sm text-gray-600">Total Staff</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-blue-700">{{ $persentase ?? 0 }}%</p>
        <p class="text-sm text-gray-600">Progress Kehadiran</p>
    </div>
</div>

<!-- Absensi -->
@php
    $punyaJadwal = \App\Models\JadwalMengajar::where('pegawai_id', auth()->user()->pegawai_id)->exists();
@endphp

<a href="{{ $punyaJadwal ? route('absensi.pilihSesi') : route('absensi.kamera') }}"
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

<!-- Informasi -->
<div class="bg-blue-50 rounded-lg border border-blue-200 p-4 mb-5">
    <div class="flex justify-between items-center mb-2">
        <h4 class="font-semibold text-gray-800">Informasi</h4>
        @if(in_array(auth()->user()->role, ['tata_usaha', 'bendahara']))
            <button onclick="toggleEdit()" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                Edit
            </button>
        @endif
    </div>
    <div id="infoDisplay" class="text-sm text-gray-700 leading-relaxed">
        @if($informasi)
            {!! nl2br(e($informasi->isi)) !!}
        @else
            <p class="text-gray-400">Belum ada informasi.</p>
        @endif
    </div>
    @if(in_array(auth()->user()->role, ['tata_usaha', 'bendahara']))
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
    @endif
</div>

<!-- Progress & Slip Gaji -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <!-- Progress -->
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <h4 class="font-semibold text-gray-800 mb-3">Progress Kehadiran</h4>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-gray-600">Hadir</span>
            <span class="font-semibold">{{ $persentase ?? 0 }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-700 h-2.5 rounded-full" style="width: {{ $persentase ?? 0 }}%"></div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div class="bg-green-50 rounded-lg p-3 text-center border border-green-200">
                <p class="text-xl font-bold text-green-700">{{ $hadir ?? 0 }}</p>
                <p class="text-xs text-gray-600">Hadir</p>
            </div>
            <div class="bg-red-50 rounded-lg p-3 text-center border border-red-200">
                <p class="text-xl font-bold text-red-600">{{ $tidakHadir ?? 0 }}</p>
                <p class="text-xs text-gray-600">Tidak Hadir</p>
            </div>
        </div>
    </div>

    <!-- Slip Gaji -->
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <h4 class="font-semibold text-gray-800 mb-3">Slip Gaji Terbaru</h4>
        @if($slip)
            <div class="space-y-2 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Periode</span>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($slip->periode)->translatedFormat('F Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Total Gaji</span>
                    <span class="font-bold text-green-700">Rp {{ number_format($slip->gaji_total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="px-3 py-0.5 rounded-full text-xs font-medium 
                        {{ $slip->status == 'Sudah Dibayar' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $slip->status ?? 'Belum Dibayar' }}
                    </span>
                </div>
            </div>
            <a href="{{ route('slip.saya') }}" class="block text-center mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-sm transition">
                Lihat Detail Slip
            </a>
        @else
            <p class="text-center text-gray-500 py-6 text-sm">Belum ada slip gaji.</p>
        @endif
    </div>
</div>

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