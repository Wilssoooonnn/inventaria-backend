<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- 1. Import Controllers ---
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
        return $request->user(); });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/units', [UnitController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/scan', [ProductController::class, 'scan']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    Route::post('/sales', [SalesController::class, 'store']);

    Route::middleware(['auth.admin'])->group(function () {

        Route::post('/stock-adjustments', [StockAdjustmentController::class, 'store']);

        Route::get('/reports/stock-audit', [ReportController::class, 'stockAudit']);
        Route::get('/reports/sales-history', [ReportController::class, 'salesHistory']);


        Route::apiResource('/products', ProductController::class)->except(['index', 'show']);

        Route::apiResource('/units', UnitController::class)->except(['index', 'show']);

        Route::apiResource('/categories', CategoryController::class);

        Route::apiResource('/locations', LocationController::class);

        Route::apiResource('/users', UserController::class);

        Route::apiResource('/recipes', RecipeController::class);
    });
});