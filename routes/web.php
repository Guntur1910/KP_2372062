<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\KainController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\JenisMotifController;
use App\Http\Controllers\TarikanVisualController;
use App\Http\Controllers\SimetrisController;

// Guest Routes
Route::get('/', [KainController::class, 'index'])->name('user.home');
Route::get('/kain/{id}', [KainController::class, 'show'])->name('kain.show');

// Admin Auth
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [KainController::class, 'adminIndex'])->name('dashboard');
        Route::get('/kain/{id}/detail', [KainController::class, 'adminShow'])->name('kain.detail');
        Route::resource('kain', KainController::class)->except(['show']);
        Route::resource('motif', MotifController::class);
        Route::resource('jenis-motif', JenisMotifController::class)->except(['show']);
        Route::resource('tarikan-visual', TarikanVisualController::class)->except(['show']);
        Route::resource('simetris', SimetrisController::class)->except(['show']);
    }); 
});
