@extends('layouts.app')

@section('title', 'Dashboard Kepala Sekolah')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, Kepala Sekolah!')

@section('content')

<!-- Header -->
<div class="bg-gradient-to-r from-blue-700 to-blue-600 rounded-2xl p-6 text-white mb-6 shadow-lg">
    <div class="flex items-center gap-5">
        <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold border-2 border-white/30">
            {{ strtoupper(substr($pegawai->nama ?? 'KS', 0, 2)) }}
        </div>
        <div>
            <h2 class="text-2xl font-bold">Selamat Datang, {{ $pegawai->nama ?? 'Kepala Sekolah' }}</h2>
            <p class="text-blue-100 text-sm">Kepala Sekolah</p>
            <p class="text-blue-200 text-xs mt-1">{{ date('l, d F Y') }} | {{ date('H:i') }}</p>
        </div>
    </div>
</div>

<!-- Statistik Utama -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition">
        <p class="text-2xl font-bold text-blue-700">{{ $tahunAktif->tahun_ajaran ?? '-' }}</p>
        <p class="text-sm text-gray-500 mt-1">Tahun Pelajaran</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition">
        <p class="text-2xl font-bold text-green-600">{{ $totalGuru ?? 0 }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Guru</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition">
        <p class="text-2xl font-bold text-yellow-600">{{ $totalStaff ?? 0 }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Staff</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-md transition">
        <p class="text-2xl font-bold text-purple-600">{{ $totalPegawai ?? 0 }}</p>
        <p class="text-sm text-gray-500 mt-1">Total Pegawai</p>
    </div>
</div>

<!-- Absensi & Kehadiran -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Scan Wajah -->
<a href="{{ route('absensi.kamera') }}" 
   class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white hover:shadow-lg transition shadow-md flex items-center justify-between">
    <div>
        <p class="text-blue-100 text-sm">Absensi Hari Ini</p>
        <p class="text-xl font-bold mt-1">Scan Wajah</p>
        <p class="text-blue-100 text-sm mt-1">Klik untuk melakukan absensi.</p>
    </div>
    <div class="text-4xl font-light">
        →
    </div>
</a>

    <!-- Rekap Kehadiran -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-semibold text-gray-800 mb-4">Rekap Kehadiran Hari Ini</h4>

        @php
            $persentase = ($totalGuru ?? 0) > 0 ? round((($hadir ?? 0) / ($totalGuru ?? 0)) * 100) : 0;
        @endphp

        <div class="text-center mb-4">
            <p class="text-4xl font-bold text-blue-600">{{ $persentase }}%</p>
            <p class="text-sm text-gray-500 mt-1">Progress Kehadiran</p>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-3 mb-5">
            <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $persentase }}%;"></div>
        </div>

        <div class="grid grid-cols-2 gap-3 text-center">
    <div class="bg-green-50 rounded-xl p-3 border border-green-100">
        <p class="text-2xl font-bold text-green-600">{{ $hadir ?? 0 }}</p>
        <p class="text-xs text-gray-500">Hadir</p>
    </div>

    <div class="bg-yellow-50 rounded-xl p-3 border border-yellow-100">
        <p class="text-2xl font-bold text-yellow-600">{{ $belumHadir ?? 0 }}</p>
        <p class="text-xs text-gray-500">Belum</p>
    </div>
</div>
    </div>
</div>

<!-- Penggajian & Informasi -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Penggajian -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center">
                <span class="text-blue-600 font-bold text-lg">Rp</span>
            </div>
            <h4 class="text-lg font-semibold text-gray-800">Penggajian Bulan Ini</h4>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-600">Total Penggajian</span>
                <span class="font-bold text-blue-600 text-lg">Rp {{ number_format($totalPenggajian ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                <span class="text-gray-600 text-sm">Sudah Dibayar</span>
                <span class="font-semibold text-green-600">Rp {{ number_format($sudahDibayar ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600 text-sm">Belum Dibayar</span>
                <span class="font-semibold text-red-600">Rp {{ number_format($belumDibayar ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-5 pt-4 border-t border-gray-200">
            <a href="{{ route('laporan.index') }}" 
               class="block text-center bg-blue-50 hover:bg-blue-100 text-blue-600 py-2.5 rounded-xl text-sm font-semibold transition">
                Lihat Laporan Lengkap
            </a>
        </div>
    </div>

    <!-- Informasi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center">
                    <span class="text-blue-600 text-xl font-bold">i</span>
                </div>
                <h4 class="text-lg font-semibold text-gray-800">Informasi</h4>
            </div>
            @if(in_array(auth()->user()->role, ['tata_usaha', 'bendahara']))
                <button onclick="toggleEdit()" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    Edit
                </button>
            @endif
        </div>

        <div id="infoDisplay" class="text-gray-700 text-sm leading-relaxed">
            @if($informasi)
                {!! nl2br(e($informasi->isi)) !!}
            @else
                <p class="text-gray-400 italic">Belum ada informasi.</p>
            @endif
        </div>

        @if(in_array(auth()->user()->role, ['tata_usaha', 'bendahara']))
        <div id="infoForm" style="display: none;" class="mt-4">
            <form action="{{ route('informasi.update') }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="isi" rows="5" 
                          class="w-full p-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                          required>{{ $informasi ? $informasi->isi : '' }}</textarea>
                <div class="flex gap-2 mt-3">
                    <button type="submit" 
                            class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                        Simpan
                    </button>
                    <button type="button" onclick="toggleEdit()" 
                            class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

<script>
function toggleEdit() {
    const display = document.getElementById('infoDisplay');
    const form = document.getElementById('infoForm');
    
    if (form.style.display === 'none') {
        display.style.display = 'none';
        form.style.display = 'block';
    } else {
        display.style.display = 'block';
        form.style.display = 'none';
    }
}
</script>

@endsection