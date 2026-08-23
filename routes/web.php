<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AppPortalController;
use App\Http\Controllers\Admin\PompaController;
use App\Http\Controllers\Admin\MonitoringController;
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
                
    $pintuAirCount = \App\Models\PintuAir::count();
    $pompaCount = \App\Models\Pompa::count();
    $portalCount = \App\Models\AppPortal::count();

    return view('welcome', compact('portals', 'articles', 'pintuAirCount', 'pompaCount', 'portalCount'));
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

Route::get('/peta-pemantauan', [MonitoringController::class, 'publicMap'])->name('public.map');
Route::get('/peta-reses', [\App\Http\Controllers\Admin\MonitoringResesController::class, 'publicMap'])->name('public.map.reses');

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

    Route::get('admin/monitoring', [\App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('admin.monitoring.index');
    Route::get('admin/monitoring-reses', [\App\Http\Controllers\Admin\MonitoringResesController::class, 'index'])->name('admin.monitoring-reses.index');
    Route::get('admin/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');

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

    Route::post('admin/pompas/import', [PompaController::class, 'import'])->name('admin.pompas.import');
    Route::resource('admin/pompas', PompaController::class)->names([
        'index' => 'admin.pompas.index',
        'create' => 'admin.pompas.create',
        'store' => 'admin.pompas.store',
        'show' => 'admin.pompas.show',
        'edit' => 'admin.pompas.edit',
        'update' => 'admin.pompas.update',
        'destroy' => 'admin.pompas.destroy',
    ]);
    Route::delete('admin/pompas/image/{pompa}/{index}', [PompaController::class, 'destroyImage'])->name('admin.pompas.image.destroy');

    Route::post('admin/sub-polders/import', [\App\Http\Controllers\Admin\SubPolderController::class, 'import'])->name('admin.sub-polders.import');
    Route::resource('admin/sub-polders', \App\Http\Controllers\Admin\SubPolderController::class)->names([
        'index' => 'admin.sub-polders.index',
        'create' => 'admin.sub-polders.create',
        'store' => 'admin.sub-polders.store',
        'show' => 'admin.sub-polders.show',
        'edit' => 'admin.sub-polders.edit',
        'update' => 'admin.sub-polders.update',
        'destroy' => 'admin.sub-polders.destroy',
    ]);
    Route::delete('admin/sub-polders/image/{subPolder}/{index}', [\App\Http\Controllers\Admin\SubPolderController::class, 'destroyImage'])->name('admin.sub-polders.image.destroy');

    Route::post('admin/pompa-mobiles/import', [\App\Http\Controllers\Admin\PompaMobileController::class, 'import'])->name('admin.pompa-mobiles.import');
    Route::resource('admin/pompa-mobiles', \App\Http\Controllers\Admin\PompaMobileController::class)->names([
        'index' => 'admin.pompa-mobiles.index',
        'create' => 'admin.pompa-mobiles.create',
        'store' => 'admin.pompa-mobiles.store',
        'show' => 'admin.pompa-mobiles.show',
        'edit' => 'admin.pompa-mobiles.edit',
        'update' => 'admin.pompa-mobiles.update',
        'destroy' => 'admin.pompa-mobiles.destroy',
    ]);
    Route::delete('admin/pompa-mobiles/image/{pompaMobile}/{index}', [\App\Http\Controllers\Admin\PompaMobileController::class, 'destroyImage'])->name('admin.pompa-mobiles.image.destroy');

    Route::post('admin/pintu-airs/import', [\App\Http\Controllers\Admin\PintuAirController::class, 'import'])->name('admin.pintu-airs.import');
    Route::resource('admin/pintu-airs', \App\Http\Controllers\Admin\PintuAirController::class)->names([
        'index' => 'admin.pintu-airs.index',
        'create' => 'admin.pintu-airs.create',
        'store' => 'admin.pintu-airs.store',
        'show' => 'admin.pintu-airs.show',
        'edit' => 'admin.pintu-airs.edit',
        'update' => 'admin.pintu-airs.update',
        'destroy' => 'admin.pintu-airs.destroy',
    ]);
    Route::delete('admin/pintu-airs/image/{pintuAir}/{index}', [\App\Http\Controllers\Admin\PintuAirController::class, 'destroyImage'])->name('admin.pintu-airs.image.destroy');

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
