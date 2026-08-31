<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Pegawai;
use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\TahunPelajaran;
use App\Models\MasterKomponenPenggajian;
use App\Models\JadwalMengajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $filter = $request->filter ?? 'semua';
    $periode = $request->periode ?? now()->format('Y-m');

    // Ambil tahun pelajaran yang sedang aktif
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    // Mode monitoring
    $monitoring = true;

    // Jika belum ada data penggajian resmi,
    // tampilkan monitoring berdasarkan absensi tahun pelajaran aktif
    $penggajianGuru = $this->getMonitoringGuru($periode);
    $penggajianStaff = $this->getMonitoringStaff($periode);

    return view('penggajian.index', compact(
        'penggajianGuru',
        'penggajianStaff',
        'periode',
        'filter',
        'monitoring'
    ));
}

// ===== MONITORING GURU =====
private function getMonitoringGuru($periode)
{
    $bulan = date('m', strtotime($periode));
    $tahun = date('Y', strtotime($periode));
    $komponenMaster = MasterKomponenPenggajian::first();
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $guruList = Pegawai::with('jabatan')
        ->where('jenis_pegawai', 'guru')
        ->get();

    $data = collect();

    foreach ($guruList as $pegawai) {
        $absensi = Absensi::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->whereMonth('tanggal', $bulan)
    ->whereYear('tanggal', $tahun)
    ->whereIn('status', ['Hadir', 'Selesai'])
    ->get();
    

        if ($absensi->isEmpty()) {
            continue;
        }

        $totalJP = $absensi->sum('jam_mengajar');

$jumlahHadir = $absensi
    ->map(function ($item) {
        return Carbon::parse($item->tanggal)->toDateString();
    })
    ->unique()
    ->count();

        $gajiMengajar = $komponenMaster->tarif_jp_guru * $totalJP;
        $gajiJabatan = $pegawai->jabatan->gaji_jabatan ?? 0;
        $transport = $komponenMaster->transport_guru * $jumlahHadir;
        $total = $gajiMengajar + $gajiJabatan + $transport;

        $data->push((object)[
            'id' => null,
            'pegawai' => $pegawai,
            'periode' => $periode . '-01',
            'total_jam' => $totalJP,
            'jumlah_hadir' => $jumlahHadir,
            'gaji_mengajar' => $gajiMengajar,
            'gaji_jabatan' => $gajiJabatan,
            'transport' => $transport,
            'gaji_total' => $total,
            'status' => 'Monitoring',
        ]);
    }

    return $data;
}

// ===== MONITORING STAFF =====
private function getMonitoringStaff($periode)
{
    $bulan = date('m', strtotime($periode));
    $tahun = date('Y', strtotime($periode));
    $komponenMaster = MasterKomponenPenggajian::first();
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $staffList = Pegawai::where('jenis_pegawai', 'staff')->get();
    $data = collect();

    foreach ($staffList as $pegawai) {
        $absensi = Absensi::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->whereMonth('tanggal', $bulan)
    ->whereYear('tanggal', $tahun)
    ->whereIn('status', ['Hadir', 'Selesai'])
    ->get();

    if ($absensi->isEmpty()) {
    continue;
}

        $jumlahHadir = $absensi->count();

if ($jumlahHadir == 0) {
    continue;
}

$gajiPokok = $pegawai->gaji_pokok ?? 0;
$transport = ($komponenMaster->transport_staff ?? 5000) * $jumlahHadir;
$total = $gajiPokok + $transport;

$data->push((object)[
    'id' => null,
    'pegawai' => $pegawai,
    'periode' => $periode . '-01',
    'gaji_pokok' => $gajiPokok,
    'hari_hadir' => $jumlahHadir,
    'transport' => $transport,
    'gaji_total' => $total,
    'status' => 'Monitoring',
]);
    }

    return $data;
}

public function komponen(Request $request)
{
    $search = $request->search;
    $filter = $request->filter ?? 'semua';

    $guru = Pegawai::with('jabatan')
        ->where('jenis_pegawai', 'guru')
        ->when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })
        ->paginate(5, ['*'], 'guru');

    $staff = Pegawai::with('jabatan')
        ->where('jenis_pegawai', 'staff')
        ->when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%");
        })
        ->paginate(5, ['*'], 'staff');

    return view('penggajian.komponen', compact(
        'guru',
        'staff',
        'search',
        'filter'
    ));
}

