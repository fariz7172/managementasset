<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppPortal;
use App\Models\AppPortalImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AppPortalController extends Controller
{
    public function index()
    {
        $portals = AppPortal::latest()->paginate(10);
        return view('admin.portals.index', compact('portals'));
    }

    public function show(AppPortal $portal)
    {
        return view('admin.portals.show', compact('portal'));
    }

    public function create()
    {
        return view('admin.portals.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $slug = Str::slug($request->title) . '-' . uniqid();

        $portal = AppPortal::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->content, // Mapping form content to description
            'url' => $request->url,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('portals', 'public');
                $portal->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.portals.index')->with('success', 'Portal Aplikasi berhasil ditambahkan!');
    }

    public function edit(AppPortal $portal)
    {
        return view('admin.portals.form', compact('portal'));
    }

    public function update(Request $request, AppPortal $portal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'url' => 'nullable|url',
            'status' => 'required|in:draft,published',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $portal->update([
            'title' => $request->title,
            'description' => $request->content, // Mapping form content to description
            'url' => $request->url,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('portals', 'public');
                $portal->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.portals.index')->with('success', 'Portal Aplikasi berhasil diperbarui!');
    }

    public function destroy(AppPortal $portal)
    {
        foreach ($portal->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $portal->delete();

        return back()->with('success', 'Portal Aplikasi berhasil dihapus!');
    }
    
    public function destroyImage(AppPortalImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        
        return response()->json(['success' => true]);
    }
}
