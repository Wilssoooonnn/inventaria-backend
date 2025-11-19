<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::with('category', 'stocks')->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil diambil',
            'data' => $products
        ], 200);
    }

    public function scan(Request $request)
    {
        $request->validate([
            'sku' => 'required|string'
        ]);

        $product = Product::with('category', 'stocks')
            ->where('sku', $request->sku)
            ->first();

        if (!$product) {

            return response()->json([
                'status' => 'error',
                'message' => 'Produk dengan barcode tersebut tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Produk ditemukan',
            'data' => $product
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock_minimum' => 'integer',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dibuat',
            'data' => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::with('category', 'stocks')->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail produk ditemukan',
            'data' => $product
        ], 200);
    }
}