<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AppPortalController;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $portals = \App\Models\AppPortal::where('status', 'published')
                ->with('images')
                ->latest()
                ->take(3)
                ->get();
                
    $articles = \App\Models\Article::where('status', 'published')
                ->with('images')
                ->latest('activity_date')
                ->take(3)
                ->get();

    return view('welcome', compact('portals', 'articles'));
});

Route::get('/kaleidoskop', function () {
    $articles = \App\Models\Article::where('status', 'published')
                ->with('images')
                ->latest('activity_date')
                ->paginate(12);
    return view('kaleidoskop', compact('articles'));
})->name('kaleidoskop');

Route::get('/portal', function () {
    $portals = \App\Models\AppPortal::where('status', 'published')
                ->with('images')
                ->latest()
                ->get();
    return view('portal', compact('portals'));
})->name('portal');

Route::get('/kegiatan/{article:slug}', function (\App\Models\Article $article) {
    if ($article->status !== 'published') {
        abort(404);
    }
    return view('articles.show', compact('article'));
})->name('articles.show');

Route::get('/portal/{portal:slug}', function (\App\Models\AppPortal $portal) {
    if ($portal->status !== 'published') {
        abort(404);
    }
    return view('portals.show', compact('portal'));
})->name('portals.show');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        $articleCount = \App\Models\Article::count();
        $portalCount = \App\Models\AppPortal::count();
        $imageCount = \App\Models\ArticleImage::count() + \App\Models\AppPortalImage::count();
        
        $recentArticles = \App\Models\Article::latest()->take(5)->get();
        $recentPortals = \App\Models\AppPortal::latest()->take(5)->get();

        $weather = null;
        try {
            // Latitude & Longitude for Jakarta Utara
            $response = Http::timeout(3)->get('https://api.open-meteo.com/v1/forecast?latitude=-6.1384&longitude=106.8837&current_weather=true&timezone=Asia%2FJakarta');
            if ($response->successful()) {
                $weather = $response->json()['current_weather'] ?? null;
            }
        } catch (\Exception $e) {
            // Silently fail if API is down
        }

        return view('admin.dashboard', compact('articleCount', 'portalCount', 'imageCount', 'recentArticles', 'recentPortals', 'weather'));
    })->name('admin.dashboard');

    Route::resource('admin/articles', ArticleController::class)->names([
        'index' => 'admin.articles.index',
        'create' => 'admin.articles.create',
        'store' => 'admin.articles.store',
        'show' => 'admin.articles.show',
        'edit' => 'admin.articles.edit',
        'update' => 'admin.articles.update',
        'destroy' => 'admin.articles.destroy',
    ]);
    
    Route::delete('admin/articles/image/{image}', [ArticleController::class, 'destroyImage'])->name('admin.articles.image.destroy');
    Route::post('admin/articles/upload-image', [ArticleController::class, 'uploadEditorImage'])->name('admin.articles.uploadImage');

    Route::resource('admin/portals', AppPortalController::class)->names([
        'index' => 'admin.portals.index',
        'create' => 'admin.portals.create',
        'store' => 'admin.portals.store',
        'show' => 'admin.portals.show',
        'edit' => 'admin.portals.edit',
        'update' => 'admin.portals.update',
        'destroy' => 'admin.portals.destroy',
    ]);
    Route::delete('admin/portals/image/{image}', [AppPortalController::class, 'destroyImage'])->name('admin.portals.image.destroy');
});
