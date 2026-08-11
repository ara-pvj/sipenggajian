@extends('layouts.app')

@section('title','Slip Gaji')

@section('content')

<div class="bg-white rounded-xl shadow p-8">

    <div class="text-center mb-8">

        <h2 class="text-3xl font-bold">
            SLIP GAJI
        </h2>

        <p class="text-gray-600">
            SMP Roudhotul Mardhiyyah
        </p>

        <hr class="mt-4">

    </div>

    <div class="grid grid-cols-2 gap-4 mb-8">

        <div>
            <p><b>Nama</b></p>
            <p>{{ $penggajian->pegawai->nama }}</p>
        </div>

        <div>
            <p><b>Periode</b></p>
            <p>{{ \Carbon\Carbon::parse($penggajian->periode)->translatedFormat('F Y') }}</p>
        </div>

        <div>
            <p><b>Jenis Pegawai</b></p>
            <p>{{ ucfirst($penggajian->pegawai->jenis_pegawai) }}</p>
        </div>

        <div>
    <p><b>Jabatan</b></p>

    <p>

        {{ $penggajian->pegawai->jabatan->nama_jabatan ?? '-' }}

    </p>
</div>

        <div>
            <p><b>Status</b></p>
            <p>{{ $penggajian->status }}</p>
        </div>

    </div>

    <table class="w-full border">

        <thead class="bg-blue-600 text-white">

            <tr>
                <th class="p-3 text-left">Keterangan</th>
                <th class="p-3 text-right">Nominal</th>
            </tr>


        </thead>

        <tbody>

            @if($penggajian->pegawai->jenis_pegawai=='guru')

            <tr>

                <td class="border p-3">
                    Gaji Mengajar
                </td>

                <td class="border p-3 text-right">
                    Rp {{ number_format($penggajian->gaji_mengajar,0,',','.') }}
                </td>

            </tr>

            <tr>

                <td class="border p-3">
                    Gaji Jabatan
                </td>

                <td class="border p-3 text-right">
                    Rp {{ number_format($penggajian->gaji_jabatan,0,',','.') }}
                </td>

            </tr>

            @else

            <tr>

                <td class="border p-3">
                    Gaji Pokok
                </td>

                <td class="border p-3 text-right">
                    Rp {{ number_format($penggajian->gaji_pokok,0,',','.') }}
                </td>

            </tr>

            @endif

            <tr>

                <td class="border p-3">
                    Transport
                </td>

                <td class="border p-3 text-right">
                    Rp {{ number_format($penggajian->transport,0,',','.') }}
                </td>

            </tr>

            <tr class="font-bold bg-gray-100">

                <td class="border p-3">
                    TOTAL GAJI
                </td>

                <td class="border p-3 text-right text-green-600">
                    Rp {{ number_format($penggajian->gaji_total,0,',','.') }}
                </td>

            </tr>

        </tbody>

    </table>

    <div class="mt-12 text-right">

        <p>Bekasi, {{ now()->translatedFormat('d F Y') }}</p>

        <br><br><br>

        <b>Bendahara</b>

    </div>

</div>

<div class="mt-8 flex justify-between">

    <a href="{{ route('slip.index') }}"
   class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
    Kembali
</a>

    <button
        onclick="window.print()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        Cetak Slip

    </button>

</div>

<style>

@media print{

    button,
    a{
        display:none;
    }

    body{
        background:white;
    }

    .shadow{
        box-shadow:none !important;
    }

}

</style>

@endsection