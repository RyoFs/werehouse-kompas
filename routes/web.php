<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // PROFILE (setting user yang sedang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // USER MANAGEMENT (admin)
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/users', [UserController::class, 'store'])->name('user.store');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');
    Route::post('/alat', [AlatController::class, 'store'])->name('alat.store');
    Route::put('/alat/{id}', [AlatController::class, 'update'])->name('alat.update');
    Route::get('/alat/backup', [AlatController::class, 'backup'])->name('alat.backup');
    Route::post('/alat/import', [AlatController::class, 'import'])->name('alat.import');
    Route::get('/alat/export', [AlatController::class, 'export'])->name('alat.export');
    Route::get('/alat/template/download', [AlatController::class, 'downloadTemplate'])->name('alat.template.download');
    Route::delete('/alat{id}', [AlatController::class, 'destroy'])->name('alat.destroy');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::get('/alat/search', [PeminjamanController::class, 'search'])->name('alat.search');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::get('/peminjaman/export', [PeminjamanController::class, 'export'])->name('peminjaman.export');
    Route::get('/peminjaman/backup', [PeminjamanController::class, 'backup'])->name('peminjaman.backup');
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});


require __DIR__.'/auth.php';
