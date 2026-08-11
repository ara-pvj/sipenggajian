<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\JadwalMengajar;
use App\Models\MasterKomponenPenggajian;



class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
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

    return view('pegawai.index', compact(
        'guru',
        'staff',
        'search',
        'filter'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $jabatan = Jabatan::all();

    return view('pegawai.create', compact('jabatan'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'jenis_pegawai' => 'required|in:guru,staff',
        'jabatan_id' => 'nullable|exists:jabatan,id',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string',
    ]);

    // Debug: cek data sebelum disimpan
    // dd($request->all());

    $pegawai = Pegawai::create([
    'nama' => $request->nama,
    'jenis_pegawai' => $request->jenis_pegawai,
    'jabatan_id' => $request->jabatan_id ?: null,
    'tempat_lahir' => $request->tempat_lahir,
    'tanggal_lahir' => $request->tanggal_lahir,
    'alamat' => $request->alamat,
]);

$master = MasterKomponenPenggajian::first();

if ($master) {

    if ($pegawai->jenis_pegawai == 'guru') {

        $pegawai->update([
            'tarif_per_jam' => $master->tarif_jp_guru,
            'transport'     => $master->transport_guru,
            'gaji_jabatan'  => $pegawai->jabatan_id
                                ? $master->tunjangan_jabatan
                                : 0,
        ]);

    } else {

        $pegawai->update([
            'gaji_pokok' => 0,
            'transport'  => $master->transport_staff,
        ]);

    }

}

return redirect()->route('pegawai.index')
    ->with('success', 'Data pegawai berhasil ditambahkan.');

}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    $pegawai = Pegawai::findOrFail($id);

    $jabatan = Jabatan::all();

    $jadwal = $pegawai->jadwalMengajar()->get()->keyBy('hari');

    return view('pegawai.edit', compact(
        'pegawai',
        'jabatan',
        'jadwal'
    ));
}
    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'jenis_pegawai' => 'required|in:guru,staff',
        'jabatan_id' => 'nullable|exists:jabatan,id',
        'tempat_lahir' => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
    ]);

    $pegawai = Pegawai::findOrFail($id);
    
    $pegawai->update([
    'nama' => $request->nama,
    'jenis_pegawai' => $request->jenis_pegawai,
    'jabatan_id' => $request->jabatan_id ?: null,
    'tempat_lahir' => $request->tempat_lahir,
    'tanggal_lahir' => $request->tanggal_lahir,
    'alamat' => $request->alamat,

    'tarif_per_jam' => $request->tarif_per_jam,
    'gaji_pokok' => $request->gaji_pokok,
    'transport' => $request->transport,
]);

    // ===== UPDATE JADWAL MENGAJAR (HANYA UNTUK GURU) =====
    if ($request->jenis_pegawai == 'guru') {
        // Hapus jadwal lama
        JadwalMengajar::where('pegawai_id', $pegawai->id)->delete();
        
        // Simpan jadwal baru (jika ada)
        if ($request->has('hari') && is_array($request->hari)) {
            foreach ($request->hari as $i => $hari) {
                if (
                    !empty($hari) &&
                    !empty($request->jam_mulai[$i]) &&
                    !empty($request->jam_selesai[$i]) &&
                    !empty($request->jumlah_jp[$i])
                ) {
                    JadwalMengajar::create([
                        'pegawai_id' => $pegawai->id,
                        'hari' => $hari,
                        'jam_mulai' => $request->jam_mulai[$i],
                        'jam_selesai' => $request->jam_selesai[$i],
                        'jumlah_jp' => $request->jumlah_jp[$i],
                    ]);
                }
            }
        }
    }

    return redirect()
    ->route('pegawai.index')
    ->with('success', 'Data pegawai berhasil diperbarui!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $pegawai = Pegawai::findOrFail($id);

    $pegawai->delete();

    return redirect()->route('pegawai.index')
            ->with('success','Data berhasil dihapus.');
}

}
