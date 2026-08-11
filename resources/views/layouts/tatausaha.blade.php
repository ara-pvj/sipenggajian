@extends('layouts.app')

@section('title', 'Dashboard Tata Usaha')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, tata usaha!')

@section('content')

<!-- Statistik -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Pegawai</p>
        <p class="text-2xl font-bold text-blue-600">{{ $totalPegawai ?? 0 }}</p>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Guru</p>
        <p class="text-2xl font-bold text-green-600">{{ $totalGuru ?? 0 }}</p>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Staff</p>
        <p class="text-2xl font-bold text-purple-600">{{ $totalStaff ?? 0 }}</p>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Absensi Hari Ini</p>
        <p class="text-2xl font-bold text-orange-600">{{ $absensiHariIni ?? 0 }}</p>
    </div>
</div>

<!-- Informasi Cepat -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h4 class="font-bold text-gray-800 mb-3">📊 Status Absensi Hari Ini</h4>
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">✅ Hadir</span>
                <span class="text-sm font-bold text-green-600">{{ $hadir ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">⏳ Belum Absen</span>
                <span class="text-sm font-bold text-yellow-600">{{ $belumAbsen ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">❌ Alpha</span>
                <span class="text-sm font-bold text-red-600">{{ $alpha ?? 0 }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">📝 Izin</span>
                <span class="text-sm font-bold text-blue-600">{{ $izin ?? 0 }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <h4 class="font-bold text-gray-800 mb-3">⚡ Tugas Hari Ini</h4>
        <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-center gap-2">
                <span class="text-blue-500">📋</span> Proses penggajian bulan ini
            </li>
            <li class="flex items-center gap-2">
                <span class="text-green-500">📄</span> Cetak slip gaji karyawan
            </li>
            <li class="flex items-center gap-2">
                <span class="text-yellow-500">📊</span> Rekap absensi bulanan
            </li>
            <li class="flex items-center gap-2">
                <span class="text-purple-500">👨‍🏫</span> Update data pegawai baru
            </li>
        </ul>
    </div>
</div>

<!-- Penggajian Terbaru -->
@if(isset($penggajianTerbaru) && $penggajianTerbaru->count() > 0)
<div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 mt-6">
    <h4 class="font-bold text-gray-800 mb-3">💰 Penggajian Terbaru</h4>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-2 text-gray-500 font-semibold">Nama</th>
                    <th class="text-left py-2 text-gray-500 font-semibold">Periode</th>
                    <th class="text-left py-2 text-gray-500 font-semibold">Jumlah</th>
                    <th class="text-left py-2 text-gray-500 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penggajianTerbaru as $gaji)
                <tr class="border-b border-gray-100">
                    <td class="py-2">{{ $gaji->pegawai->nama ?? '-' }}</td>
                    <td class="py-2">{{ $gaji->periode ? date('F Y', strtotime($gaji->periode)) : '-' }}</td>
                    <td class="py-2">Rp {{ number_format($gaji->gaji_total, 0, ',', '.') }}</td>
                    <td class="py-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            {{ $gaji->status == 'Sudah Dibayar' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $gaji->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Informasi Tambahan -->
<div class="bg-blue-50 p-5 rounded-2xl border border-blue-200 mt-6">
    <h4 class="font-bold text-gray-800 mb-2">ℹ️ Informasi Tata Usaha</h4>
    <p class="text-sm text-gray-600">
        Silakan kelola data pegawai dan jadwal mengajar melalui menu di samping. 
        Pastikan data guru, staff, jabatan, dan jadwal mengajar selalu diperbarui 
        agar proses penggajian berjalan dengan baik.
    </p>
</div>

@endsection