<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AkunController extends Controller
{
    /**
     * Menampilkan daftar akun guru dan staff.
     */
    public function index()
    {
        $akun = User::with('pegawai')
            ->whereIn('role', ['guru', 'staff'])
            ->orderBy('name')
            ->get();

        return view('akun.index', compact('akun'));
    }

    /**
     * Menampilkan form pembuatan akun.
     */
    public function create(Request $request)
{
    $pegawai = Pegawai::whereDoesntHave('user')->get();

    $pegawaiDipilih = null;

    if ($request->pegawai_id) {
        $pegawaiDipilih = Pegawai::whereDoesntHave('user')
            ->findOrFail($request->pegawai_id);
    }

    return view('akun.create', compact('pegawai', 'pegawaiDipilih'));
}

    /**
     * Menyimpan akun baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $pegawai = Pegawai::findOrFail($request->pegawai_id);

        if ($pegawai->user) {
            return back()->withErrors([
                'pegawai_id' => 'Pegawai ini sudah memiliki akun.'
            ]);
        }

        User::create([
            'pegawai_id' => $pegawai->id,
            'name' => $pegawai->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $pegawai->jenis_pegawai,
        ]);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    /**
     * Menampilkan form edit akun.
     */
    public function edit(string $id)
    {
        $akun = User::with('pegawai')->findOrFail($id);

        return view('akun.edit', compact('akun'));
    }

    /**
     * Memperbarui akun.
     */
    public function update(Request $request, string $id)
    {
        $akun = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $akun->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $akun->email = $request->email;

        if ($request->filled('password')) {
            $akun->password = Hash::make($request->password);
        }

        $akun->save();

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Menghapus akun.
     */
    public function destroy(string $id)
    {
        $akun = User::findOrFail($id);

        $akun->delete();

        return redirect()
            ->route('akun.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}