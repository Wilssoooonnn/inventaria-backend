<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;

class RecipeWebController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with(['menu.unit', 'ingredient.unit'])->get();

        $recipesGrouped = $recipes->groupBy('menu.name');

        return view('admin.recipes.index', compact('recipesGrouped'));
    }

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

            foreach ($request->ingredients as $ingredient) {
                Recipe::create([
                    'menu_product_id' => $menuId,
                    'ingredient_product_id' => $ingredient['ingredient_id'],
                    'quantity_used' => $ingredient['quantity_used'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan resep: ' . $e->getMessage());
        }
    }
}
