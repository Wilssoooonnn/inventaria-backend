<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductWebController extends BaseController
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    /**
     * Menampilkan daftar semua Produk (Menu & Bahan Baku).
     */
    public function index()
    {
        $products = Product::with(['category', 'unit'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat Produk/Menu baru.
     */
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.products.create', compact('categories', 'units'));
    }

    /**
     * Menyimpan Produk baru dengan validasi F&B bercabang.
     */
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
                'sku' => 'required|unique:products,sku',
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
        }

        Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Produk F&B berhasil dibuat.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Memperbarui Produk.
     */
    public function update(Request $request, Product $product)
    {
        $type = $product->type;

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|url',
        ];

        $rules['sku'] = [
            'nullable',

            Rule::unique('products', 'sku')->ignore($product->id),
        ];

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

        return redirect()->route('admin.products.index')->with('success', 'Produk F&B berhasil diperbarui.');
    }

    /**
     * Menghapus Produk.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