public function editKomponen($id)
{
    $pegawai = Pegawai::findOrFail($id);

    $jabatan = Jabatan::all();

    $jadwal = $pegawai->jadwalMengajar()->get()->keyBy('hari');

    return view('penggajian.edit-komponen', compact(
        'pegawai',
        'jabatan',
        'jadwal'
    ));
}

public function updateKomponen(Request $request, $id)
{
    $request->validate([
        'jabatan_id' => 'nullable|exists:jabatan,id',
        'tarif_per_jam' => 'nullable|numeric|min:0',
        'gaji_pokok' => 'nullable|numeric|min:0',
        'transport' => 'nullable|numeric|min:0',
    ]);

    $pegawai = Pegawai::findOrFail($id);

    $pegawai->update([
        'jabatan_id' => $request->jabatan_id ?: null,
        'tarif_per_jam' => $request->tarif_per_jam,
        'gaji_pokok' => $request->gaji_pokok,
        'transport' => $request->transport,
    ]);

    return redirect()
        ->route('komponen.index')
        ->with('success', 'Komponen penggajian berhasil diperbarui!');
}

public function slipIndex(Request $request)
{
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $periode = $request->periode ?? now()->format('Y-m');

    $query = Penggajian::with('pegawai')
        ->where('tahun_pelajaran_id', $tahunAktif->id);

    if ($periode) {

        $bulan = date('m', strtotime($periode));
        $tahun = date('Y', strtotime($periode));

        $query->whereMonth('periode', $bulan)
              ->whereYear('periode', $tahun);
    }

    $penggajian = $query->latest()->get();

    return view('penggajian.slip_index', compact(
        'penggajian',
        'periode'
    ));
}

public function laporan(Request $request)
{
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $query = Penggajian::with('pegawai')
        ->where('tahun_pelajaran_id', $tahunAktif->id);

    if ($request->periode) {

        $bulan = date('m', strtotime($request->periode));
        $tahun = date('Y', strtotime($request->periode));

        $query->whereMonth('periode', $bulan)
              ->whereYear('periode', $tahun);

    }

    $penggajian = $query
        ->latest()
        ->get();

    $totalPenggajian = $penggajian->sum('gaji_total');

    $periode = Penggajian::where('tahun_pelajaran_id', $tahunAktif->id)
        ->select('periode')
        ->distinct()
        ->orderBy('periode', 'desc')
        ->get();

    return view('laporan.index', compact(
        'penggajian',
        'totalPenggajian',
        'periode'
    ));
}

