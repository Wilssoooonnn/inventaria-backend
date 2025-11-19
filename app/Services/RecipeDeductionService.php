<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Recipe;
use Exception;

class RecipeDeductionService
{
    /**
     * Create a new class instance.
     */
    public function deduct(int $menuProductId, int $quantitySold, int $saleId, int $locationId, int $userId): void
    {
        $recipes = Recipe::where('menu_product_id', $menuProductId)->get();

        if ($recipes->isEmpty()) {
            return;
        }

        foreach ($recipes as $recipe) {
            $ingredientId = $recipe->ingredient_product_id;
            $requiredQty = $recipe->quantity_used * $quantitySold;

            $stock = Stock::where('product_id', $ingredientId)
                ->where('location_id', $locationId)
                ->first();

            if (!$stock || $stock->quantity < $requiredQty) {
                $ingredientName = $stock->product->name ?? 'Bahan Baku Tidak Diketahui';
                throw new Exception("Stok bahan baku [{$ingredientName}] tidak mencukupi.");
            }

            $stock->quantity -= $requiredQty;
            $stock->save();

            StockMovement::create([
                'product_id' => $ingredientId,
                'location_id' => $locationId,
                'user_id' => $userId,
                'type' => 'outbound_recipe',
                'quantity_change' => -$requiredQty,
                'remarks' => "Deduction for Sale ID: {$saleId}",
                'related_id' => $saleId,
            ]);
        }
    }
}
