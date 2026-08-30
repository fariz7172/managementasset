<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dewan;

class DewanController extends Controller
{
    public function index()
    {
        $dewans = Dewan::orderBy('nama')->get();
        return view('admin.dewan.index', compact('dewans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'komisi' => 'nullable|string|max:255',
            'fraksi' => 'nullable|string|max:255',
        ]);

        Dewan::create($request->all());
        return redirect()->route('dewan.index')->with('success', 'Data dewan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'komisi' => 'nullable|string|max:255',
            'fraksi' => 'nullable|string|max:255',
        ]);

        $dewan = Dewan::findOrFail($id);
        $dewan->update($request->all());
        return redirect()->route('dewan.index')->with('success', 'Data dewan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dewan = Dewan::findOrFail($id);
        $dewan->delete();
        return redirect()->route('dewan.index')->with('success', 'Data dewan berhasil dihapus!');
    }
}
