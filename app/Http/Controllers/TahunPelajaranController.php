<?php

namespace App\Http\Controllers;

use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    public function index()
    {
        $tahun = TahunPelajaran::latest()->get();

        return view('tahun_pelajaran.index', compact('tahun'));
    }

    public function create()
    {
        return view('tahun_pelajaran.create');
    }

   public function store(Request $request)
{
    $request->validate([
    'tahun_ajaran' => 'required',
    'semester' => 'required',
]);

    if ($request->status == 'Aktif') {

        TahunPelajaran::where('status', 'Aktif')
            ->update([
                'status' => 'Nonaktif'
            ]);

    }

TahunPelajaran::create([
    'tahun_ajaran' => $request->tahun_ajaran,
    'semester' => $request->semester,
    'status' => $request->status,
]);

    return redirect()->route('tahun-pelajaran.index')
        ->with('success', 'Tahun Pelajaran berhasil ditambahkan.');
}

    public function edit($id)
    {
        $tahun = TahunPelajaran::findOrFail($id);

        return view('tahun_pelajaran.edit', compact('tahun'));
    }

    public function update(Request $request, $id)
{
    $tahun = TahunPelajaran::findOrFail($id);

    if ($request->status == 'Aktif') {

        TahunPelajaran::where('status', 'Aktif')
            ->update([
                'status' => 'Nonaktif'
            ]);

    }

   if ($request->status == 'Aktif') {

    TahunPelajaran::where('status', 'Aktif')
        ->where('id', '!=', $tahun->id)
        ->update([
            'status' => 'Nonaktif'
        ]);

}

$tahun->update([
    'tahun_ajaran' => $request->tahun_ajaran,
    'semester' => $request->semester,
    'status' => $request->status,
]);

    return redirect()->route('tahun-pelajaran.index')
        ->with('success', 'Tahun Pelajaran berhasil diperbarui.');
}

    public function destroy($id)
    {
        TahunPelajaran::destroy($id);

        return back()->with('success', 'Data berhasil dihapus.');
    }
}