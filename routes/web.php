<?php

use App\Models\Izin;
use App\Models\User;
use Hamcrest\Core\Set;
use App\Models\HariLibur;
use App\Models\CutiTahunan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisiController;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\CutiApproveController;
use App\Http\Controllers\CutiTahunanController;
use App\Http\Controllers\IzinApproveController;
use App\Http\Controllers\LaporanCutiController;
use App\Http\Controllers\LaporanIzinController;
use App\Http\Controllers\NotificationController;
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
    Route::resource('hari-libur', HariLiburController::class)->except(['destroy']);
    Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan.'], function () {
        Route::get('cuti/approve/{cuti:uuid}', [CutiApproveController::class, 'show'])->name('cuti.approve.show');
        Route::put('cuti/approve/{cuti:uuid}', [CutiApproveController::class, 'storeApprove'])->name('cuti.approve.store');
        Route::get('cuti/hitung-cuti', [CutiController::class, 'hitungCuti'])->name('cuti.hitung-cuti');
        
        Route::resource('cuti', CutiController::class);
        Route::get('cuti/{cuti:uuid}/generate-pdf', [CutiController::class, 'generatePDF'])->name('cuti.generatePDF'); // GENERATE PDF
        
        Route::get('izin/approve/{izin:uuid}', [IzinApproveController::class, 'show'])->name('izin.approve.show');
        Route::put('izin/approve/{izin:uuid}', [IzinApproveController::class, 'storeApprove'])->name('izin.approve.store');
        Route::get('izin/hitung-izin', [IzinController::class, 'hitungIzin'])->name('izin.hitung-izin');
        Route::resource('izin', IzinController::class);
    });
    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function() {
        Route::get('cuti', LaporanCutiController::class);
        Route::get('cuti/export', [LaporanCutiController::class, 'export'])->name('cuti.export');
        Route::get('izin', LaporanIzinController::class);
    });
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
