<?php

use App\Http\Controllers\CutiController;
use App\Models\User;
use Hamcrest\Core\Set;
use App\Models\HariLibur;
use App\Models\CutiTahunan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\CutiTahunanController;
use App\Http\Controllers\SetupAplikasiController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('users/atasan', [UserController::class, 'listAtasan'])->name('users.list-atasan');
    Route::resource('users', UserController::class);
    Route::resource('divisi', DivisiController::class);
    Route::resource('cuti-tahunan', CutiTahunanController::class);
    Route::resource('setup-aplikasi', SetupAplikasiController::class)->except(['destroy']);
    Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan.'], function () {
        Route::get('cuti/hitung-cuti', [CutiController::class, 'hitungCuti'])->name('cuti.hitung-cuti');
        Route::resource('cuti', CutiController::class);
    });
    Route::resource('hari-libur', HariLiburController::class)->except(['destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
