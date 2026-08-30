<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\ApiPaymentController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\DewanController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return redirect('/admin/dashboard');
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    Route::get('/admin/akses', [DashboardController::class, 'akses']);
    Route::get('/admin/backup-db', [DashboardController::class, 'backupDb'])->name('admin.backup');

    Route::post('/admin/api-payments/sync', [ApiPaymentController::class, 'store']);

    Route::resource('/admin/kecamatan', KecamatanController::class)->except(['create', 'show', 'edit']);
    Route::resource('/admin/kelurahan', KelurahanController::class)->except(['create', 'show', 'edit']);
    Route::resource('/admin/dewan', DewanController::class)->except(['create', 'show', 'edit']);

    Route::resource('/admin/assets', \App\Http\Controllers\AssetController::class)->except(['create', 'show']);
    Route::get('/admin/sensus/export-pdf', [\App\Http\Controllers\PendataanSensusController::class, 'exportPdf'])->name('sensus.export-pdf');
    Route::post('/admin/sensus/import', [\App\Http\Controllers\PendataanSensusController::class, 'import'])->name('sensus.import');
    Route::resource('/admin/sensus', \App\Http\Controllers\PendataanSensusController::class)->parameters([
        'sensus' => 'sensus'
    ]);
});
