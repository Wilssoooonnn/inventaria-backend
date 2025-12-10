<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Import Controllers ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StockAdjustmentController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SalesController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/units', [UnitController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/scan', [ProductController::class, 'scan']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/sales', [SalesController::class, 'index']);
    Route::get('/sales/{id}', [SalesController::class, 'show']);
    Route::post('/sales', [SalesController::class, 'store']);

    Route::controller(ReportController::class)
        ->prefix('reports')
        ->name('reports.')
        ->group(function () {
            Route::get('/stock-audit', 'stockAudit')->name('stock-audit');
            Route::get('/sales-history', 'salesHistory')->name('sales-history');
            Route::get('/stock-summary', 'stockSummary')->name('stock-summary');
        });

    Route::middleware(['auth.admin'])->group(function () {
        Route::apiResource('/stock-adjustments', StockAdjustmentController::class)
            ->only(['store', 'index']);
        Route::apiResource('/products', ProductController::class)
            ->except(['index', 'show']);

        Route::apiResource('/units', UnitController::class)
            ->except(['index', 'show']);

        Route::apiResource('/categories', CategoryController::class);
        Route::apiResource('/locations', LocationController::class);
        Route::apiResource('/users', UserController::class);
        Route::apiResource('/recipes', RecipeController::class);
    });
});
