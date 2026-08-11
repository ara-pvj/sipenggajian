@extends('layouts.app')

@section('content')

<div class="container">

<div class="mb-6">

    <h2 class="text-3xl font-bold text-gray-800">
        Sesi Mengajar
    </h2>

    <p class="text-gray-500 mt-2">
        Pilih sesi mengajar yang akan dilakukan absensi.
    </p>

</div>

<form action="{{ route('absensi.prosesSesi') }}" method="POST">
    @csrf

    <div class="grid gap-4">

        @foreach($jadwalHariIni as $item)

        <label class="{{ $item->status_sesi == 'selesai' ? 'cursor-not-allowed' : 'cursor-pointer' }}">

            <input
    type="radio"
    name="jadwal_id"
    value="{{ $item->id }}"
    class="peer hidden"
    required
    {{ $item->status_sesi == 'selesai' ? 'disabled' : '' }}>

            <div class="border rounded-2xl p-5 shadow-sm transition-all
    peer-checked:border-blue-600
    peer-checked:bg-blue-50
    {{ $item->status_sesi != 'selesai' ? 'hover:shadow-md' : '' }}
    {{ $item->status_sesi == 'selesai' ? 'opacity-60 bg-gray-100' : '' }}">

                <div class="flex justify-between items-start">

                    <div>

                        <h3 class="text-xl font-bold text-gray-800">
                            {{ $item->mata_pelajaran }}
                        </h3>

                        <p class="text-gray-600 mt-1">
                            Kelas {{ $item->kelas }}
                        </p>

                        <p class="text-gray-500 mt-2">
                            {{ substr($item->jam_mulai,0,5) }}
                            -
                            {{ substr($item->jam_selesai,0,5) }}
                        </p>

                    </div>

                    <div>

                        @if($item->status_sesi == 'belum')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
    Belum Absen
</span>

@elseif($item->status_sesi == 'proses')

<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
    Sedang Mengajar
</span>

@else

<span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm">
    Selesai
</span>

@endif

                    </div>

                </div>

            </div>

        </label>

        @endforeach

    </div>

    <button
    id="btnScan"
        class="mt-6 w-full bg-blue-600 hover:bg-blue-700
               text-white py-3 rounded-xl font-semibold">

        Lanjut Scan Wajah

    </button>

</form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const radios = document.querySelectorAll('input[name="jadwal_id"]');
    const btn = document.getElementById('btnScan');

    btn.disabled = true;
    btn.classList.add('opacity-50','cursor-not-allowed');

    radios.forEach(radio => {

        radio.addEventListener('change', function(){

            btn.disabled = false;
            btn.classList.remove('opacity-50','cursor-not-allowed');

        });

    });

});
</script>

@endsection