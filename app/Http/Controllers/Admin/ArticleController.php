<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function create()
    {
        return view('admin.articles.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'activity_date' => 'required|date',
            'status' => 'required|in:draft,published',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $slug = Str::slug($request->title) . '-' . uniqid();

        $article = Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'activity_date' => $request->activity_date,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel kegiatan berhasil ditambahkan!');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'activity_date' => 'required|date',
            'status' => 'required|in:draft,published',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'activity_date' => $request->activity_date,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel kegiatan berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        foreach ($article->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
    
    public function destroyImage(ArticleImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function uploadEditorImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('articles/editor', 'public');
            
            return response()->json([
                'url' => Storage::url($path)
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
