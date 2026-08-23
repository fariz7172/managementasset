<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pompa;
use App\Imports\PompaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PompaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PompaImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data Pompa berhasil diimport dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal mengimport data: ' . $e->getMessage()]);
        }
    }
    public function index()
    {
        $pompas = Pompa::latest()->paginate(10);
        return view('admin.pompas.index', compact('pompas'));
    }

    public function create()
    {
        return view('admin.pompas.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer',
            'jenis_pompa' => 'nullable|string|max:255',
            'merk_pompa' => 'nullable|string|max:255',
            'tahun' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'status' => 'nullable|in:0,1',
            'deskripsi' => 'nullable|string',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'pompa_' . uniqid() . '.webp';
                $path = 'public/pompa/' . $filename;
                
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
                    if (!Storage::exists('public/pompa')) {
                        Storage::makeDirectory('public/pompa');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'pompa/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        Pompa::create($validated);

        return redirect()->route('admin.pompas.index')->with('success', 'Data Pompa berhasil ditambahkan!');
    }

    public function edit(Pompa $pompa)
    {
        return view('admin.pompas.form', compact('pompa'));
    }

    public function update(Request $request, Pompa $pompa)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'merk' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer',
            'jenis_pompa' => 'nullable|string|max:255',
            'merk_pompa' => 'nullable|string|max:255',
            'tahun' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'status' => 'nullable|in:0,1',
            'deskripsi' => 'nullable|string',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $photosArray = is_array($pompa->photo) ? $pompa->photo : [];

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'pompa_' . uniqid() . '.webp';
                $path = 'public/pompa/' . $filename;
                
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
                    if (!Storage::exists('public/pompa')) {
                        Storage::makeDirectory('public/pompa');
                    }
                    imagewebp($image, storage_path('app/' . $path), 80);
                    imagedestroy($image);
                    $photosArray[] = 'pompa/' . $filename;
                }
            }
        }

        $validated['photo'] = $photosArray;

        $pompa->update($validated);

        return redirect()->route('admin.pompas.index')->with('success', 'Data Pompa berhasil diperbarui!');
    }

    public function destroy(Pompa $pompa)
    {
        if (is_array($pompa->photo)) {
            foreach ($pompa->photo as $photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
        }
        $pompa->delete();

        return back()->with('success', 'Data Pompa berhasil dihapus!');
    }

    public function destroyImage(Pompa $pompa, $index)
    {
        $photos = is_array($pompa->photo) ? $pompa->photo : [];
        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
            unset($photos[$index]);
            $pompa->photo = array_values($photos);
            $pompa->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
