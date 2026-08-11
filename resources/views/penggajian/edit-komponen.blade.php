@extends('layouts.app')

@section('title', 'Edit Data Pegawai')
@section('page-title', 'Edit Data Pegawai')
@section('page-subtitle', 'Ubah data guru dan staff')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
    
    <form action="{{ route('komponen.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nama <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama', $pegawai->nama) }}" 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                       required>
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Jenis Pegawai -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Jenis Pegawai <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-4 items-center h-11">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" 
                               name="jenis_pegawai" 
                               value="guru" 
                               {{ old('jenis_pegawai', $pegawai->jenis_pegawai) == 'guru' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Guru</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" 
                               name="jenis_pegawai" 
                               value="staff" 
                               {{ old('jenis_pegawai', $pegawai->jenis_pegawai) == 'staff' ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Staff</span>
                    </label>
                </div>
                @error('jenis_pegawai')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Jabatan -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Jabatan <span class="text-red-500">*</span>
                </label>
                <select name="jabatan_id" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">-- Pilih Jabatan --</option>
                    @foreach($jabatan as $j)
                        <option value="{{ $j->id }}" 
                            {{ old('jabatan_id', $pegawai->jabatan_id) == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jabatan }}
                        </option>
                    @endforeach
                </select>
                @error('jabatan_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Tempat Lahir -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Tempat Lahir
                </label>
                <input type="text" 
                       name="tempat_lahir" 
                       value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('tempat_lahir')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Tanggal Lahir -->
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
        Tanggal Lahir
    </label>
    <input type="date" 
           name="tanggal_lahir" 
           value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ? date('Y-m-d', strtotime($pegawai->tanggal_lahir)) : '') }}" 
           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
    @error('tanggal_lahir')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
            
            <!-- Alamat -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Alamat
                </label>
                <textarea name="alamat" 
                          rows="2" 
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">{{ old('alamat', $pegawai->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Tarif per JP (khusus Guru) -->
            <div id="tarifGuru">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Tarif per JP (Guru)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                    <input type="number" 
                           name="tarif_per_jam" 
                           value="{{ old('tarif_per_jam', $pegawai->tarif_per_jam) }}" 
                           step="1000"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                @error('tarif_per_jam')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Gaji Pokok (khusus Staff) -->
            <div id="gajiPokok" style="display: none;">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Gaji Pokok (Staff)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                    <input type="number" 
                           name="gaji_pokok" 
                           value="{{ old('gaji_pokok', $pegawai->gaji_pokok) }}" 
                           step="1000"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                @error('gaji_pokok')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Transport -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Transport
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                    <input type="number" 
                           name="transport" 
                           value="{{ old('transport', $pegawai->transport) }}" 
                           step="1000"
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                @error('transport')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
                <!-- Tombol Aksi -->
        <div class="flex flex-wrap gap-3 mt-8 pt-2">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-semibold transition duration-200 flex items-center gap-2 shadow-sm hover:shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('komponen.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl font-semibold transition duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batal
            </a>
        </div>  <!-- <-- HANYA SATU DIV PENUTUP -->
    </form>
</div>

<div class="h-4"></div> <!-- Spacer kecil biar gak mepet -->

<script>
    // Toggle tampilan Tarif/Jam dan Gaji Pokok berdasarkan jenis pegawai
    document.addEventListener('DOMContentLoaded', function() {
        const radioGuru = document.querySelector('input[name="jenis_pegawai"][value="guru"]');
        const radioStaff = document.querySelector('input[name="jenis_pegawai"][value="staff"]');
        const tarifGuru = document.getElementById('tarifGuru');
        const gajiPokok = document.getElementById('gajiPokok');

        function toggleFields() {
            if (radioGuru && radioGuru.checked) {
                tarifGuru.style.display = 'block';
                gajiPokok.style.display = 'none';
            } else if (radioStaff && radioStaff.checked) {
                tarifGuru.style.display = 'none';
                gajiPokok.style.display = 'block';
            }
        }

        if (radioGuru) radioGuru.addEventListener('change', toggleFields);
        if (radioStaff) radioStaff.addEventListener('change', toggleFields);

        toggleFields(); // Jalankan saat pertama load
    });
</script>

@endsection