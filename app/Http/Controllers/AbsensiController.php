<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\TahunPelajaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $query = Absensi::with('pegawai')
        ->where('tahun_pelajaran_id', $tahunAktif->id);

    // Filter tanggal
    if ($request->tanggal) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    // Filter status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $absensi = $query->latest()->get();

    $totalPegawai = Pegawai::count();

$hadirHariIni = Absensi::whereDate('tanggal', today())->count();

$belumHadir = max($totalPegawai - $hadirHariIni, 0);

$totalGuru = Pegawai::where('jenis_pegawai', 'guru')->count();

    return view('absensi.index', compact(
    'absensi',
    'totalPegawai',
    'hadirHariIni',
    'belumHadir',
    'totalGuru'
));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $pegawai = Pegawai::all();

    $jadwal = JadwalMengajar::all();

    return view('absensi.create', compact(
        'pegawai',
        'jadwal'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'foto_masuk' => 'required|string',
    ]);

    $user = Auth::user();
    $pegawai = Pegawai::findOrFail($user->pegawai_id);

    $tanggal = Carbon::now('Asia/Jakarta')->toDateString();
    
    $image = $request->foto_masuk;
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $namaFoto = time() . '.png';

    file_put_contents(
        public_path('foto_absensi/' . $namaFoto),
        base64_decode($image)
    );

    $hari = Carbon::parse($tanggal)
    ->locale('id')
    ->dayName;
$hari = ucfirst($hari);

    $jp = 0;
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    if ($pegawai->jenis_pegawai == 'guru') {

        if (!$tahunAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada tahun pelajaran yang aktif.'
            ], 422);
        }

        $jadwal = JadwalMengajar::find(session('jadwal_id'));

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan pilih sesi mengajar terlebih dahulu.'
            ], 422);
        }

        $absensi = Absensi::where('pegawai_id', $pegawai->id)
    ->where('jadwal_mengajar_id', $jadwal->id)
    ->whereDate('tanggal', $tanggal)
    ->first();

        if (!$absensi) {
            Absensi::create([
                'pegawai_id' => $pegawai->id,
                'tahun_pelajaran_id' => $tahunAktif->id,
                'jadwal_mengajar_id' => $jadwal->id,
                'tanggal' => $tanggal,
                'jam_masuk' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
                'jam_mengajar' => $jadwal->jumlah_jp, 
                'foto_masuk' => $namaFoto,
                'status' => 'Hadir',
            ]);

            $pesan = 'Absensi mulai mengajar berhasil.';
            session(['jenis_absensi' => 'masuk']);

        } elseif (is_null($absensi->jam_pulang)) {
            $absensi->update([
    'jam_pulang' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
    'foto_pulang' => $namaFoto,
]);

            $pesan = 'Absensi selesai mengajar berhasil.';
            session(['jenis_absensi' => 'pulang']);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sesi ini sudah selesai diabsen.'
            ], 422);
        }

        session()->forget('jadwal_id');

        return response()->json([
            'success' => true,
            'message' => $pesan
        ]);
    }

    // ===== STAFF / NON-GURU =====
    $cekAbsensi = Absensi::where('pegawai_id', $pegawai->id)
    ->whereDate('tanggal', $tanggal)
    ->first();

    if ($cekAbsensi) {
        return response()->json([
            'success' => false,
            'message' => 'Anda sudah melakukan absensi hari ini.'
        ], 422);
    }

    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

if (!$tahunAktif) {
    return response()->json([
        'success' => false,
        'message' => 'Belum ada Tahun Pelajaran yang aktif.'
    ], 422);
}

// Simpan absensi untuk staff
Absensi::create([
    'pegawai_id'        => $pegawai->id,
    'tahun_pelajaran_id' => $tahunAktif->id,
    'tanggal'            => $request->tanggal,
    'jam_masuk'          => now()->format('H:i:s'),
    'jam_mengajar'       => 0,
    'foto_masuk'         => $namaFoto,
    'status'             => 'Hadir',
]);

   $pesan = 'Absensi berhasil disimpan.';

session(['jenis_absensi' => 'staff']);

