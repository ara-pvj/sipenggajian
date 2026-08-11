@extends('layouts.app')

@section('title','Tahun Pelajaran')

@section('content')

<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        Tahun Pelajaran
    </h1>

    <p class="text-gray-500 mt-1">
        Kelola periode tahun ajaran yang digunakan dalam sistem.
    </p>
</div>

<div class="mb-6">
    <a href="{{ route('tahun-pelajaran.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow inline-block">
        + Tambah Periode
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="min-w-full">

<thead class="bg-blue-600 text-white">
<tr>
    <th class="px-4 py-3">No</th>
    <th class="px-4 py-3">Tahun Pelajaran</th>
    <th class="px-4 py-3">Semester</th>
    <th class="px-4 py-3">Status</th>
    <th class="px-4 py-3">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($tahun as $item)

<tr class="border-b">

    <td class="text-center py-3">{{ $loop->iteration }}</td>

    <td class="text-center">
        {{ $item->tahun_ajaran }}
    </td>

    <td class="text-center">
        {{ ucfirst($item->semester) }}
    </td>

    <td class="text-center">
        @if($item->status=='Aktif')
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                Aktif
            </span>
        @else
            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">
                Nonaktif
            </span>
        @endif
    </td>

    <td class="text-center">

        <a href="{{ route('tahun-pelajaran.edit',$item->id) }}"
           class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded">
            Edit
        </a>

        <form action="{{ route('tahun-pelajaran.destroy',$item->id) }}"
              method="POST"
              class="inline">

            @csrf
            @method('DELETE')

            <button
                onclick="return confirm('Hapus data?')"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Hapus
            </button>

        </form>

    </td>

</tr>

@empty

<tr>
    <td colspan="5" class="text-center py-5">
        Belum ada data.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection