@extends('layouts.admin')

@section('title', 'Absensi Masuk')

@section('content')

<div class="max-w-3xl mx-auto">

    <h2 class="text-3xl font-bold text-gray-800">
        📸 Absensi Masuk
    </h2>

    <p class="text-gray-500 mt-2 mb-8">
        Silakan lakukan absensi sebelum mulai mengajar.
    </p>

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            {{-- Pegawai --}}
            <div class="mb-5">
                <label class="block font-semibold mb-2">
                    Pegawai
                </label>

                <select
                    id="pegawaiSelect"
                    name="pegawai_id"
                    class="w-full rounded-lg border-gray-300">

                    <option value="">-- Pilih Pegawai --</option>

                    @foreach($pegawai as $p)
                        
                        <option value="{{ $p->id }}">
                        {{ $p->nama }}
                        </option>
                    
                    @endforeach

                </select>
            </div>

            <div class="mb-5" id="jadwalInfo" style="display:none;">

    <label class="block font-semibold mb-2">
        Jadwal Hari Ini
    </label>

    <div class="bg-blue-50 rounded-lg p-4">

        <p id="infoMapel"></p>

        <p id="infoKelas"></p>

        <p id="infoJP"></p>

    </div>

</div>

            {{-- Tanggal --}}
            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ date('Y-m-d') }}"
                    class="w-full rounded-lg border-gray-300">

            </div>

            <div class="mb-6">

    <label class="block font-semibold mb-2">

        Foto Masuk

    </label>

    <video
        id="camera"
        autoplay
        playsinline
        class="w-full max-w-md rounded-xl border shadow">
    </video>

    <canvas
        id="canvas"
        class="hidden">
    </canvas>

    <input
        type="hidden"
        name="foto_masuk"
        id="foto_masuk">

    <button
        type="button"
        id="capture"
        class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

        📸 Ambil Foto

    </button>

</div>

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                📸 Simpan Absensi

            </button>

        </form>

    </div>

</div>

<script>

const jadwal = @json($jadwal);

const pegawai = document.getElementById('pegawaiSelect');

const jadwalInfo = document.getElementById('jadwalInfo');

const infoMapel = document.getElementById('infoMapel');
const infoKelas = document.getElementById('infoKelas');
const infoJP = document.getElementById('infoJP');

const hariIndonesia = [
    "Minggu",
    "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jumat",
    "Sabtu"
];

pegawai.addEventListener("change", function(){

    let id = parseInt(this.value);

    let hari = hariIndonesia[new Date().getDay()];

    let data = jadwal.find(function(item){

        return parseInt(item.pegawai_id) === id &&
               item.hari === hari;

    });

    if(data){

        jadwalInfo.style.display = "block";

        infoMapel.innerHTML = "<strong>Mata Pelajaran :</strong> " + data.mata_pelajaran;

        infoKelas.innerHTML = "<strong>Kelas :</strong> " + data.kelas;

        infoJP.innerHTML = "<strong>Jumlah JP :</strong> " + data.jumlah_jp;

    }else{

        jadwalInfo.style.display = "block";

        infoMapel.innerHTML = "Tidak ada jadwal hari ini";

        infoKelas.innerHTML = "-";

        infoJP.innerHTML = "-";

    }

});

</script>

<script>

const video = document.getElementById('camera');
const canvas = document.getElementById('canvas');
const capture = document.getElementById('capture');
const input = document.getElementById('foto_masuk');

navigator.mediaDevices.getUserMedia({
    video:true
})
.then(stream=>{

    video.srcObject=stream;

});

capture.onclick=function(){

    canvas.width=video.videoWidth;
    canvas.height=video.videoHeight;

    const ctx=canvas.getContext('2d');

    ctx.drawImage(video,0,0);

    input.value=canvas.toDataURL('image/png');

    alert('Foto berhasil diambil ✅');

}

</script>

@endsection