return response()->json([
    'success' => true,
    'message' => $pesan
]);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $absensi = Absensi::with('pegawai')->findOrFail($id);

    return view('absensi.show', compact('absensi'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $absensi = Absensi::with('pegawai')->findOrFail($id);

    return view('absensi.edit', compact('absensi'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jam_masuk' => 'nullable',
        'jam_pulang' => 'nullable',
        'jam_mengajar' => 'nullable|numeric|min:0',
        'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
    ]);

    $absensi = Absensi::findOrFail($id);

    $absensi->update([
        'tanggal' => $request->tanggal,
        'jam_masuk' => $request->jam_masuk,
        'jam_pulang' => $request->jam_pulang,
        'jam_mengajar' => $request->jam_mengajar,
        'status' => $request->status,
    ]);

    return redirect()->route('absensi.index')
        ->with('success', 'Data absensi berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pulang($id)
{
    $absensi = Absensi::with('pegawai')->findOrFail($id);

    return view('absensi.pulang', compact('absensi'));
}

public function updatePulang(Request $request, $id)
{
    $request->validate([
        'foto_pulang' => 'required|image',
    ]);

    $absensi = Absensi::findOrFail($id);

    $namaFoto = time().'.'.$request->foto_pulang->extension();

    $request->foto_pulang->move(
        public_path('foto_absensi'),
        $namaFoto
    );

    $absensi->update([
        'jam_pulang' => now()->format('H:i:s'),
        'foto_pulang' => $namaFoto,
    ]);

    return redirect()->route('absensi.index')
        ->with('success','Absen pulang berhasil.');
}

public function kamera()
{
    $user = Auth::user();
    $pegawai = Pegawai::findOrFail($user->pegawai_id);

    // Khusus staff: hanya boleh absen 1 kali dalam sehari
    if ($pegawai->jenis_pegawai == 'staff') {

        $sudahAbsen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', Carbon::now('Asia/Jakarta')->toDateString())
            ->exists();

        if ($sudahAbsen) {
            return redirect()
                ->route('dashboard.guru')
                ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }
    }

    return view('absensi.kamera');
}

public function berhasil()
{
    $pegawai = Pegawai::findOrFail(auth()->user()->pegawai_id);

    $absensi = Absensi::where('pegawai_id', $pegawai->id)
        ->latest()
        ->first();

    return view('absensi.berhasil', compact(
        'pegawai',
        'absensi'
    ));
}

public function rekap(Request $request)
{
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $query = Absensi::with('pegawai')
        ->where('tahun_pelajaran_id', $tahunAktif->id);

    if ($request->bulan) {
        $query->whereMonth('tanggal', $request->bulan);
    }

    $absensi = $query->get();

    $data = $absensi
        ->groupBy('pegawai_id')
        ->map(function ($items) {

            $pegawai = $items->first()->pegawai;

            return (object)[
                'pegawai' => $pegawai,
                'jenis' => $pegawai->jenis_pegawai,
                'jumlah_hadir' => $items->count(),
                'total_jp' => $items->sum('jam_mengajar'),
            ];
        });

    return view('absensi.rekap', compact(
        'data',
        'tahunAktif'
    ));
}

public function cetak(Request $request)
{
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $query = Absensi::with('pegawai')
    ->where(function ($q) use ($tahunAktif) {
        $q->where('tahun_pelajaran_id', $tahunAktif->id)
          ->orWhereNull('tahun_pelajaran_id');
    });

    if ($request->bulan) {
        $query->whereMonth('tanggal', $request->bulan);
    }

    $absensi = $query->get();

    $data = $absensi
        ->groupBy('pegawai_id')
        ->map(function ($items) {

            $pegawai = $items->first()->pegawai;

            return (object)[
                'pegawai' => $pegawai,
                'jenis' => $pegawai->jenis_pegawai,
                'jumlah_hadir' => $items->count(),
                'total_jp' => $items->sum('jam_mengajar'),
            ];
        });

    $namaBulan = null;

    if ($request->bulan) {
        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $namaBulan = $bulan[(int)$request->bulan] ?? null;
    }

    return view('absensi.cetak', compact(
        'data',
        'tahunAktif',
        'namaBulan'
    ));
}

public function pilihSesi()
{
    $pegawai = auth()->user()->pegawai;

    $tanggalHariIni = Carbon::now('Asia/Jakarta')->toDateString();

    $hari = Carbon::now('Asia/Jakarta')->format('l');

    $hariMap = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];

    $hari = $hariMap[$hari] ?? 'Senin';

    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

$jadwalHariIni = JadwalMengajar::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->where('hari', $hari)
    ->orderBy('jam_mulai')
    ->get();

    foreach ($jadwalHariIni as $jadwal) {
        $absensi = Absensi::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->where('jadwal_mengajar_id', $jadwal->id)
    ->whereDate('tanggal', today())
    ->first();

        if (!$absensi) {
            $jadwal->status_sesi = 'belum';
        } elseif (is_null($absensi->jam_pulang)) {
            $jadwal->status_sesi = 'proses';
        } else {
            $jadwal->status_sesi = 'selesai';
        }
    }

    return view('absensi.pilih-sesi', compact('jadwalHariIni'));
}
public function prosesSesi(Request $request)
{
    $request->validate([
        'jadwal_id' => 'required|exists:jadwal_mengajars,id',
    ]);

    session([
        'jadwal_id' => $request->jadwal_id
    ]);

    return redirect()->route('absensi.kamera');
}

}
