<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PompaMobile;
use App\Imports\PompaMobileImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PompaMobileController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PompaMobileImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data Pompa Mobile berhasil diimport dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengimport data: ' . $e->getMessage()]);
        }
    }
    
    public function index()
    {
        $pompaMobiles = PompaMobile::latest()->paginate(10);
        return view('admin.pompa_mobiles.index', compact('pompaMobiles'));
    }

    public function create()
    {
        return view('admin.pompa_mobiles.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasi' => 'nullable|string|max:255',
            'jenis_type' => 'nullable|string|max:255',
            'no_seri_plat' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:255',
            'kewenangan' => 'nullable|string|max:255',
            'total' => 'nullable|integer',
            'baik' => 'nullable|integer',
            'rusak' => 'nullable|integer',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'nullable|in:0,1',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'pompamobile_' . uniqid() . '.webp';
                $path = 'public/pompamobile/' . $filename;
                
                $image = null;
                if ($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') {
                    $image = imagecreatefromjpeg($file->getRealPath());
                } elseif ($file->getClientOriginalExtension() == 'png') {
                    $image = imagecreatefrompng($file->getRealPath());
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }

                if ($image) {
                    if (!Storage::exists('public/pompamobile')) {
                        Storage::makeDirectory('public/pompamobile');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'pompamobile/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        PompaMobile::create($validated);

        return redirect()->route('admin.pompa-mobiles.index')->with('success', 'Data Pompa Mobile berhasil ditambahkan!');
    }

    public function edit(PompaMobile $pompaMobile)
    {
        return view('admin.pompa_mobiles.form', compact('pompaMobile'));
    }

    public function update(Request $request, PompaMobile $pompaMobile)
    {
        $validated = $request->validate([
            'lokasi' => 'nullable|string|max:255',
            'jenis_type' => 'nullable|string|max:255',
            'no_seri_plat' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:255',
            'kewenangan' => 'nullable|string|max:255',
            'total' => 'nullable|integer',
            'baik' => 'nullable|integer',
            'rusak' => 'nullable|integer',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'nullable|in:0,1',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = is_array($pompaMobile->photo) ? $pompaMobile->photo : [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'pompamobile_' . uniqid() . '.webp';
                $path = 'public/pompamobile/' . $filename;
                
                $image = null;
                if ($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') {
                    $image = imagecreatefromjpeg($file->getRealPath());
                } elseif ($file->getClientOriginalExtension() == 'png') {
                    $image = imagecreatefrompng($file->getRealPath());
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }

                if ($image) {
                    if (!Storage::exists('public/pompamobile')) {
                        Storage::makeDirectory('public/pompamobile');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'pompamobile/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        $pompaMobile->update($validated);

        return redirect()->route('admin.pompa-mobiles.index')->with('success', 'Data Pompa Mobile berhasil diperbarui!');
    }

    public function destroy(PompaMobile $pompaMobile)
    {
        if (is_array($pompaMobile->photo)) {
            foreach ($pompaMobile->photo as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }
        $pompaMobile->delete();

        return back()->with('success', 'Data Pompa Mobile berhasil dihapus!');
    }

    public function destroyImage(PompaMobile $pompaMobile, $index)
    {
        $photos = is_array($pompaMobile->photo) ? $pompaMobile->photo : [];
        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
            unset($photos[$index]);
            $pompaMobile->photo = array_values($photos);
            $pompaMobile->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
