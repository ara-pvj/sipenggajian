@extends('layouts.app')

@section('title','Scan Wajah')

@section('content')

<div class="max-w-3xl mx-auto">

    <h1 class="text-4xl font-bold mb-2">
        📷 Scan Wajah
    </h1>

    <p class="text-gray-500 mb-6">
        Pastikan wajah terlihat jelas sebelum melakukan absensi.
    </p>

    <div id="notif" class="hidden mb-5 px-5 py-4 rounded-xl bg-red-100 text-red-700 font-medium">
</div>

    <div class="bg-white rounded-2xl shadow p-6">

        <video
            id="camera"
            autoplay
            playsinline
            class="w-full rounded-xl border">
        </video>

        <canvas
            id="canvas"
            class="hidden">
        </canvas>

        <button
            id="capture"
            class="mt-5 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">

            📸 Ambil Foto

        </button>

    </div>

</div>

<script>

const video = document.getElementById('camera');

navigator.mediaDevices.getUserMedia({
    video:true
})

.then(function(stream){

    video.srcObject = stream;

})

.catch(function(){

    alert('Kamera tidak dapat diakses.');

});

const canvas = document.getElementById('canvas');
const capture = document.getElementById('capture');

capture.addEventListener('click', function () {

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    const ctx = canvas.getContext('2d');

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    const foto = canvas.toDataURL('image/png');

    fetch("/absensi", {
    method: "POST",
    credentials: "same-origin",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json"
    },
    body: JSON.stringify({
        tanggal: new Date().toISOString().slice(0,10),
        foto_masuk: foto
    })
})
.then(async response => {

    const text = await response.text();

    console.log(text);

    if(response.ok){
    window.location.href = "{{ route('absensi.berhasil') }}";
}else{
    let message = text;

    try {
        const data = JSON.parse(text);
        message = data.message ?? text;
    } catch (e) {
        // Jika response bukan JSON, gunakan text biasa
    }

    const notif = document.getElementById('notif');

    notif.textContent = '❌ ' + message;
    notif.classList.remove('hidden');
}

})
.catch((error) => {
    console.error(error);

    const notif = document.getElementById('notif');

    notif.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
    notif.classList.remove('hidden');
});

});
</script>

@endsection