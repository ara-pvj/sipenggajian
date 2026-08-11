<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Absensi;
use App\Models\Penggajian;
use App\Models\JadwalMengajar;
use App\Models\Informasi;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // ===== DASHBOARD BENDAHARA =====
    public function bendahara()
    {
        // Total pegawai
        $totalPegawai = Pegawai::count();
        
        // Total guru
        $totalGuru = Pegawai::where('jenis_pegawai', 'guru')->count();
        
        // Total staff
        $totalStaff = Pegawai::where('jenis_pegawai', 'staff')->count();
        
        // Total gaji semua
        $totalGaji = Penggajian::sum('gaji_total');
        
        // Informasi penting (ambil yang pertama)
        $informasi = Informasi::first();
        
        // Total jadwal mengajar
        $totalJadwal = JadwalMengajar::count();
        
        // Absensi hari ini
        $absensiHariIni = Absensi::whereDate('tanggal', today())->count();
        
        // 5 data penggajian terbaru
        $penggajianTerbaru = Penggajian::with('pegawai')
            ->latest()
            ->take(5)
            ->get();
        
        // Status pembayaran
        $sudahDibayar = Penggajian::where('status', 'Sudah Dibayar')->count();
        $belumDibayar = Penggajian::where('status', 'Belum Dibayar')->count();

        // Kirim semua data ke view
        return view('dashboard.bendahara', compact(
            'totalPegawai',
            'totalGuru',
            'totalStaff',
            'totalGaji',
            'informasi',
            'totalJadwal',
            'absensiHariIni',
            'penggajianTerbaru',
            'sudahDibayar',
            'belumDibayar'
        ));
    }

    // ===== UPDATE INFORMASI PENTING =====
    public function updateInformasi(Request $request)
    {
        // Validasi
        $request->validate([
            'isi' => 'required|string|min:1',
        ]);

        // Cari data informasi pertama
        $informasi = Informasi::first();

        if ($informasi) {
            // Update jika ada
            $informasi->update([
                'isi' => $request->isi
            ]);
        } else {
            // Buat baru jika belum ada
            Informasi::create([
                'isi' => $request->isi
            ]);
        }

        // Redirect dengan pesan sukses
        // Redirect sesuai role yang login
$role = auth()->user()->role;

if ($role == 'bendahara') {
    return redirect()
        ->route('dashboard.bendahara')
        ->with('success', 'Informasi penting berhasil diperbarui!');
}

if ($role == 'tata_usaha') {
    return redirect()
        ->route('dashboard.tatausaha')
        ->with('success', 'Informasi penting berhasil diperbarui!');
}

if ($role == 'kepala_sekolah') {
    return redirect()
        ->route('dashboard.kepala')
        ->with('success', 'Informasi penting berhasil diperbarui!');
}

return back()->with('success', 'Informasi penting berhasil diperbarui!');
    }

    // ===== DASHBOARD GURU (Opsional) =====
    public function guru()
{
    $pegawai = auth()->user()->pegawai;

    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $jadwalHariIni = JadwalMengajar::where('pegawai_id', $pegawai->id)
        ->where('tahun_pelajaran_id', $tahunAktif?->id)
        ->count();

    $sesiSelesai = Absensi::where('pegawai_id', $pegawai->id)
        ->whereDate('tanggal', today())
        ->whereNotNull('jam_pulang')
        ->count();

    $belumSelesai = max($jadwalHariIni - $sesiSelesai, 0);

    $persentase = $jadwalHariIni > 0
        ? round(($sesiSelesai / $jadwalHariIni) * 100)
        : 0;

    $slip = Penggajian::where('pegawai_id', $pegawai->id)
        ->latest('periode')
        ->first();

    $informasi = Informasi::first();

    return view('dashboard.guru', compact(
        'pegawai',
        'tahunAktif',
        'jadwalHariIni',
        'sesiSelesai',
        'belumSelesai',
        'persentase',
        'slip',
        'informasi'
    ));
}

    // ===== DASHBOARD KEPALA SEKOLAH (Opsional) =====
    public function kepala()
{
    $pegawai = auth()->user()->pegawai;

    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

    $totalGuru = Pegawai::where('jenis_pegawai', 'guru')->count();

    $totalStaff = Pegawai::where('jenis_pegawai', 'staff')->count();

    $totalPegawai = Pegawai::count();

    $informasi = Informasi::first();

    $today = now()->toDateString();

    $hadir = Absensi::whereDate('tanggal', $today)
        ->where('status', 'Hadir')
        ->count();
    
        $belumHadir = $totalGuru - $hadir;

    $totalPenggajian = Penggajian::sum('gaji_total');

$sudahDibayar = Penggajian::where('status', 'Sudah Dibayar')
    ->sum('gaji_total');

$belumDibayar = Penggajian::where('status', 'Belum Dibayar')
    ->sum('gaji_total');

    return view('dashboard.kepala', compact(
        'pegawai',
        'tahunAktif',
        'totalGuru',
        'totalStaff',
        'totalPegawai',
        'hadir',
        'belumHadir',
        'totalPenggajian',
        'sudahDibayar',
        'belumDibayar',
        'informasi'
    ));
}

    public function tataUsaha()
{
    $totalGuru = Pegawai::where('jenis_pegawai', 'guru')->count();

    $totalStaff = Pegawai::where('jenis_pegawai', 'staff')->count();

    $informasi = Informasi::first();

    $absensiHariIni = Absensi::whereDate('tanggal', today())->count();

    $pegawai = auth()->user()->pegawai;

$pegawai = auth()->user()->pegawai;

if ($pegawai->jenis_pegawai == 'guru') {

    // JP yang sudah ditempuh bulan ini
    $hadir = Absensi::where('pegawai_id', $pegawai->id)
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->sum('jam_mengajar');

    // Total JP per minggu
    $jpPerMinggu = JadwalMengajar::where('pegawai_id', $pegawai->id)
        ->sum('jumlah_jp');

    // Perkiraan jumlah minggu dalam bulan
    $mingguDalamBulan = ceil(now()->daysInMonth / 7);

    // Target JP bulan ini
    $totalTarget = $jpPerMinggu * $mingguDalamBulan;

    $tidakHadir = max($totalTarget - $hadir, 0);

} else {

    // Hari hadir bulan ini
    $hadir = Absensi::where('pegawai_id', $pegawai->id)
        ->whereMonth('tanggal', now()->month)
        ->whereYear('tanggal', now()->year)
        ->count();

    // Hari kerja (Senin–Sabtu)
    $totalTarget = 0;

    $tanggal = now()->startOfMonth();

    while ($tanggal->month == now()->month) {

        if ($tanggal->dayOfWeek != 0) {
            $totalTarget++;
        }

        $tanggal->addDay();
    }

    $tidakHadir = max($totalTarget - $hadir, 0);
}

$persentase = $totalTarget > 0
    ? round(($hadir / $totalTarget) * 100)
    : 0;

$slip = Penggajian::where('pegawai_id', $pegawai->id)
    ->latest('periode')
    ->first();

    return view('dashboard.tatausaha', compact(
    'totalGuru',
    'totalStaff',
    'informasi',
    'absensiHariIni',
    'hadir',
    'tidakHadir',
    'persentase',
    'slip'
));
}

public function kurikulum()
{
    $totalGuru = Pegawai::where('jenis_pegawai','guru')->count();

    $totalJadwal = JadwalMengajar::count();

    $tahunAktif = TahunPelajaran::where('status','Aktif')->first();

    $informasi = Informasi::first();

    return view('dashboard.kurikulum', compact(
    'totalGuru',
    'totalJadwal',
    'tahunAktif',
    'informasi'
));
}
}