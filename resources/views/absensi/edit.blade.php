@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Data Absensi</h1>
        <p class="text-gray-500">Koreksi data absensi pegawai</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Nama Pegawai
                    </label>

                    <input type="text"
                           value="{{ $absensi->pegawai->nama }}"
                           class="w-full border rounded-lg px-4 py-3 bg-gray-100"
                           disabled>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ $absensi->tanggal }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Jam Masuk
                    </label>

                    <input type="time"
                           name="jam_masuk"
                           value="{{ $absensi->jam_masuk }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Jam Selesai
                    </label>

                    <input type="time"
                           name="jam_pulang"
                           value="{{ $absensi->jam_pulang }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Jumlah JP
                    </label>

                    <input type="number"
                           name="jam_mengajar"
                           value="{{ $absensi->jam_mengajar }}"
                           min="0"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-2">
                        Status
                    </label>

                    <select name="status"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="Hadir"
                            {{ $absensi->status == 'Hadir' ? 'selected' : '' }}>
                            Hadir
                        </option>
                        <option value="Izin"
                            {{ $absensi->status == 'Izin' ? 'selected' : '' }}>
                            Izin
                        </option>
                        <option value="Sakit"
                            {{ $absensi->status == 'Sakit' ? 'selected' : '' }}>
                            Sakit
                        </option>
                        <option value="Alpa"
                            {{ $absensi->status == 'Alpa' ? 'selected' : '' }}>
                            Alpa
                        </option>
                    </select>
                </div>

            </div>

            <div class="flex gap-3 mt-8">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Simpan Perubahan
                </button>

                <a href="{{ route('absensi.show', $absensi->id) }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                    Batal
                </a>

            </div>

        </form>

    </div>
</div>
@endsection