@extends('layouts.admin')

@section('title','Data Jabatan')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-6">
    Data Jabatan
</h2>

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex justify-between items-center mb-6">

        <a href="{{ route('jabatan.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
            + Tambah Jabatan
        </a>

    </div>

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-blue-600 text-white">

                <tr>
                    <th class="px-6 py-4 text-center">No</th>
                    <th class="px-6 py-4 text-left">Nama Jabatan</th>
                    <th class="px-6 py-4 text-center">Gaji Pokok</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

            @forelse($jabatan as $item)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-6 py-4 text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $item->nama_jabatan }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        Rp {{ number_format($item->gaji_pokok,0,',','.') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        Rp {{ number_format($item->tunjangan_jabatan,0,',','.') }}
                    </td>

                    <td class="px-6 py-4 text-center">

                        <a href="{{ route('jabatan.edit',$item->id) }}"
                           class="bg-yellow-400 text-white px-4 py-2 rounded-lg">

                            Edit

                        </a>

                        <form action="{{ route('jabatan.destroy',$item->id) }}"
                              method="POST"
                              class="inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Yakin?')"
                                class="bg-red-500 text-white px-4 py-2 rounded-lg">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-8">

                        Belum ada data jabatan.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection