<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\PesananController as SiswaPesanan;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Penjual\LaporanController;
use App\Http\Controllers\Siswa\MenuController;
use App\Http\Controllers\Penjual\DashboardController;
use App\Http\Controllers\Penjual\PesananController;
use App\Http\Controllers\Penjual\StokController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KantinController;
use App\Http\Controllers\Auth\ForgotPasswordSiswaController;
use App\Http\Controllers\Siswa\ProfileController;
use Illuminate\Support\Facades\Route;

// ══════════════════════════════════════════════════════════
//  ROOT REDIRECT
// ══════════════════════════════════════════════════════════

Route::get('/', function () {
    if (auth('web')->check())     return redirect()->route('siswa.dashboard');
    if (auth('penjual')->check()) return redirect()->route('penjual.dashboard');
    if (auth('admin')->check())   return redirect()->route('admin.dashboard');
    return redirect()->route('login');
});

// ══════════════════════════════════════════════════════════
//  AUTH ROUTES (guest only)
// ══════════════════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('/login',          [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login/penjual',  [AuthController::class, 'showLoginPenjual'])->name('login.penjual');
    Route::get('/register',       [AuthController::class, 'showRegister'])->name('register');
});

Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ══════════════════════════════════════════════════════════
//  LUPA PASSWORD SISWA (publik, tanpa auth)
// ══════════════════════════════════════════════════════════

Route::get('/lupa-password',           [ForgotPasswordSiswaController::class, 'index'])->name('forgot-password.index');
Route::post('/lupa-password/verifikasi', [ForgotPasswordSiswaController::class, 'verifikasi'])->name('forgot-password.verifikasi');
Route::post('/lupa-password/reset',    [ForgotPasswordSiswaController::class, 'reset'])->name('forgot-password.reset');

// ══════════════════════════════════════════════════════════
//  SISWA ROUTES
// ══════════════════════════════════════════════════════════

Route::middleware('auth.siswa')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',         [SiswaDashboard::class, 'index'])->name('dashboard');
    Route::get('/kantin/{id}/menu',  [MenuController::class, 'pilihMenu'])->name('pilih.menu');
    Route::post('/pesanan',          [MenuController::class, 'store'])->name('pesanan.store');

    // ─── Profile ───────────────────────────────────────
    Route::get('/profile',           [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile',           [ProfileController::class, 'update'])->name('profile.update');
});

// ══════════════════════════════════════════════════════════
//  PENJUAL ROUTES
// ══════════════════════════════════════════════════════════

Route::middleware('auth.penjual')->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard',              [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan',                [LaporanController::class, 'index'])->name('laporan');
    Route::patch('/pesanan/{id}/status',  [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // === STOK / MENU ===
    Route::post  ('/stok',                [StokController::class, 'store'])->name('stok.store');
    Route::put   ('/stok/{id}',           [StokController::class, 'editUpdate'])->name('stok.editUpdate');
    Route::delete('/stok/{id}',           [StokController::class, 'destroy'])->name('stok.destroy');
    Route::patch ('/stok/{id}',           [StokController::class, 'update'])->name('stok.update');
    Route::patch ('/stok/{id}/available', [StokController::class, 'toggleAvailable'])->name('stok.toggleAvailable');
    Route::post  ('/stok/{id}/foto',      [StokController::class, 'uploadFoto'])->name('stok.uploadFoto');
});

// ══════════════════════════════════════════════════════════
//  ADMIN AUTH (guest)
// ══════════════════════════════════════════════════════════

Route::get('/login/admin',  [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login/admin', [AdminAuthController::class, 'login'])->name('admin.login.post');

// ══════════════════════════════════════════════════════════
//  ADMIN ROUTES (protected)
// ══════════════════════════════════════════════════════════

Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // ─── Kelola Siswa ──────────────────────────────────────
    Route::resource('siswa', SiswaController::class)
        ->except(['create', 'store']);

    Route::patch('siswa/{id}/toggle',
        [SiswaController::class, 'toggle']
    )->name('siswa.toggle');

    Route::patch('siswa/{id}/reset-password',
        [SiswaController::class, 'resetPassword']
    )->name('siswa.reset-password');

    // ─── Kelola Kantin ─────────────────────────────────────
    Route::resource('kantin', KantinController::class);
    Route::patch('kantin/{kantin}/toggle-status', [KantinController::class, 'toggleStatus'])->name('kantin.toggleStatus');

    // ─── Menu, Order, User ─────────────────────────────────
    Route::resource('menus', AdminMenuController::class);

    Route::resource('orders', AdminOrderController::class)
        ->only(['index', 'show', 'update']);

    Route::patch('orders/{order}/status',
        [AdminOrderController::class, 'updateStatus']
    )->name('orders.status');

    Route::resource('users', AdminUserController::class)
        ->only(['index', 'show', 'destroy']);

    // ─── Laporan ───────────────────────────────────────────
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan');
});