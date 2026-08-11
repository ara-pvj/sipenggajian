@extends('layouts.app')

@section('title','Tambah Jadwal Mengajar')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Tambah Jadwal Mengajar
</h2>

<form action="{{ route('jadwal-mengajar.store') }}" method="POST">

@csrf

<div class="bg-white rounded-xl shadow p-6">

    <div class="mb-5">
        <label class="block font-semibold mb-2">Guru</label>

        <select name="pegawai_id" class="w-full border rounded-lg p-3" required>

            <option value="">-- Pilih Guru --</option>

            @foreach($guru as $item)
                <option value="{{ $item->id }}">
                    {{ $item->nama }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="mb-5">

    <label class="block font-semibold mb-2">
        Periode Aktif
    </label>

    <input
        type="text"
        class="w-full border rounded-lg p-3 bg-gray-100"
        value="{{ $tahunAktif->tahun_ajaran }} - {{ ucfirst($tahunAktif->semester) }}"
        readonly>

    <input
        type="hidden"
        name="tahun_pelajaran_id"
        value="{{ $tahunAktif->id }}">

</div>

    <hr class="my-8">

<h3 class="text-xl font-bold text-blue-600 mb-4">
    Jadwal Mengajar
</h3>

<table class="w-full border" id="jadwalTable">

    <thead class="bg-blue-600 text-white">

        <tr>
            <th class="p-2">Hari</th>
            <th class="p-2">Kelas</th>
            <th class="p-2">Mapel</th>
            <th class="p-2">Jam Mulai</th>
            <th class="p-2">Jam Selesai</th>
            <th class="p-2">JP</th>
            <th class="p-2">Aksi</th>
        </tr>

    </thead>

    <tbody>

<tr>

<td>

<select name="hari[]" class="w-full border rounded">

<option>Senin</option>
<option>Selasa</option>
<option>Rabu</option>
<option>Kamis</option>
<option>Jumat</option>
<option>Sabtu</option>

</select>

</td>

<td>

<select name="kelas[]" class="w-full border rounded">

<option value="">Pilih Kelas</option>
<option>VII</option>
<option>VIII</option>
<option>IX</option>

</select>

</td>

<td>

<select name="mata_pelajaran[]" class="w-full border rounded">

<option value="">Pilih Mapel</option>

<option>PAI</option>
<option>PKN</option>
<option>Bahasa Indonesia</option>
<option>Bahasa Inggris</option>
<option>Matematika</option>
<option>IPA</option>
<option>IPS</option>
<option>Informatika</option>
<option>Seni Budaya</option>
<option>PJOK</option>
<option>Bahasa Arab</option>
<option>Bahasa Sunda</option>
<option>BTQ</option>

</select>

</td>

<td>

<input
type="time"
name="jam_mulai[]"
class="w-full border rounded"
onchange="hitungJP(this)">

</td>

<td>

<input
type="time"
name="jam_selesai[]"
class="w-full border rounded"
onchange="hitungJP(this)">

</td>

<td>

<input
type="number"
name="jumlah_jp[]"
class="w-full border rounded bg-gray-100 text-center"
readonly>

</td>

<td class="text-center">

<button
type="button"
onclick="hapusBaris(this)"
class="bg-red-500 text-white px-3 py-1 rounded">

Hapus

</button>

</td>

</tr>

</tbody>

</table>

<button
type="button"
onclick="tambahBaris()"
class="mt-4 bg-green-600 text-white px-5 py-2 rounded">

+ Tambah Jadwal

</button>

    <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

        Simpan

    </button>

</div>

</form>

<script>

function tambahBaris(){

    let tbody = document.querySelector("#jadwalTable tbody");

    let row = tbody.rows[0].cloneNode(true);

    row.querySelectorAll("input").forEach(input => {
        input.value = "";
    });

    row.querySelectorAll("select").forEach(select => {
        select.selectedIndex = 0;
    });

    tbody.appendChild(row);

}

function hapusBaris(btn){

    let tbody = document.querySelector("#jadwalTable tbody");

    if(tbody.rows.length > 1){

        btn.closest("tr").remove();

    }

}

function hitungJP(input){

    let row = input.closest("tr");

    let mulai = row.querySelector('[name="jam_mulai[]"]').value;
    let selesai = row.querySelector('[name="jam_selesai[]"]').value;

    if(mulai && selesai){

        let m1 = mulai.split(":");
        let m2 = selesai.split(":");

        let awal = new Date(0,0,0,m1[0],m1[1]);
        let akhir = new Date(0,0,0,m2[0],m2[1]);

        let selisih = (akhir-awal)/60000;

        let jp = Math.round(selisih/45);

        row.querySelector('[name="jumlah_jp[]"]').value = jp;

    }

}

</script>

@endsection