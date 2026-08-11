<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Rekap Absensi</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:40px;
}

.header{
    display:flex;
    align-items:center;
    border-bottom:3px solid black;
    padding-bottom:15px;
    margin-bottom:20px;
}

.logo{
    width:80px;
    margin-right:20px;
}

.kop{
    flex:1;
    text-align:center;
}

.kop h2,
.kop h3{
    margin:0;
}

.kop p{
    margin:4px 0;
    font-size:13px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

table th,
table td{
    border:1px solid #000;
    padding:8px;
    font-size:12px;
}

table th{
    background:#f3f3f3;
}

.text-center{
    text-align:center;
}

.ttd{
    width:100%;
    margin-top:60px;
}

.ttd td{
    border:none;
    text-align:center;
    width:50%;
}

</style>

</head>

<body>

<div class="header">

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <div class="kop">

        <h2>YAYASAN ISTANA AL-QUR'AN DELAPAN</h2>

        <h3>SMP ROUDHOTUL MARDHIYYAH</h3>

        <p>
            Rekap Absensi Guru dan Staff
        </p>

        <p>
            Tahun Pelajaran :
            {{ $tahunAktif->tahun_ajaran }}
        </p>

    </div>

</div>

@if($namaBulan)

<p>
Periode :
{{ $namaBulan }} {{ date('Y') }}
</p>

@endif

<table>

<thead>
<tr>
    <th>No</th>
    <th>Nama Pegawai</th>
    <th>Jenis Pegawai</th>
    <th>Jumlah Hadir</th>
    <th>Total JP</th>
</tr>
</thead>

<tbody>

@forelse($data as $item)

<tr>

    <td class="text-center">
        {{ $loop->iteration }}
    </td>

    <td>
        {{ $item->pegawai->nama }}
    </td>

    <td class="text-center">
        {{ ucfirst($item->jenis) }}
    </td>

    <td class="text-center">
        {{ $item->jumlah_hadir }} Hari
    </td>

    <td class="text-center">
        @if($item->jenis == 'guru')
            {{ $item->total_jp }} JP
        @else
            -
        @endif
    </td>

</tr>

@empty

<tr>
    <td colspan="5" class="text-center">
        Tidak ada data.
    </td>
</tr>

@endforelse

</tbody>

</table>

<table class="ttd">

<tr>

<td>

Mengetahui,

<br><br>

<b>Kepala Sekolah</b>

<br><br><br><br>

(...........................)

</td>

<td>

Bekasi,
{{ now()->translatedFormat('d F Y') }}

<br><br>

<b>Tata Usaha</b>

<br><br><br><br>

(...........................)

</td>

</tr>

</table>

<script>

window.print();

</script>

</body>

</html>