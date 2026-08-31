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

    <div class="flex justify-center gap-2">

        <a href="{{ route('slip.show', $item->id) }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

            Lihat Slip

        </a>

        @if($item->status == 'Belum Dibayar')

    <form id="form-bayar-{{ $item->id }}"
          action="{{ route('penggajian.bayar', $item->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <button type="button"
                onclick="openBayarModal(
                    '{{ $item->id }}',
                    '{{ $item->pegawai->nama }}',
                    '{{ number_format($item->gaji_total, 0, ',', '.') }}'
                )"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

            Bayar

        </button>

    </form>

@endif

    </div>

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

<!-- Modal Konfirmasi Pembayaran -->
<div id="bayarModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

        <div class="text-center">

            <div class="mx-auto mb-4 w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                <span class="text-2xl text-green-600">✓</span>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">
                Konfirmasi Pembayaran
            </h3>

            <p class="text-gray-600 mb-2">
                Apakah gaji pegawai ini sudah dibayarkan?
            </p>

            <p id="namaPegawai"
               class="font-semibold text-gray-800">
            </p>

            <p class="text-green-600 font-bold text-lg mb-6">
                Rp <span id="jumlahGaji"></span>
            </p>

            <div class="flex justify-center gap-3">

                <button type="button"
                        onclick="closeBayarModal()"
                        class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg">
                    Batal
                </button>

                <button type="button"
                        onclick="submitBayar()"
                        class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                    Ya, Sudah Dibayar
                </button>

            </div>

        </div>

    </div>

</div>

<script>

    let formBayar = null;

    function openBayarModal(id, nama, gaji) {

        formBayar = document.getElementById('form-bayar-' + id);

        document.getElementById('namaPegawai').innerText = nama;
        document.getElementById('jumlahGaji').innerText = gaji;

        const modal = document.getElementById('bayarModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBayarModal() {

        const modal = document.getElementById('bayarModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        formBayar = null;
    }

    function submitBayar() {

        if (formBayar) {
            formBayar.submit();
        }

    }

</script>

@endsection