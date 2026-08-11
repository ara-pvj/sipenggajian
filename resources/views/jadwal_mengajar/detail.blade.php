@extends('layouts.app')

@section('title','Detail Jadwal Mengajar')
@section('page-title','Detail Jadwal Mengajar')
@section('page-subtitle','Informasi jadwal mengajar guru')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Detail Jadwal Mengajar
</h2>

<div class="grid grid-cols-2 gap-y-8 gap-x-16">

    <div>
        <strong>Guru</strong><br>
        {{ $jadwal->first()->pegawai->nama }}
    </div>

    <div>
    <strong>Mata Pelajaran</strong><br>

    {{ $jadwal->pluck('mata_pelajaran')->unique()->implode(', ') }}

    </div>

    <div>
        <strong>Tahun Pelajaran</strong><br>
        {{ $jadwal->first()->tahunPelajaran->tahun_ajaran }}
    </div>

    <div>
    <strong>Kelas Diampu</strong><br>

    {{ $jadwal->pluck('kelas')->unique()->implode(', ') }}

    </div>

    <div>
        <strong>Total Jadwal</strong><br>
        {{ $jadwal->count() }} Jadwal
    </div>

    <div>
        <strong>Total JP / Minggu</strong><br>
        {{ $jadwal->sum('jumlah_jp') }} JP
    </div>

</div>
<div class="mb-8"></div>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full table-auto">

    <thead class="bg-blue-600 text-white">

        <tr>

            <th class="w-16 px-4 py-3 text-center">No</th>

<th class="w-40 px-4 py-3">Hari</th>

<th class="w-32 px-4 py-3 text-center">Kelas</th>

<th class="px-4 py-3">Mata Pelajaran</th>

<th class="w-52 px-4 py-3 text-center">Jam</th>

<th class="w-24 px-4 py-3 text-center">JP</th>

<th class="px-4 py-3 text-center">Aksi</th>

        </tr>

    </thead>

    <tbody>

    @foreach($jadwal as $item)

    <tr class="border-b">

        <td class="text-center">
            {{ $loop->iteration }}
        </td>

        <td class="text-center">
            {{ $item->hari }}
        </td>

        <td class="text-center">
            {{ $item->kelas }}
        </td>

        <td>
            {{ $item->mata_pelajaran }}
        </td>

        <td class="text-center">
            {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
        </td>

        <td class="text-center">
            {{ $item->jumlah_jp }}
        </td>

        <td class="px-4 py-3 text-center">

    <a href="{{ route('jadwal-mengajar.edit',$item->id) }}"
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">

        Edit

    </a>

    <form
        action="{{ route('jadwal-mengajar.destroy',$item->id) }}"
        method="POST"
        class="inline">

        @csrf
        @method('DELETE')

        <button
            onclick="return confirm('Hapus jadwal ini?')"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">

            Hapus

        </button>

    </form>

</td>

    </tr>

    @endforeach

    </tbody>

</table>

</div>

<div class="mt-6">

    <a href="{{ route('jadwal-mengajar.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg">

        Kembali

    </a>

</div>

@endsection