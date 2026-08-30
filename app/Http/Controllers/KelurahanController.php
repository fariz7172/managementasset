<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelurahan;
use App\Models\Kecamatan;

class KelurahanController extends Controller
{
    public function index()
    {
        $kelurahans = Kelurahan::with('kecamatan')->orderBy('nama_kelurahan')->get();
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        return view('admin.kelurahan.index', compact('kelurahans', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'nama_kelurahan' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10'
        ]);

        Kelurahan::create($request->all());
        return redirect()->route('kelurahan.index')->with('success', 'Data kelurahan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'nama_kelurahan' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10'
        ]);

        $kelurahan = Kelurahan::findOrFail($id);
        $kelurahan->update($request->all());
        return redirect()->route('kelurahan.index')->with('success', 'Data kelurahan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelurahan = Kelurahan::findOrFail($id);
        $kelurahan->delete();
        return redirect()->route('kelurahan.index')->with('success', 'Data kelurahan berhasil dihapus!');
    }
}
