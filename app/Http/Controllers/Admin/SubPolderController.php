<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubPolder;
use App\Imports\SubPolderImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubPolderController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new SubPolderImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data Sub Polder berhasil diimport dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengimport data: ' . $e->getMessage()]);
        }
    }
    
    public function index()
    {
        $subPolders = SubPolder::latest()->paginate(10);
        return view('admin.sub_polders.index', compact('subPolders'));
    }

    public function create()
    {
        return view('admin.sub_polders.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'nullable|string|max:255',
            'jumlah_unit' => 'nullable|integer',
            'total_kapasitas' => 'nullable|numeric',
            'jenis_pompa' => 'nullable|string|max:255',
            'merk_pompa' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1',
            'deskripsi' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'subpolder_' . uniqid() . '.webp';
                $path = 'public/subpolder/' . $filename;
                
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
                    if (!Storage::exists('public/subpolder')) {
                        Storage::makeDirectory('public/subpolder');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'subpolder/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        SubPolder::create($validated);

        return redirect()->route('admin.sub-polders.index')->with('success', 'Data Sub Polder berhasil ditambahkan!');
    }

    public function edit(SubPolder $subPolder)
    {
        return view('admin.sub_polders.form', compact('subPolder'));
    }

    public function update(Request $request, SubPolder $subPolder)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'nullable|string|max:255',
            'jumlah_unit' => 'nullable|integer',
            'total_kapasitas' => 'nullable|numeric',
            'jenis_pompa' => 'nullable|string|max:255',
            'merk_pompa' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'status' => 'nullable|in:0,1',
            'deskripsi' => 'nullable|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = is_array($subPolder->photo) ? $subPolder->photo : [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'subpolder_' . uniqid() . '.webp';
                $path = 'public/subpolder/' . $filename;
                
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
                    if (!Storage::exists('public/subpolder')) {
                        Storage::makeDirectory('public/subpolder');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'subpolder/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        $subPolder->update($validated);

        return redirect()->route('admin.sub-polders.index')->with('success', 'Data Sub Polder berhasil diperbarui!');
    }

    public function destroy(SubPolder $subPolder)
    {
        if (is_array($subPolder->photo)) {
            foreach ($subPolder->photo as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }
        $subPolder->delete();

        return back()->with('success', 'Data Sub Polder berhasil dihapus!');
    }

    public function destroyImage(SubPolder $subPolder, $index)
    {
        $photos = is_array($subPolder->photo) ? $subPolder->photo : [];
        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
            unset($photos[$index]);
            $subPolder->photo = array_values($photos);
            $subPolder->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
