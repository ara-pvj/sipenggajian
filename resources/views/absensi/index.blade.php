@extends('layouts.app')

@section('title', 'Data Absensi')
@section('page-title', 'Data Absensi')
@section('page-subtitle', 'Kelola absensi guru dan staff SMP Roudhotul Mardhiyyah')

@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-5xl font-extrabold tracking-widest text-blue-600">
            Data Absensi
        </h1>
        <p class="text-gray-500 mt-2">
            Kelola absensi guru dan staff SMP Roudhotul Mardhiyyah.
        </p>
    </div>
</div>

<!-- Filter -->
<div class="bg-white rounded-3xl shadow-lg border border-blue-100 p-4 mb-6">
    <div class="flex flex-wrap gap-3 items-center">
        <label class="text-sm font-semibold text-gray-700">Filter:</label>
        <input type="date" id="filterTanggal" 
               class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <select id="filterStatus" 
                class="px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Status</option>
            <option value="Hadir">Hadir</option>
            <option value="Selesai">Selesai</option>
            <option value="Izin">Izin</option>
            <option value="Alpha">Alpha</option>
        </select>
        <button onclick="filterAbsensi()" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
            Filter
        </button>
        <button onclick="resetFilter()" 
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold transition">
            Reset
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    <div class="bg-white rounded-2xl shadow p-5 border border-blue-100">
        <p class="text-gray-500 text-sm">Total Pegawai</p>
        <h2 class="text-3xl font-bold text-blue-600 mt-2">
            {{ $totalPegawai }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border border-green-100">
        <p class="text-gray-500 text-sm">Hadir Hari Ini</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $hadirHariIni }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border border-red-100">
        <p class="text-gray-500 text-sm">Belum Hadir</p>
        <h2 class="text-3xl font-bold text-red-500 mt-2">
            {{ $belumHadir }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-5 border border-yellow-100">
        <p class="text-gray-500 text-sm">Total Guru</p>
        <h2 class="text-3xl font-bold text-yellow-500 mt-2">
            {{ $totalGuru }}
        </h2>
    </div>

</div>

<!-- Tabel -->
<div class="bg-white rounded-3xl shadow-xl border border-blue-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-[1350px]">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-white uppercase tracking-wide">
                <tr>
                    <th class="px-6 py-4 text-center">No</th>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4 text-center">Tanggal</th>
                    <th class="px-6 py-4 text-center whitespace-nowrap">Foto Masuk</th>
                    <th class="px-6 py-4 text-center whitespace-nowrap">Jam Masuk</th>
                    <th class="px-6 py-4 text-center whitespace-nowrap">Foto Pulang</th>
                    <th class="px-6 py-4 text-center whitespace-nowrap">Jam Pulang</th>
                    <th class="px-6 py-4 text-center">JP</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                <tr class="border-b hover:bg-blue-50 duration-300">
                    <td class="text-center py-4">{{ $loop->iteration }}</td>
                    <td class="font-semibold text-gray-800">{{ $item->pegawai->nama }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-center">
                        @if($item->foto_masuk)
                            <a href="{{ asset('foto_absensi/'.$item->foto_masuk) }}"
                               target="_blank"
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                                👁 Lihat
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') }}</td>
                    <td class="text-center">
                        @if($item->foto_pulang)
                            <a href="{{ asset('foto_absensi/'.$item->foto_pulang) }}"
                               target="_blank"
                               class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm">
                                Lihat
                            </a>
                        @else
                            <span class="text-gray-400">Belum</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->jam_pulang)
                            {{ \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">
                            {{ $item->jam_mengajar }} JP
                        </span>
                    </td>
                    <td class="text-center">
                        @if($item->status=='Hadir')
                            <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">Hadir</span>
                        @elseif($item->status=='Izin')
                            <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-semibold">Izin</span>
                        @elseif($item->status=='Selesai')
                            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">Selesai</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="flex justify-center gap-2 flex-wrap">
                            <!-- Detail -->
                            <a href="{{ route('absensi.show', $item->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-10 text-gray-500">
                        Belum ada data absensi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterAbsensi() {
        const tanggal = document.getElementById('filterTanggal').value;
        const status = document.getElementById('filterStatus').value;
        
        let url = '{{ route("absensi.index") }}?';
        if (tanggal) url += 'tanggal=' + tanggal + '&';
        if (status) url += 'status=' + status;
        
        window.location.href = url;
    }
    
    function resetFilter() {
        window.location.href = '{{ route("absensi.index") }}';
    }
</script>

@endsection