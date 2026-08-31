@extends('layouts.app')

@section('title', 'Edit Akun')

@section('content')

<div class="max-w-2xl mx-auto">

    <h2 class="text-3xl font-bold text-gray-800 mb-8">
        Edit Akun
    </h2>

    <div class="bg-white rounded-xl shadow p-8">

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700">
                Nama Pegawai
            </label>

            <input
                type="text"
                value="{{ $akun->pegawai->nama ?? $akun->name }}"
                class="border rounded-lg w-full p-3 bg-gray-100"
                readonly
            >
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold text-gray-700">
                Jenis Pegawai
            </label>

            <input
                type="text"
                value="{{ ucfirst($akun->role) }}"
                class="border rounded-lg w-full p-3 bg-gray-100"
                readonly
            >
        </div>

        <form action="{{ route('akun.update', $akun->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $akun->email) }}"
                    class="border rounded-lg w-full p-3"
                    required
                >

                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="border rounded-lg w-full p-3"
                    placeholder="Kosongkan jika tidak ingin mengganti password"
                >

                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="border rounded-lg w-full p-3"
                    placeholder="Masukkan kembali password baru"
                >
            </div>

            <div class="flex gap-3">

                <a
                    href="{{ route('akun.index') }}"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-lg"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection