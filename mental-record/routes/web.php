<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\SymptomController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientChartPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// ログイン
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// ログイン必須
Route::middleware('auth')->group(function () {

    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // クライエントページ
    Route::resource('clients', ClientController::class);

    // 病名ページ
    Route::resource('diseases', DiseaseController::class)->except(['show']);

    // 症状ページ
    Route::resource('symptoms', SymptomController::class)->except(['show']);

    // 薬品ページ
    Route::resource('medicines', MedicineController::class)->except(['show']);

    // カルテ処理
    Route::post('/clients/{client}/records', [RecordController::class, 'store'])->name('records.store');
    Route::post('/clients/{client}/records/{record}/delete', [RecordController::class, 'destroy'])->name('records.destroy');
    Route::post('/clients/{client}/records/{record}/images/{image}/delete', [RecordController::class, 'destroyImage'])->name('records.images.destroy');
    Route::get('/clients/{client}/records/{record}/images/{image}/download', [RecordController::class, 'downloadImage'])->name('records.images.download');

    // カルテ簡易パスワード
    Route::post('/clients/{client}/chart-auth', [ClientChartPasswordController::class, 'store'])
        ->name('clients.chart.auth');
});