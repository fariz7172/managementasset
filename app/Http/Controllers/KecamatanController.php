<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        return view('admin.kecamatan.index', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255'
        ]);

        Kecamatan::create($request->all());
        return redirect()->route('kecamatan.index')->with('success', 'Data kecamatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255'
        ]);

        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->update($request->all());
        return redirect()->route('kecamatan.index')->with('success', 'Data kecamatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kecamatan = Kecamatan::findOrFail($id);
        $kecamatan->delete();
        return redirect()->route('kecamatan.index')->with('success', 'Data kecamatan berhasil dihapus!');
    }
}
