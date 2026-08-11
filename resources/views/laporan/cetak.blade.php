<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<title>Laporan Penggajian</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:40px;
}

h2,h3{
    text-align:center;
    margin:0;
}

p{
    text-align:center;
    margin:5px 0 20px;
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

.text-right{
    text-align:right;
}

.text-center{
    text-align:center;
}

.total{
    margin-top:20px;
    font-size:16px;
    font-weight:bold;
}

.ttd{
    margin-top:80px;
    width:250px;
    float:right;
    text-align:center;
}

</style>

</head>

<body>

<h2>SMP ROUDHOTUL MARDHIYYAH</h2>

<h3>LAPORAN PENGGAJIAN</h3>

<p>
Periode :
{{ request('periode')
? \Carbon\Carbon::parse(request('periode'))->translatedFormat('F Y')
: 'Semua Periode' }}
</p>

<table>

<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>Jabatan</th>

<th>Jenis</th>

<th>JP</th>

<th>Gaji Mengajar</th>

<th>Gaji Jabatan</th>

<th>Gaji Pokok</th>

<th>Transport</th>

<th>Total Gaji</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($penggajian as $item)

<tr>

<td class="text-center">
{{ $loop->iteration }}
</td>

<td>
{{ $item->pegawai->nama }}
</td>

<td>
{{ $item->pegawai->jabatan->nama_jabatan ?? '-' }}
</td>

<td class="text-center">
{{ ucfirst($item->pegawai->jenis_pegawai) }}
</td>

<td class="text-center">
{{ $item->pegawai->jenis_pegawai=='guru' ? $item->total_jam : '-' }}
</td>

<td class="text-right">
Rp {{ number_format($item->gaji_mengajar,0,',','.') }}
</td>

<td class="text-right">
Rp {{ number_format($item->gaji_jabatan,0,',','.') }}
</td>

<td class="text-right">
Rp {{ number_format($item->gaji_pokok,0,',','.') }}
</td>

<td class="text-right">
Rp {{ number_format($item->transport,0,',','.') }}
</td>

<td class="text-right">
Rp {{ number_format($item->gaji_total,0,',','.') }}
</td>

<td class="text-center">
{{ $item->status }}
</td>

</tr>

@endforeach

</tbody>

</table>

<div class="total">

Total Penggajian :
Rp {{ number_format($totalPenggajian,0,',','.') }}

</div>

<div class="ttd">

Bekasi,
{{ now()->translatedFormat('d F Y') }}

<br><br><br><br>

<b>Bendahara</b>

</div>

<script>

window.print();

</script>

</body>

</html>