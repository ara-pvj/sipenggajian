@extends('layouts.app')

@section('title', 'Tambah Akun')

@section('content')

<div class="mb-8">
    <h1 class="text-4xl font-extrabold text-blue-600">
        TAMBAH AKUN
    </h1>

    <p class="text-gray-500 mt-2">
        Buat akun login untuk guru atau staff.
    </p>
</div>

<div class="bg-white rounded-3xl shadow-xl p-8 border border-blue-100">

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf

        {{-- Pegawai --}}
        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Pegawai
            </label>

            @if(request('pegawai_id') && isset($pegawaiDipilih))

                {{-- Jika klik "Buat Akun" dari data pegawai --}}
                <input
                    type="text"
                    value="{{ $pegawaiDipilih->nama }} - {{ ucfirst($pegawaiDipilih->jenis_pegawai) }}"
                    class="w-full border-gray-300 rounded-xl p-3 bg-gray-100"
                    readonly
                >

                <input
                    type="hidden"
                    name="pegawai_id"
                    value="{{ $pegawaiDipilih->id }}"
                >

            @else

                {{-- Jika membuka Tambah Akun secara umum --}}
                <select
                    name="pegawai_id"
                    class="w-full border-gray-300 rounded-xl p-3"
                    required
                >
                    <option value="">-- Pilih Guru / Staff --</option>

                    @foreach($pegawai as $data)
                        <option value="{{ $data->id }}"
                            {{ old('pegawai_id') == $data->id ? 'selected' : '' }}>
                            {{ $data->nama }} -
                            {{ ucfirst($data->jenis_pegawai) }}
                        </option>
                    @endforeach
                </select>

                <p class="text-sm text-gray-500 mt-2">
                    Hanya pegawai yang belum memiliki akun yang ditampilkan.
                </p>

            @endif
        </div>

        {{-- Email --}}
        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border-gray-300 rounded-xl p-3"
                placeholder="Masukkan email untuk login"
                required
            >
        </div>

        {{-- Password --}}
        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="w-full border-gray-300 rounded-xl p-3"
                placeholder="Minimal 8 karakter"
                required
            >
        </div>

        {{-- Konfirmasi Password --}}
        <div class="mb-8">
            <label class="block mb-2 font-semibold">
                Konfirmasi Password
            </label>

            <input
                type="password"
                name="password_confirmation"
                class="w-full border-gray-300 rounded-xl p-3"
                placeholder="Masukkan kembali password"
                required
            >
        </div>

        <div class="flex gap-3">

            <a
                href="{{ route('akun.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl"
            >
                Batal
            </a>

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl"
            >
                Simpan Akun
            </button>

        </div>

    </form>

</div>

@endsection