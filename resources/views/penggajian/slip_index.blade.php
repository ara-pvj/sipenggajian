@extends('layouts.app')

@section('title','Slip Gaji')

@section('content')

<h2 class="text-3xl font-bold text-gray-800 mb-8">
    Data Slip Gaji
</h2>

<div class="bg-white rounded-xl shadow p-6">

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-blue-600 text-white">

                <tr>
                    <th class="px-4 py-3 text-center">No</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3 text-center">Periode</th>
                    <th class="px-4 py-3 text-center">Total Gaji</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

            @forelse($penggajian as $item)

                <tr class="border-b hover:bg-gray-50">

                    <td class="text-center py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->pegawai->nama }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->periode)->translatedFormat('F Y') }}
                    </td>

                    <td class="text-center font-semibold text-green-600">
                        Rp {{ number_format($item->gaji_total,0,',','.') }}
                    </td>

                    <td class="text-center">

                        @if($item->status == 'Belum Dibayar')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                                {{ $item->status }}
                            </span>

                        @else

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                {{ $item->status }}
                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <a href="{{ route('slip.show', $item->id) }}"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                            Lihat Slip

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-5">

                        Belum ada data slip gaji.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection