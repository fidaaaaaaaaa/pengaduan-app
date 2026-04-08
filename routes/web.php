<?php

use Illuminate\Support\Facades\Route;

// Langsung redirect ke Form Aspirasi (ini yang kamu mau)
Route::get('/', function () {
    return redirect()->route('aspirasi.form');
});

// Route yang sudah ada sebelumnya (biarkan tetap)
Route::get('/form-aspirasi', [App\Http\Controllers\InputAspirasiController::class, 'index'])
     ->name('aspirasi.form');

Route::post('/form-aspirasi', [App\Http\Controllers\InputAspirasiController::class, 'store'])
     ->name('aspirasi.store');

// Form Aspirasi Siswa
Route::get('/form-aspirasi', [App\Http\Controllers\InputAspirasiController::class, 'index'])
     ->name('aspirasi.form');

Route::post('/form-aspirasi', [App\Http\Controllers\InputAspirasiController::class, 'store'])
     ->name('aspirasi.store');

     // ==================== ADMIN ROUTES ====================
Route::get('/admin/login', [App\Http\Controllers\AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'login']);

Route::middleware('web')->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/feedback/{id_pelaporan}', [App\Http\Controllers\AdminController::class, 'updateFeedback'])->name('admin.feedback');
    Route::get('/admin/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});

// ==================== SISWA HISTORI ====================
Route::get('/histori-aspirasi', [App\Http\Controllers\SiswaController::class, 'histori'])
     ->name('siswa.histori');