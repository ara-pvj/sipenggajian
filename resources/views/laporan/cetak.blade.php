<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penggajian</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            color: #000;
            font-size: 11px;
            background: #fff;
        }

        .report {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .header h3 {
            margin: 3px 0 5px;
            font-size: 15px;
            font-weight: 700;
        }

        .header p {
            margin: 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 10px;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 5px;
            font-size: 10px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background: #f3f3f3;
            text-align: center;
            font-weight: 700;
        }

        .text-right {
            text-align: right;
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }

        .total {
            margin-top: 12px;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
        }

        .ttd-wrapper {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .ttd {
            width: 190px;
            text-align: center;
            line-height: 1.4;
        }

        .ttd-space {
            height: 55px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .report {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="report">

        <div class="header">
            <h2>SMP ROUDHOTUL MARDHIYYAH</h2>
            <h3>LAPORAN PENGGAJIAN</h3>
            <p>
                Periode :
                {{ request('periode')
                    ? \Carbon\Carbon::parse(request('periode'))->translatedFormat('F Y')
                    : 'Semua Periode' }}
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 4%;">No</th>
                    <th style="width: 13%;">Nama</th>
                    <th style="width: 10%;">Jabatan</th>
                    <th style="width: 7%;">Jenis</th>
                    <th style="width: 5%;">JP</th>
                    <th style="width: 12%;">Gaji Mengajar</th>
                    <th style="width: 12%;">Gaji Jabatan</th>
                    <th style="width: 11%;">Gaji Pokok</th>
                    <th style="width: 10%;">Transport</th>
                    <th style="width: 11%;">Total Gaji</th>
                    <th style="width: 5%;">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($penggajian as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>

                        <td>{{ $item->pegawai->nama }}</td>

                        <td>{{ $item->pegawai->jabatan->nama_jabatan ?? '-' }}</td>

                        <td class="text-center">
                            {{ ucfirst($item->pegawai->jenis_pegawai) }}
                        </td>

                        <td class="text-center">
                            {{ $item->pegawai->jenis_pegawai == 'guru' ? $item->total_jam : '-' }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->gaji_mengajar, 0, ',', '.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->gaji_jabatan, 0, ',', '.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->transport, 0, ',', '.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->gaji_total, 0, ',', '.') }}
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
            Rp {{ number_format($totalPenggajian, 0, ',', '.') }}
        </div>

        <div class="ttd-wrapper">
            <div class="ttd">
                <div>
                    Bekasi, {{ now()->translatedFormat('d F Y') }}
                </div>

                <div class="ttd-space"></div>

                <b>Bendahara</b>
            </div>
        </div>

    </div>

    <script>
        window.print();
    </script>
</body>
</html>
