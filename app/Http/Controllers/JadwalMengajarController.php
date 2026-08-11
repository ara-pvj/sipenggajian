<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\Pegawai;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    public function index()
{
    $jadwal = JadwalMengajar::with([
    'pegawai',
    'tahunPelajaran'
])
->whereHas('tahunPelajaran', function ($q) {
    $q->where('status', 'Aktif');
})
->select('pegawai_id','tahun_pelajaran_id')
->groupBy('pegawai_id','tahun_pelajaran_id')
->get();

    return view('jadwal_mengajar.index', compact('jadwal'));
}

    public function create()
{
    $guru = Pegawai::where('jenis_pegawai', 'guru')->get();

    $tahunAktif = TahunPelajaran::where('status', 'Aktif')->first();

return view('jadwal_mengajar.create', compact(
    'guru',
    'tahunAktif'
));

}

    public function store(Request $request)
{
    $request->validate([
        'pegawai_id' => 'required|exists:pegawai,id',
        'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
        'hari' => 'required|array',
        'kelas' => 'required|array',
        'mata_pelajaran' => 'required|array',
        'jam_mulai' => 'required|array',
        'jam_selesai' => 'required|array',
        'jumlah_jp' => 'required|array',
    ]);

    foreach ($request->hari as $i => $hari) {

    if (
        !empty($request->jam_mulai[$i]) &&
        !empty($request->jam_selesai[$i])
    ) {

        JadwalMengajar::create([

            'pegawai_id' => $request->pegawai_id,

            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,

            'hari' => $hari,

            'kelas' => $request->kelas[$i],

            'mata_pelajaran' => $request->mata_pelajaran[$i],

            'jam_mulai' => $request->jam_mulai[$i],

            'jam_selesai' => $request->jam_selesai[$i],

            'jumlah_jp' => $request->jumlah_jp[$i],

        ]);

    }

}

    return redirect()
        ->route('jadwal-mengajar.index')
        ->with('success', 'Jadwal mengajar berhasil ditambahkan.');
}

public function detail($pegawai, $tahun)
{
    $jadwal = JadwalMengajar::with([
        'pegawai',
        'tahunPelajaran'
    ])
    ->where('pegawai_id', $pegawai)
    ->where('tahun_pelajaran_id', $tahun)
    ->get();

    return view(
        'jadwal_mengajar.detail',
        compact('jadwal')
    );
}

    public function edit($id)
{
    $jadwal = JadwalMengajar::findOrFail($id);

    $guru = Pegawai::where('jenis_pegawai','guru')->get();

    $tahun = TahunPelajaran::all();

    return view('jadwal_mengajar.edit', compact(
        'jadwal',
        'guru',
        'tahun'
    ));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'pegawai_id' => 'required|exists:pegawai,id',
        'tahun_pelajaran_id' => 'required|exists:tahun_pelajarans,id',
        'hari' => 'required',
        'kelas' => 'required',
        'mata_pelajaran' => 'required',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
        'jumlah_jp' => 'required'
    ]);

    $jadwal = JadwalMengajar::findOrFail($id);

    $jadwal->update($request->all());

    return redirect()
        ->route('jadwal-mengajar.index')
        ->with('success','Jadwal berhasil diperbarui.');
}

    public function destroy($id)
{
    JadwalMengajar::findOrFail($id)->delete();

    return redirect()
        ->route('jadwal-mengajar.index')
        ->with('success','Jadwal berhasil dihapus.');
}
}