<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Product;

class RecipeWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    /**
     * GET /admin/recipes
     * Menampilkan daftar semua Resep (di-grouping per menu).
     */
    public function index()
    {
        $recipes = Recipe::with(['menu.unit', 'ingredient.unit'])->get();

        $recipesGrouped = $recipes->groupBy('menu.name');

        return view('admin.recipes.index', compact('recipesGrouped'));
    }

    /**
     * GET /admin/recipes/create
     * Menampilkan form untuk membuat Resep baru.
     */
    public function create()
    {
        $menu_items = Product::where('type', 'menu')->get();
        $ingredients = Product::where('type', 'ingredient')->with('unit')->get();

        return view('admin.recipes.create', compact('menu_items', 'ingredients'));
    }

    /**
     * POST /admin/recipes
     * Menyimpan Resep baru (atau meng-overwrite yang sudah ada).
     */
    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:products,id',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredient_id' => 'required|exists:products,id',
            'ingredients.*.quantity_used' => 'required|numeric|min:0.0001',
        ]);

        DB::beginTransaction();
        try {
            $menuId = $request->menu_id;

            Recipe::where('menu_product_id', $menuId)->delete();

            foreach ($request->ingredients as $ingredient) {
                if ($ingredient['ingredient_id'] == $menuId) {
                    throw new \Exception("Menu tidak bisa menjadi bahan bakunya sendiri.");
                }

                Recipe::create([
                    'menu_product_id' => $menuId,
                    'ingredient_product_id' => $ingredient['ingredient_id'],
                    'quantity_used' => $ingredient['quantity_used'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil disimpan/diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan resep: ' . $e->getMessage());
        }
    }

    /**
     * GET /admin/recipes/{recipe}/edit
     * Menampilkan form edit (memuat data resep yang ada).
     * Kami akan menggunakan menu_id sebagai parameter {recipe} untuk kemudahan.
     */
    public function edit(int $menu_id)
    {
        $menu = Product::where('type', 'menu')->findOrFail($menu_id);

        $currentRecipes = Recipe::where('menu_product_id', $menu->id)->get();

        $menu_items = Product::where('type', 'menu')->get();
        $ingredients = Product::where('type', 'ingredient')->with('unit')->get();

        return view('admin.recipes.edit', compact('menu', 'currentRecipes', 'menu_items', 'ingredients'));
    }

    /**
     * PUT/PATCH /admin/recipes/{recipe}
     * Memperbarui resep. (Logicnya sama dengan store, karena kita overwrite).
     */
    public function update(Request $request, int $menu_id)
    {
        $request->merge(['menu_id' => $menu_id]);
        return $this->store($request);
    }

    /**
     * DELETE /admin/recipes/{recipe}
     * Menghapus seluruh resep untuk Menu tertentu.
     */
    public function destroy(int $menu_id)
    {
        $recipeCount = Recipe::where('menu_product_id', $menu_id)->count();

        if ($recipeCount === 0) {
            return back()->with('error', 'Tidak ada resep yang perlu dihapus.');
        }

        Recipe::where('menu_product_id', $menu_id)->delete();

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil dihapus.');
    }
}