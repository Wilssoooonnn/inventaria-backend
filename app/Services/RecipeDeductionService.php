<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use Exception;

class RecipeDeductionService
{
    /**
     * Mengurangi stok bahan sesuai resep menu.
     *
     * @param int         $menuProductId   ID produk menu (products.id)
     * @param int|float   $quantityOrdered Jumlah menu yang dipesan
     * @param int         $saleId          ID sale (sales.id)
     * @param int         $locationId      ID lokasi stok (locations.id)
     * @param int         $userId          ID user yang melakukan transaksi
     *
     * @throws \Exception
     */
    public function deduct($menuProductId, $quantityOrdered, $saleId, $locationId, $userId)
    {
        $menu = Product::with(['recipeIngredients.ingredient'])->findOrFail($menuProductId);
        if ($menu->recipeIngredients->isEmpty()) {
            return;
        }

        foreach ($menu->recipeIngredients as $recipe) {
            $usage = $recipe->quantity_used * $quantityOrdered;
            $stock = Stock::firstOrNew([
                'product_id' => $recipe->ingredient_product_id,
                'location_id' => $locationId,
            ]);
            if ($stock->quantity === null) {
                $stock->quantity = 0;
            }
            $ingredientName = $recipe->ingredient
                ? $recipe->ingredient->name
                : 'Bahan tanpa nama';
            if ($stock->quantity < $usage) {
                throw new Exception(
                    "Stok bahan '{$ingredientName}' tidak cukup. " .
                    "Dibutuhkan {$usage}, tetapi tersisa {$stock->quantity}."
                );
            }

            $stock->quantity -= $usage;
            $stock->save();

            StockMovement::create([
                'product_id'      => $recipe->ingredient_product_id,
                'location_id'     => $locationId,
                'user_id'         => $userId,
                'type'            => 'adjustment',
                'quantity_change' => -$usage,
                'reference'       => "SALE #{$saleId}",
                'remarks'         => "Pemakaian bahan untuk menu {$menu->name}",
            ]);
        }
    }
}
