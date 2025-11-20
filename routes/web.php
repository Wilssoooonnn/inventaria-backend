<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. RUTE DEFAULT & AUTH (Umum)
// =========================================================================

// Redirect halaman root. Jika user login, arahkan ke dashboard.
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login'); // Arahkan ke halaman login Breeze jika belum login
});

// Redirect user yang sudah login (role apapun) ke dashboard admin
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});


// =========================================================================
// 2. RUTE WEB ADMIN (Dilindungi Otorisasi F&B)
// =========================================================================

Route::middleware(['auth', 'check.admin'])
    ->prefix('admin') // URL: /admin/...
    ->name('admin.')  // Nama: admin....
    ->group(function () {

        // --- 2.1 DASHBOARD ADMIN ---
        // Route yang disukai Laravel untuk redirect setelah login
        Route::view('/dashboard', 'admin.dashboard.index')->name('dashboard');
        Route::view('/test', 'admin.dashboard.test')->name('test');


        // --- 2.2 RESOURCE CRUD ROUTES (Fase 4 Master Data) ---
    
        // Manajemen Satuan Unit
        Route::resource('units', Admin\UnitWebController::class)->except(['show']);

        // // Manajemen Produk (Menu & Bahan Baku)
        Route::resource('products', Admin\ProductWebController::class)->except(['show']);

        // // Manajemen Resep (Recipe)
        Route::resource('recipes', Admin\RecipeWebController::class)->except(['show']);

    });


// =========================================================================
// 3. RUTE AUTH BREEZE (Login, Register, Logout)
// =========================================================================

// File ini berisi rute login, register, dan logout POST yang diperlukan.
require __DIR__ . '/auth.php';