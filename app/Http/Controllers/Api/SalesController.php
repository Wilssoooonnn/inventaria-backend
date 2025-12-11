<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Services\RecipeDeductionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SalesController extends Controller
{
    protected $recipeDeductionService;

    public function __construct(RecipeDeductionService $recipeDeductionService)
    {
        $this->recipeDeductionService = $recipeDeductionService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_at_sale' => 'required|numeric|min:0',
            'items.*.subtotal' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'invoice_number' => 'required|string|unique:sales,invoice_number',
            'location_id' => 'required|exists:locations,id',
        ]);

        // Log untuk debugging
        Log::info('Sale Request', [
            'user_id' => $request->user()->id,
            'invoice' => $validated['invoice_number'],
            'items_count' => count($validated['items']),
        ]);

        DB::beginTransaction();

        try {
            $userId = $request->user()->id;

            $sale = Sale::create([
                'invoice_number' => $validated['invoice_number'],
                'user_id' => $userId,
                'location_id' => $validated['location_id'],
                'total_amount' => $validated['total_amount'],
                'sale_date' => now(),
            ]);

            // Proses setiap item
            foreach ($validated['items'] as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price_at_sale' => $item['price_at_sale'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Deduksi stok berdasarkan resep
                try {
                    $this->recipeDeductionService->deduct(
                        $item['product_id'],
                        $item['quantity'],
                        $sale->id,
                        $validated['location_id'],
                        $userId
                    );
                } catch (Exception $e) {
                    throw new Exception(
                        "Gagal memproses item: " . $e->getMessage()
                    );
                }
            }

            // Commit transaksi
            DB::commit();

            // Load relasi untuk response
            $sale->load([
                'user:id,name,email',
                'location:id,name',
                'items.product:id,name,sale_price',
            ]);

            // Format response sesuai kebutuhan Flutter
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'data' => [
                    'id' => $sale->id,
                    'invoice_number' => $sale->invoice_number,
                    'total_amount' => (float) $sale->total_amount,
                    'sale_date' => $sale->created_at->toIso8601String(),

                    'user' => [
                        'id' => $sale->user->id,
                        'name' => $sale->user->name,
                    ],

                    'location' => [
                        'id' => $sale->location->id,
                        'name' => $sale->location->name,
                    ],

                    'items' => $sale->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'price_at_sale' => (float) $item->price_at_sale,
                            'subtotal' => (float) $item->subtotal,
                        ];
                    })->values(),
                ],
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Sale Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function index(Request $request)
    {
        $sales = Sale::with([
                'user:id,name',
                'items.product:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($sales);
    }

    public function show($id)
    {
        $sale = Sale::with([
            'user:id,name,email',
            'location:id,name',
            'items.product:id,name,sale_price',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $sale,
        ]);
    }
}
