<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /** GET /api/categories (List) */
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json(['status' => 'success', 'data' => $categories], 200);
    }

    /** POST /api/categories (Create) */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name|max:100'
        ]);
        $category = Category::create($validated);
        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil dibuat.', 'data' => $category], 201);
    }

    /** PUT/PATCH /api/categories/{id} (Update) */
    public function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'max:100', Rule::unique('categories', 'name')->ignore($id)],
        ]);
        $category->update($validated);
        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil diperbarui.', 'data' => $category], 200);
    }

    /** DELETE /api/categories/{id} (Delete) */
    public function destroy(int $id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil dihapus.'], 200);
    }
}