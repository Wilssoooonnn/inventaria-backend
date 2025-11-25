<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /** GET /api/recipes (List) */
    public function index()
    {
        $recipes = Recipe::with(['menu:id,name', 'ingredient:id,name'])->get();
        return response()->json(['status' => 'success', 'data' => $recipes], 200);
    }

    /** POST /api/recipes (Create/Overwrite Recipe) */
    public function store(Request $request)
    {
        $request->validate([
            'menu_product_id' => 'required|exists:products,id',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.ingredient_product_id' => 'required|exists:products,id',
            'ingredients.*.quantity_used' => 'required|numeric|min:0.0001',
        ]);

        DB::beginTransaction();
        try {
            $menuId = $request->menu_product_id;

            Recipe::where('menu_product_id', $menuId)->delete();

            foreach ($request->ingredients as $ingredient) {
                if ($ingredient['ingredient_product_id'] == $menuId) {
                    throw new \Exception("Menu tidak bisa menjadi bahan bakunya sendiri.");
                }

                Recipe::create([
                    'menu_product_id' => $menuId,
                    'ingredient_product_id' => $ingredient['ingredient_product_id'],
                    'quantity_used' => $ingredient['quantity_used'],
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Resep berhasil disimpan.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menyimpan resep: ' . $e->getMessage()], 500);
        }
    }

    /** DELETE /api/recipes/{id} (Delete) */
    public function destroy(int $id)
    {
        Recipe::where('menu_product_id', $id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Resep berhasil dihapus.'], 200);
    }

}