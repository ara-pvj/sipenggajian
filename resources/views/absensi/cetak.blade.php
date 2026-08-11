<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 8mm 10mm;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            font-size: 13px;
            background: #fff;
        }

        .report {
            width: 100%;
        }

        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .logo {
            width: 78px;
            height: 78px;
            object-fit: contain;
            margin-right: 18px;
        }

        .kop {
            flex: 1;
            text-align: center;
            padding-right: 90px;
        }

        .kop h2 {
            margin: 0;
            font-size: 21px;
            font-weight: 700;
            line-height: 1.2;
        }

        .kop h3 {
            margin: 2px 0 5px;
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .kop p {
            margin: 2px 0;
            font-size: 13px;
            line-height: 1.3;
        }

        .period {
            margin: 10px 0 12px;
            font-size: 11px;
            font-weight: 600;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 0;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 8px 10px;
            font-size: 13px;
            vertical-align: middle;
        }

        table.data th {
            background: #f2f2f2;
            text-align: center;
            font-weight: 700;
        }

        table.data td.center {
            text-align: center;
        }

        table.data tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }

        .ttd {
            width: 100%;
            margin-top: 28px;
            border-collapse: collapse;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .ttd td {
            border: none;
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 11px;
        }

        .ttd-space {
            height: 55px;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
<div class="report">

    <div class="header">
        <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo">

        <div class="kop">
            <h2>YAYASAN ISTANA AL-QUR'AN DELAPAN</h2>
            <h3>SMP ROUDHOTUL MARDHIYYAH</h3>
            <p>Rekap Absensi Guru dan Staff</p>
            <p>Tahun Pelajaran : {{ $tahunAktif->tahun }}</p>
        </div>
    </div>

    @if(request('bulan'))
        <div class="period">
            Periode :
            {{ \Carbon\Carbon::createFromDate(null, (int) request('bulan'), 1)->translatedFormat('F') }}
            {{ date('Y') }}
        </div>
    @else
        <div class="period">Periode : Semua Bulan</div>
    @endif

    <table class="data">
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 38%;">Nama Pegawai</th>
                <th style="width: 20%;">Jenis Pegawai</th>
                <th style="width: 20%;">Jumlah Hadir</th>
                <th style="width: 16%;">Total JP</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $item)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $item->pegawai->nama }}</td>
                    <td class="center">{{ ucfirst($item->jenis) }}</td>
                    <td class="center">{{ $item->jumlah_hadir }} Hari</td>
                    <td class="center">{{ $item->total_jp }} JP</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="ttd">
        <tr>
            <td>
                Mengetahui,
                <div class="ttd-space"></div>
                <b>Kepala Sekolah</b>
            </td>

            <td>
                Bekasi, {{ now()->translatedFormat('d F Y') }}
                <div class="ttd-space"></div>
                <b>Tata Usaha</b>
            </td>
        </tr>
    </table>

</div>

<script>
    window.print();
</script>
</body>
</html>