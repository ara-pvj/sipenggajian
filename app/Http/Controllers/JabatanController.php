<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::all();
        return view('jabatan.index', compact('jabatan'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
    'nama_jabatan' => 'required',
    'gaji_jabatan' => 'required|numeric',
]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
    'nama_jabatan' => 'required',
    'gaji_jabatan' => 'required|numeric',
]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil diubah.');
    }

    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', 'Data jabatan berhasil dihapus.');
    }
}