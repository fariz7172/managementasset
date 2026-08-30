<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['dewan', 'kecamatan', 'kelurahan'])->latest()->get();
        $dewans = \App\Models\Dewan::orderBy('nama')->get();
        $kecamatans = \App\Models\Kecamatan::orderBy('nama_kecamatan')->get();
        $kelurahans = \App\Models\Kelurahan::orderBy('nama_kelurahan')->get();
        
        return view('admin.assets.index', compact('assets', 'dewans', 'kecamatans', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->handleImageUpload($request->file('foto'));
        }

        Asset::create($data);

        return redirect()->back()->with('success', 'Data berhasil diproses ke Asset!');
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $dewans = \App\Models\Dewan::orderBy('nama')->get();
        $kecamatans = \App\Models\Kecamatan::orderBy('nama_kecamatan')->get();
        $kelurahans = \App\Models\Kelurahan::orderBy('nama_kelurahan')->get();
        
        return view('admin.assets.edit', compact('asset', 'dewans', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->handleImageUpload($request->file('foto'));

            // Hapus foto lama jika ada
            if ($asset->foto && Storage::disk('public')->exists($asset->foto)) {
                Storage::disk('public')->delete($asset->foto);
            }
        }

        $asset->update($data);
        return redirect()->route('assets.index')->with('success', 'Data Asset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        
        if ($asset->foto && Storage::disk('public')->exists($asset->foto)) {
            Storage::disk('public')->delete($asset->foto);
        }
        
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Data Asset berhasil dihapus!');
    }

    private function handleImageUpload($file)
    {
        $filename = uniqid() . '.webp';
        $image = null;
        $ext = strtolower($file->extension());
        
        if ($ext == 'png') {
            $image = @imagecreatefrompng($file->path());
        } elseif (in_array($ext, ['jpg', 'jpeg'])) {
            $image = @imagecreatefromjpeg($file->path());
        } elseif ($ext == 'webp') {
            $image = @imagecreatefromwebp($file->path());
        }

        if ($image) {
            $dir = storage_path('app/public/assets');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $path = $dir . '/' . $filename;
            imagewebp($image, $path, 80);
            imagedestroy($image);
            return 'assets/' . $filename;
        }

        // Fallback jika bukan image yg didukung GD
        return $file->storeAs('assets', $filename, 'public');
    }
}
