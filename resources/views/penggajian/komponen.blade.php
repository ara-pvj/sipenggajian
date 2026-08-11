@extends('layouts.app')

@section('title','Data Pegawai')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>

        <h1 class="text-5xl font-extrabold tracking-widest text-blue-600">
            KOMPONEN PENGGAJIAN
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola tarif JP, gaji pokok, gaji jabatan, dan transport pegawai.
        </p>

    </div>

</div>
<div class="bg-white rounded-3xl shadow-lg p-6 mb-8 border border-blue-100">
    <form method="GET" action="{{ route('komponen.index') }}">

    <div class="flex gap-4">

        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="🔍 Cari nama pegawai..."
            class="flex-1 rounded-2xl border-gray-300 shadow-sm">

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 rounded-2xl">

            Cari

        </button>

    </div>

</form>

</div>

<div class="flex gap-3 mb-6">

    <a href="{{ route('komponen.index',['filter'=>'semua','search'=>$search]) }}"
       class="px-5 py-2 rounded-xl {{ $filter=='semua' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
        Semua
    </a>

    <a href="{{ route('komponen.index',['filter'=>'guru','search'=>$search]) }}"
       class="px-5 py-2 rounded-xl {{ $filter=='guru' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
        Guru
    </a>

    <a href="{{ route('komponen.index',['filter'=>'staff','search'=>$search]) }}"
       class="px-5 py-2 rounded-xl {{ $filter=='staff' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
        Staff
    </a>

</div>

{{-- ================= DATA GURU ================= --}}

@if($filter == 'semua' || $filter == 'guru')

<div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-blue-100">

    <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white px-6 py-4">
        <h2 class="text-2xl font-bold">Data Guru</h2>
    </div>

    <table class="min-w-full">

        <thead class="bg-blue-50">

            <tr>
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">Jabatan</th>
                <th class="px-6 py-4 text-left">Gaji Jabatan</th>
                <th class="px-6 py-4 text-left">Tarif / JP</th>
                <th class="px-6 py-4 text-left">Transport</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>

        </thead>

        <tbody>

        @forelse($guru as $data)

            <tr class="border-b hover:bg-blue-50">

                <td class="px-6 py-4">
                    {{ $guru->firstItem() + $loop->index }}
                </td>

                <td class="px-6 py-4">{{ $data->nama }}</td>

                <td class="px-6 py-4">
                    {{ $data->jabatan->nama_jabatan ?? '-' }}
                </td>

                <td class="px-6 py-4">
                    Rp {{ number_format($data->jabatan->gaji_jabatan ?? 0,0,',','.') }}
                </td>

                <td class="px-6 py-4">
                    Rp {{ number_format($data->tarif_per_jam,0,',','.') }}
                </td>

                <td class="px-6 py-4">
                    Rp {{ number_format($data->transport,0,',','.') }}
                </td>

                <td class="px-6 py-4">

                    <div class="flex gap-2 justify-center">

                        <a href="{{ route('komponen.edit',$data->id) }}"
                           class="bg-yellow-400 text-white px-4 py-2 rounded-xl">
                            ✏ Edit
                        </a>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="7" class="text-center py-6">
                    Tidak ada data guru.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="p-6">
        {{ $guru->appends(request()->query())->links() }}
    </div>

</div>

@endif


{{-- ================= DATA STAFF ================= --}}

@if($filter == 'semua' || $filter == 'staff')

<div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-blue-100 mt-10">

    <div class="bg-gradient-to-r from-green-700 to-green-500 text-white px-6 py-4">
        <h2 class="text-2xl font-bold">Data Staff</h2>
    </div>

    <table class="min-w-full">

        <thead class="bg-green-50">

            <tr>
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Nama</th>
                <th class="px-6 py-4 text-left">Jabatan</th>
                <th class="px-6 py-4 text-left">Gaji Pokok</th>
                <th class="px-6 py-4 text-left">Transport</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>

        </thead>

        <tbody>

        @forelse($staff as $data)

            <tr class="border-b hover:bg-green-50">

                <td class="px-6 py-4">
                    {{ $staff->firstItem() + $loop->index }}
                </td>

                <td class="px-6 py-4">{{ $data->nama }}</td>

                <td class="px-6 py-4">
                    {{ $data->jabatan->nama_jabatan ?? '-' }}
                </td>

                <td class="px-6 py-4">
                    Rp {{ number_format($data->gaji_pokok,0,',','.') }}
                </td>

                <td class="px-6 py-4">
                    Rp {{ number_format($data->transport,0,',','.') }}
                </td>

                <td class="px-6 py-4">

                    <div class="flex gap-2 justify-center">

                        <a href="{{ route('komponen.edit',$data->id) }}"
                           class="bg-yellow-400 text-white px-4 py-2 rounded-xl">
                            ✏ Edit
                        </a>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6" class="text-center py-6">
                    Tidak ada data staff.
                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="p-6">
        {{ $staff->appends(request()->query())->links() }}
    </div>

</div>

@endif
@endsection