@extends('layouts.app')

@section('title', 'Absensi Berhasil')

@section('content')

<div class="max-w-2xl mx-auto">

    <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold mb-5">
    Berhasil
</span>

@if(session('jenis_absensi') == 'masuk')

<h1 class="text-3xl font-bold text-gray-800">
    Mulai Mengajar Berhasil
</h1>

<p class="text-gray-500 mt-2">
    Selamat mengajar. Absensi masuk berhasil dicatat.
</p>

@else

<h1 class="text-3xl font-bold text-gray-800">
    Selesai Mengajar Berhasil
</h1>

<p class="text-gray-500 mt-2">
    Terima kasih. Absensi selesai mengajar berhasil dicatat.
</p>

@endif

<hr class="my-8">

        @if($absensi->foto_masuk)
            <div class="flex justify-center my-8">
                <img
                    src="{{ asset('foto_absensi/' . $absensi->foto_masuk) }}"
                    class="w-48 h-48 object-cover rounded-2xl shadow border">
            </div>
        @endif

        <div class="bg-gray-50 rounded-2xl p-6 text-left">

            <div class="grid grid-cols-2 gap-y-4">

                <div class="font-semibold">
                    Nama
                </div>

                <div>
                    {{ $pegawai->nama }}
                </div>

                <div class="font-semibold">
                    Tanggal
                </div>

                <div>
                    {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}
                </div>

                @if(session('jenis_absensi') == 'masuk')

<div class="font-semibold">
    Jam Masuk
</div>

<div>
    {{ $absensi->jam_masuk }} WIB
</div>

@else

<div class="font-semibold">
    Jam Selesai
</div>

<div>
    {{ $absensi->jam_pulang }} WIB
</div>

@endif

                <div class="font-semibold">
                    Status
                </div>

                <div>
                    @if(session('jenis_absensi') == 'masuk')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
    Mulai Mengajar
</span>

@else

<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
    Selesai Mengajar
</span>

@endif
                </div>

            </div>

        </div>

        <div class="mt-8">

            <a href="{{ 
    Auth::user()->role == 'guru' ? route('dashboard.guru') :
    (Auth::user()->role == 'tata_usaha' ? route('dashboard.tatausaha') :
    (Auth::user()->role == 'bendahara' ? route('dashboard.bendahara') :
    (Auth::user()->role == 'kurikulum' ? route('dashboard.kurikulum') :
    route('dashboard.kepala'))))
}}"
    class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold transition">
    Kembali ke Dashboard
</a>
        </div>

    </div>

</div>

@endsection