<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $query = Product::with('category', 'unit');

        if ($type && in_array($type, ['menu', 'ingredient'])) {
            $query->where('type', $type);
        }

        $products = $query->latest()->paginate(10);
        return response()->json(['status' => 'success', 'data' => $products], 200);
    }

    public function scan(Request $request)
    {
        $request->validate(['sku' => 'required|string']);
        $product = Product::with('unit')->where('sku', $request->sku)->first();

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan.'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $product], 200);
    }

    public function store(Request $request)
    {
        $type = $request->type;

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:menu,ingredient',
        ];

        if ($type === 'ingredient') {
            $rules = array_merge($rules, [
                'sku' => 'required|string|unique:products,sku',
                'unit_id' => 'required|exists:units,id',
                'purchase_price' => 'required|numeric|min:0',
                'stock_minimum' => 'integer|min:0',
            ]);
        } elseif ($type === 'menu') {
            $rules = array_merge($rules, [
                'sale_price' => 'required|numeric|min:0',
                'sku' => 'nullable|unique:products,sku',
            ]);
        }

        $validatedData = $request->validate($rules);

        if ($type === 'menu') {
            $validatedData['purchase_price'] = 0;
            $validatedData['stock_minimum'] = 0;
            $validatedData['unit_id'] = null;
        } elseif ($type === 'ingredient') {
            $validatedData['sale_price'] = 0;
            $validatedData['unit_id'] = $validatedData['unit_id'] ?? null;
        }

        $product = Product::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk F&B berhasil dibuat',
            'data' => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::with('category', 'unit')->find($id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $product], 200);
    }
    public function update(Request $request, int $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        $type = $product->type;

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($request->has('sku') && $product->sku !== $request->sku) {
            $rules['sku'] = [
                'nullable',
                Rule::unique('products')->ignore($id),
            ];
        }

        if ($type === 'ingredient') {
            $rules = array_merge($rules, [
                'unit_id' => 'required|exists:units,id',
                'purchase_price' => 'required|numeric|min:0',
                'stock_minimum' => 'integer|min:0',
            ]);
        } elseif ($type === 'menu') {
            $rules = array_merge($rules, [
                'sale_price' => 'required|numeric|min:0',
            ]);
        }

        $validatedData = $request->validate($rules);

        $product->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil diperbarui',
            'data' => $product
        ], 200);
    }
}