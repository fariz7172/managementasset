<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PintuAir;
use App\Imports\PintuAirImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PintuAirController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PintuAirImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data Pintu Air berhasil diimport dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengimport data: ' . $e->getMessage()]);
        }
    }
    
    public function index()
    {
        $pintuAirs = PintuAir::latest()->paginate(10);
        return view('admin.pintu_airs.index', compact('pintuAirs'));
    }

    public function create()
    {
        return view('admin.pintu_airs.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'google_map' => 'nullable|string|max:255',
            'koordinat' => 'nullable|string|max:255',
            'tahun_pekerjaan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'jumlah_pintu' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'kib_d' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'pintuair_' . uniqid() . '.webp';
                $path = 'public/pintuair/' . $filename;
                
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
                    if (!Storage::exists('public/pintuair')) {
                        Storage::makeDirectory('public/pintuair');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'pintuair/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        PintuAir::create($validated);

        return redirect()->route('admin.pintu-airs.index')->with('success', 'Data Pintu Air berhasil ditambahkan!');
    }

    public function edit(PintuAir $pintuAir)
    {
        return view('admin.pintu_airs.form', compact('pintuAir'));
    }

    public function update(Request $request, PintuAir $pintuAir)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'google_map' => 'nullable|string|max:255',
            'koordinat' => 'nullable|string|max:255',
            'tahun_pekerjaan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'jumlah_pintu' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'kib_d' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = is_array($pintuAir->photo) ? $pintuAir->photo : [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'pintuair_' . uniqid() . '.webp';
                $path = 'public/pintuair/' . $filename;
                
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
                    if (!Storage::exists('public/pintuair')) {
                        Storage::makeDirectory('public/pintuair');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'pintuair/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        $pintuAir->update($validated);

        return redirect()->route('admin.pintu-airs.index')->with('success', 'Data Pintu Air berhasil diperbarui!');
    }

    public function destroy(PintuAir $pintuAir)
    {
        if (is_array($pintuAir->photo)) {
            foreach ($pintuAir->photo as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }
        $pintuAir->delete();

        return back()->with('success', 'Data Pintu Air berhasil dihapus!');
    }

    public function destroyImage(PintuAir $pintuAir, $index)
    {
        $photos = is_array($pintuAir->photo) ? $pintuAir->photo : [];
        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
            unset($photos[$index]);
            $pintuAir->photo = array_values($photos);
            $pintuAir->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
