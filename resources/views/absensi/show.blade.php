@extends('layouts.app')

@section('title','Detail Absensi')
@section('page-title','Detail Absensi')
@section('page-subtitle','Informasi lengkap absensi')

@section('content')

<div class="bg-white rounded-xl shadow p-8">

    <h2 class="text-3xl font-bold text-gray-800 mb-8">
        Detail Absensi
    </h2>

    <div class="grid grid-cols-2 gap-8">

        <div>
            <p class="font-semibold">Nama</p>
            <p>{{ $absensi->pegawai->nama }}</p>
        </div>

        <div>
            <p class="font-semibold">Tanggal</p>
            <p>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</p>
        </div>

        <div>
            <p class="font-semibold">Jam Masuk</p>
            <p>{{ $absensi->jam_masuk }}</p>
        </div>

        <div>
            <p class="font-semibold">Jam Pulang</p>
            <p>{{ $absensi->jam_pulang ?? '-' }}</p>
        </div>

        <div>
            <p class="font-semibold">Jumlah JP</p>
            <p>{{ $absensi->jam_mengajar }} JP</p>
        </div>

        <div>
            <p class="font-semibold">Status</p>
            <p>{{ $absensi->status }}</p>
        </div>

    </div>

    <div class="grid grid-cols-2 gap-8 mt-10">

        <div>

            <p class="font-semibold mb-2">Foto Masuk</p>

            <img src="{{ asset('storage/'.$absensi->foto_masuk) }}"
                 class="rounded-xl shadow w-72">

        </div>

        <div>

            <p class="font-semibold mb-2">Foto Pulang</p>

            @if($absensi->foto_pulang)

                <img src="{{ asset('storage/'.$absensi->foto_pulang) }}"
                     class="rounded-xl shadow w-72">

            @else

                <p class="text-gray-500">Belum ada foto pulang.</p>

            @endif

        </div>

    </div>

    <div class="flex gap-3 mt-10">

        @if(!$absensi->jam_pulang)

        <a href="{{ route('absensi.pulang',$absensi->id) }}"
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

            Absen Pulang

        </a>

        @endif

        <a href="{{ route('absensi.edit',$absensi->id) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg">

            Edit

        </a>

        <form action="{{ route('absensi.destroy',$absensi->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button
                onclick="return confirm('Yakin ingin menghapus data ini?')"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg">

                Hapus

            </button>

        </form>

        <a href="{{ route('absensi.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg">

            Kembali

        </a>

    </div>

</div>

@endsection