@extends('layouts.app')

@section('title', 'Dashboard Kurikulum')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, Kurikulum!')

@section('content')

<!-- Header -->
<div class="bg-blue-700 rounded-lg p-5 text-white mb-5">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 2)) }}
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
        <p class="text-2xl font-bold text-blue-700">{{ $tahunAktif->tahun_ajaran ?? '-' }}</p>
        <p class="text-sm text-gray-600">Tahun Pelajaran Aktif</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-green-700">{{ $totalGuru ?? 0 }}</p>
        <p class="text-sm text-gray-600">Total Guru</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
        <p class="text-2xl font-bold text-yellow-700">{{ $totalJadwal ?? 0 }}</p>
        <p class="text-sm text-gray-600">Total Jadwal</p>
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
    <h4 class="font-semibold text-gray-800 mb-2">Informasi Kurikulum</h4>
    <p class="text-sm text-gray-700 leading-relaxed">
        Pastikan Tahun Pelajaran aktif terlebih dahulu sebelum menginput Jadwal Mengajar.
        Jadwal Mengajar yang telah diinput akan menjadi dasar proses absensi dan penggajian guru.
    </p>
</div>

<!-- Status Periode -->
<div class="bg-white rounded-lg border border-gray-200 p-4 text-center">
    <p class="text-sm text-gray-600">Status Periode</p>
    <p class="text-xl font-bold text-blue-700 mt-1">
        {{ $tahunAktif ? 'Aktif' : 'Belum Aktif' }}
    </p>
</div>

@endsection