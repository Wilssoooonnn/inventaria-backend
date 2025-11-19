<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;


// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Produk
    Route::get('/products', [ProductController::class, 'index']); // List dengan pagination
    Route::post('/products', [ProductController::class, 'store']); // Tambah produk
    Route::get('/products/scan', [ProductController::class, 'scan']); // <--- KHUSUS SCAN BARCODE
    Route::get('/products/{id}', [ProductController::class, 'show']); // Detail produk
    
});