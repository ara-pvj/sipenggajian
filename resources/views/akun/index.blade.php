@extends('layouts.app')

@section('title', 'Pengelolaan Akun')

@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-5xl font-extrabold tracking-widest text-blue-600">
            PENGELOLAAN AKUN
        </h1>
        <p class="text-gray-500 mt-2">
            Kelola akun login guru dan staff SMP Roudhotul Mardhiyyah.
        </p>
    </div>

    <a href="{{ route('akun.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl shadow">
        + Tambah Akun
    </a>
</div>

<div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-blue-100">

    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-6 py-4">
        <h2 class="text-2xl font-bold">
            Daftar Akun Guru & Staff
        </h2>
    </div>

    <table class="min-w-full">
        <thead class="bg-blue-50">
            <tr>
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">Jenis Pegawai</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Role</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($akun as $data)
                <tr class="border-b hover:bg-blue-50">

                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $data->name }}
                    </td>

                    <td class="px-6 py-4">
                        {{ ucfirst($data->pegawai->jenis_pegawai ?? '-') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $data->email }}
                    </td>

                    <td class="px-6 py-4">
                        {{ ucfirst(str_replace('_', ' ', $data->role)) }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex gap-2 justify-center">

                            <a href="{{ route('akun.edit', $data->id) }}"
                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-xl">
                                Edit
                            </a>

                            <form action="{{ route('akun.destroy', $data->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus akun ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl">
                                    Hapus
                                </button>

                            </form>

                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        Belum ada akun guru atau staff.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection