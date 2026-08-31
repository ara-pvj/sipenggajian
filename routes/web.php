<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\TahunPelajaranController;
use App\Http\Controllers\JadwalMengajarController;
use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    // =========================
    // TATA USAHA
    // =========================
    Route::middleware('role:tata_usaha')->group(function () {

        Route::resource('pegawai', PegawaiController::class);

        Route::resource('akun', AkunController::class)
            ->except(['show']);

        Route::resource('jabatan', JabatanController::class);

        Route::get('/dashboard/tata-usaha',
            [DashboardController::class, 'tataUsaha'])
            ->name('dashboard.tatausaha');

    });


    // =========================
    // KURIKULUM
    // =========================
    Route::middleware('role:kurikulum')->group(function () {

        Route::resource('tahun-pelajaran', TahunPelajaranController::class);

        Route::get(
            '/jadwal-mengajar/detail/{pegawai}/{tahun}',
            [JadwalMengajarController::class, 'detail']
        )->name('jadwal-mengajar.detail');

        Route::resource('jadwal-mengajar', JadwalMengajarController::class);

        Route::get('/dashboard/kurikulum',
            [DashboardController::class, 'kurikulum'])
            ->name('dashboard.kurikulum');

    });


    // =========================
    // GURU
    // =========================
    Route::middleware('role:guru,staff')->group(function () {

        Route::get('/dashboard/guru',
            [DashboardController::class, 'guru'])
            ->name('dashboard.guru');

    });


    // =========================
    // BENDAHARA
    // =========================
    Route::middleware('role:bendahara')->group(function () {

        Route::get('/dashboard/bendahara',
            [DashboardController::class, 'bendahara'])
            ->name('dashboard.bendahara');

        Route::resource('penggajian', PenggajianController::class);

        Route::put('/penggajian/{id}/bayar',
            [PenggajianController::class, 'bayar'])
            ->name('penggajian.bayar');

        Route::get('/komponen-penggajian',
            [PenggajianController::class, 'komponen'])
            ->name('komponen.index');

        Route::get('/komponen-penggajian/{id}/edit',
            [PenggajianController::class, 'editKomponen'])
            ->name('komponen.edit');

        Route::put('/komponen-penggajian/{id}', [PenggajianController::class, 'updateKomponen'])
            ->name('komponen.update');

        Route::get('/slip-gaji',
            [PenggajianController::class, 'slipIndex'])
            ->name('slip.index');

        Route::get('/slip-gaji/{id}', [PenggajianController::class, 'slipShow'])
            ->name('slip.show');

    });


    // =========================
    // KEPALA SEKOLAH
    // =========================
    Route::middleware('role:kepala_sekolah')->group(function () {

        Route::get('/dashboard/kepala',
            [DashboardController::class, 'kepala'])
            ->name('dashboard.kepala');

    });


    // =========================
    // SLIP SAYA
    // Semua user yang login
    // =========================
    Route::get('/slip-saya',
        [PenggajianController::class, 'slipSaya'])
        ->name('slip.saya');


    // =========================
    // INFORMASI
    // =========================
    Route::middleware('role:tata_usaha,bendahara,kepala_sekolah')->group(function () {

        Route::put('/informasi/update',
            [DashboardController::class, 'updateInformasi'])
            ->name('informasi.update');

    });


    // =========================
    // REKAP ABSENSI
    // =========================
    Route::middleware('role:tata_usaha,kepala_sekolah')->group(function () {

        Route::get('/rekap-absensi',
            [AbsensiController::class, 'rekap'])
            ->name('absensi.rekap');

        Route::get('/rekap-absensi/cetak',
            [AbsensiController::class, 'cetak'])
            ->name('absensi.cetak');

    });


    // =========================
    // LAPORAN
    // =========================
    Route::middleware('role:bendahara,kepala_sekolah')->group(function () {

        Route::get('/laporan',
            [PenggajianController::class, 'laporan'])
            ->name('laporan.index');

        Route::get('/laporan/cetak',
            [PenggajianController::class, 'cetakLaporan'])
            ->name('laporan.cetak');

    });


    // =========================
    // ABSENSI
    // =========================
    Route::get('/absensi/kamera',
        [AbsensiController::class, 'kamera'])
        ->name('absensi.kamera');

    Route::get('/absensi/pilih-sesi',
        [AbsensiController::class, 'pilihSesi'])
        ->name('absensi.pilihSesi');

    Route::post('/absensi/proses-sesi',
        [AbsensiController::class, 'prosesSesi'])
        ->name('absensi.prosesSesi');

    Route::get('/absensi/berhasil',
        [AbsensiController::class, 'berhasil'])
        ->name('absensi.berhasil');

    Route::resource('absensi', AbsensiController::class);

    Route::get('/absensi/{id}/pulang',
        [AbsensiController::class, 'pulang'])
        ->name('absensi.pulang');

    Route::put('/absensi/{id}/pulang',
        [AbsensiController::class, 'updatePulang'])
        ->name('absensi.updatePulang');


    // =========================
    // PROFILE
    // =========================
    Route::get('/profile',
        [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


require __DIR__.'/auth.php';