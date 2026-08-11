@extends('layouts.app')

@section('title','Jadwal Mengajar')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Data Jadwal Mengajar
</h2>

<a href="{{ route('jadwal-mengajar.create') }}"
   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg inline-block mb-6">

    + Tambah Jadwal

</a>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="min-w-full">

    <thead class="bg-blue-600 text-white">

        <tr>

            <th class="px-4 py-3">No</th>
            <th class="px-4 py-3">Guru</th>
            <th class="px-4 py-3">Tahun Pelajaran</th>
            <th class="px-4 py-3">Jumlah Jadwal</th>
            <th class="px-4 py-3">Aksi</th>

        </tr>

    </thead>

    <tbody>

@forelse($jadwal as $item)

<tr class="border-b">

    <td class="text-center">
        {{ $loop->iteration }}
    </td>

    <td>
        {{ $item->pegawai->nama }}
    </td>

    <td class="text-center">
        {{ $item->tahunPelajaran->tahun_ajaran }}
    </td>

    <td class="text-center">

        {{ \App\Models\JadwalMengajar::where('pegawai_id', $item->pegawai_id)
            ->where('tahun_pelajaran_id', $item->tahun_pelajaran_id)
            ->count() }}

        Jadwal

    </td>

    <td class="text-center">

        <a href="{{ route('jadwal-mengajar.detail', [
            'pegawai' => $item->pegawai_id,
            'tahun' => $item->tahun_pelajaran_id
        ]) }}"
        class="bg-blue-600 text-white px-4 py-2 rounded">

            Detail

        </a>

    </td>

</tr>

@empty

<tr>

    <td colspan="5" class="text-center py-5">

        Belum ada jadwal mengajar.

    </td>

</tr>

@endforelse

    </tbody>

</table>

</div>

@endsection