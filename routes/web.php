<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware(['auth', 'check.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', Admin\CategoryWebController::class)->except(['show']);
        Route::resource('locations', Admin\LocationWebController::class)->except(['show']);
        Route::resource('units', Admin\UnitWebController::class)->except(['show']);
        Route::resource('products', Admin\ProductWebController::class)->except(['show']);
        Route::resource('recipes', Admin\RecipeWebController::class)->except(['show']);
        Route::resource('users', Admin\UserWebController::class)->except(['show']);
        Route::resource('stock', Admin\StockWebController::class)->except(['show']);
    });


require __DIR__ . '/auth.php';