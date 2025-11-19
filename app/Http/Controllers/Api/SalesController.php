<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\RecipeDeductionService;
use Illuminate\Support\Facades\DB;
use Exception;

class SalesController extends Controller
{
    protected $recipeDeductionService;



    public function __construct(RecipeDeductionService $recipeDeductionService)
    {
        $this->recipeDeductionService = $recipeDeductionService;
    }

    /**
     * POST /api/sales
     * Memproses Penjualan dan Deduce Resep.
     */
    public function store(Request $request)
    {

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'invoice_number' => 'required|unique:sales,invoice_number',
            'location_id' => 'required|exists:locations,id',
        ]);

        DB::beginTransaction();

        try {
            $userId = $request->user()->id;

            $sale = Sale::create([
                'invoice_number' => $request->invoice_number,
                'user_id' => $userId,
                'location_id' => $request->location_id,
                'total_amount' => $request->total_amount,
            ]);

            foreach ($request->items as $item) {

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price_at_sale' => $item['price_at_sale'] ?? 0,
                    'subtotal' => $item['subtotal'] ?? 0,
                ]);

                $this->recipeDeductionService->deduct(
                    $item['product_id'],
                    $item['quantity'],
                    $sale->id,
                    $request->location_id,
                    $userId
                );
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Penjualan berhasil diproses. Stok bahan baku telah dipotong.',
                'data' => $sale->load('items')
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();


            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi gagal diproses: ' . $e->getMessage(),
            ], 500);
        }
    }
}