public function cetakLaporan(Request $request)
{
    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $query = Penggajian::with('pegawai.jabatan')
    ->where('tahun_pelajaran_id', $tahunAktif->id);

    if($request->periode){
        $query->whereMonth('periode', date('m', strtotime($request->periode)))
              ->whereYear('periode', date('Y', strtotime($request->periode)));
    }

    $penggajian = $query->get();

    $totalPenggajian = $penggajian->sum('gaji_total');

    return view('laporan.cetak', compact(
        'penggajian',
        'totalPenggajian'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    $today = Carbon::today();
    $lastDay = Carbon::today()->endOfMonth();

    $allowProcess = $today->greaterThanOrEqualTo(
        $lastDay->copy()->subDay()
    );

    if (!$allowProcess) {
        return redirect()->route('penggajian.index')
            ->with('error', 'Proses penggajian hanya dapat dilakukan mulai H-1 hingga hari terakhir setiap bulan.');
    }

    return view('penggajian.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $today = Carbon::today();
    $lastDay = Carbon::today()->endOfMonth();

    $allowProcess = $today->greaterThanOrEqualTo(
        $lastDay->copy()->subDay()
    );

    if (!$allowProcess) {
        return redirect()->route('penggajian.index')
            ->with('error', 'Proses penggajian hanya dapat dilakukan mulai H-1 hingga hari terakhir setiap bulan.');
    }

    $request->validate([
        'periode' => 'required|date_format:Y-m',
    ]);

    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    if (!$tahunAktif) {
        return redirect()->route('penggajian.index')
            ->with('error', 'Belum ada Tahun Pelajaran yang aktif.');
    }

    $bulan = date('m', strtotime($request->periode));
    $tahun = date('Y', strtotime($request->periode));

    // ===== AMBIL MASTER KOMPONEN =====
    $komponenMaster = \App\Models\MasterKomponenPenggajian::first();

    if (!$komponenMaster) {
        return redirect()->route('penggajian.index')
            ->with('error', 'Master komponen penggajian belum diatur!');
    }

    $pegawaiList = Pegawai::all();
    $count = 0;

    foreach ($pegawaiList as $pegawai) {
        // Cek duplikasi
        $cek = Penggajian::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->whereMonth('periode', $bulan)
    ->whereYear('periode', $tahun)
    ->exists();

        if ($cek) {
            continue;
        }

        // Ambil absensi yang sudah SELESAI
        $absensi = Absensi::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->whereMonth('tanggal', $bulan)
    ->whereYear('tanggal', $tahun)
    ->where('status', 'Hadir')
    ->get();

        $totalJP = $absensi->sum('jam_mengajar');

$jumlahHadir = $absensi
    ->map(function ($item) {
        return Carbon::parse($item->tanggal)->toDateString();
    })
    ->unique()
    ->count();

        // ===== GURU: wajib punya absensi =====
       // ===== SEMUA PEGAWAI WAJIB PUNYA ABSENSI =====
if ($jumlahHadir == 0) {
    continue;
}

        $jabatan = Jabatan::find($pegawai->jabatan_id);
        $gajiMengajar = 0;
        $gajiJabatan = 0;
        $gajiPokok = 0;
        $transport = 0;

        if ($pegawai->jenis_pegawai == 'guru') {
            // ===== GURU =====
            // Gaji Mengajar = tarif_jp_guru × total JP (DARI MASTER KOMPONEN)
            $gajiMengajar = $komponenMaster->tarif_jp_guru * $totalJP;

            // Gaji Jabatan dari jabatan (jika ada)
            if ($jabatan) {
                $gajiJabatan = $jabatan->gaji_jabatan ?? 0;
            }

            // ===== TRANSPORT DARI MASTER KOMPONEN (BUKAN JABATAN) =====
            $transport = $komponenMaster->transport_guru * $jumlahHadir;

            $total = $gajiMengajar + $gajiJabatan + $transport;

       } else {
    // ===== STAFF =====
    // Gaji Pokok dari tabel pegawai (bukan dari master komponen)
    $gajiPokok = $pegawai->gaji_pokok ?? 0; 
    
    // Transport = transport_staff × jumlah hadir
    $transport = ($komponenMaster->transport_staff ?? 5000) * $jumlahHadir;
    
    $total = $gajiPokok + $transport;

}

        // ===== HITUNG JP WAJIB =====
        $jpWajib = 0;
        $jadwal = JadwalMengajar::where('pegawai_id', $pegawai->id)
    ->where('tahun_pelajaran_id', $tahunAktif->id)
    ->get();
        $jpWajib = $jadwal->sum('jumlah_jp') * 4; // Asumsi 4 minggu

        Penggajian::create([
            'pegawai_id' => $pegawai->id,
            'tahun_pelajaran_id' => $tahunAktif->id,
            'periode' => $request->periode . '-01',
            'total_jam' => $totalJP,
            'jumlah_hadir' => $jumlahHadir,
            'jp_wajib' => $jpWajib,
            'gaji_mengajar' => $gajiMengajar,
            'gaji_jabatan' => $gajiJabatan,
            'gaji_pokok' => $gajiPokok,
            'transport' => $transport,
            'gaji_total' => $total,
            'status' => 'Belum Dibayar',
        ]);

        $count++;
    }

    return redirect()->route('penggajian.index', [
        'periode' => $request->periode,
        'filter' => 'semua'
    ])->with('success', "Penggajian berhasil diproses! {$count} data ditambahkan.");
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $penggajian = Penggajian::with('pegawai.jabatan')
                    ->findOrFail($id);

    return view('penggajian.slip', compact('penggajian'));
}

public function slipShow($id)
{
    $penggajian = Penggajian::with('pegawai.jabatan')
                    ->findOrFail($id);

    return view('penggajian.slip', compact('penggajian'));
}

    public function slipSaya()
{
    $pegawai = auth()->user()->pegawai;

    $penggajian = Penggajian::with('pegawai.jabatan')
        ->where('pegawai_id', $pegawai->id)
        ->latest('periode')
        ->first();

    if (!$penggajian) {
        return redirect()->back()->with(
            'error',
            'Belum ada slip gaji untuk Anda.'
        );
    }

    return view('penggajian.slip', compact('penggajian'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bayar($id)
{
    $penggajian = Penggajian::findOrFail($id);

    $penggajian->status = 'Sudah Dibayar';
    $penggajian->save();

   return redirect()->route('slip.index')
    ->with('success', 'Penggajian berhasil dibayar.');
}
}
