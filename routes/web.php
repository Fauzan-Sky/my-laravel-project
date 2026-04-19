<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\PesananController as SiswaPesanan;
use App\Http\Controllers\Penjual\DashboardController;
use App\Http\Controllers\Penjual\PesananController;
use App\Http\Controllers\Penjual\StokController;
use App\Http\Controllers\Siswa\MenuController;
use App\Http\Controllers\Admin\SlotController; // ← tambah ini
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════
//  AUTH ROUTES
// ══════════════════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('/login',        [AuthController::class, 'showLogin'])->name('login');
    Route::get('login/penjual', [AuthController::class, 'showLoginPenjual'])->name('login.penjual');
    Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
});

Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════════════════
//  SISWA ROUTES
// ══════════════════════════════════════════════════════════

Route::middleware('auth.siswa')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',        [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::get('/kantin/{id}/menu', [MenuController::class, 'pilihMenu'])->name('pilih.menu');
    Route::post('/pesanan',         [MenuController::class, 'store'])->name('pesanan.store');
});

// ══════════════════════════════════════════════════════════
//  PENJUAL ROUTES
// ══════════════════════════════════════════════════════════

Route::middleware('auth.penjual')->prefix('penjual')->name('penjual.')->group(function () {

    Route::get('/dashboard',             [DashboardController::class, 'index'])->name('dashboard');

    Route::patch('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    Route::patch('/stok/{id}',           [StokController::class, 'update'])->name('stok.update');
    Route::patch('/stok/{id}/available', [StokController::class, 'toggleAvailable'])->name('stok.toggleAvailable');
    Route::post('/stok/{id}/foto',       [StokController::class, 'uploadFoto'])->name('stok.uploadFoto');

});

// ══════════════════════════════════════════════════════════
//  ADMIN ROUTES
// ══════════════════════════════════════════════════════════

Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Slot Jadwal ← tambah ini
    Route::get('/slot',               [SlotController::class, 'index'])->name('slot.index');
    Route::post('/slot',              [SlotController::class, 'store'])->name('slot.store');
    Route::patch('/slot/{id}/toggle', [SlotController::class, 'toggle'])->name('slot.toggle');
    Route::delete('/slot/{id}',       [SlotController::class, 'destroy'])->name('slot.destroy');

});

// ══════════════════════════════════════════════════════════
//  ROOT REDIRECT
// ══════════════════════════════════════════════════════════

Route::get('/', function () {
    if (auth('web')->check())     return redirect()->route('siswa.dashboard');
    if (auth('penjual')->check()) return redirect()->route('penjual.dashboard');
    if (auth('admin')->check())   return redirect()->route('admin.dashboard');
    return redirect()->route('login');
});