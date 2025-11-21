<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * POST /api/stock-adjustments
     * Menerima Inbound Stock, Waste, atau Manual Adjustment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'location_id' => 'required|exists:locations,id',
            'quantity_change' => 'required|numeric|min:0.0001',
            'type' => 'required|in:inbound,outbound_waste,adjustment',
            'remarks' => 'nullable|string|max:255',
        ]);

        $isPositive = in_array($validated['type'], ['inbound', 'adjustment']);
        $quantityChange = $isPositive ? $validated['quantity_change'] : -$validated['quantity_change'];

        DB::beginTransaction();
        try {
            $userId = $request->user()->id;

            $stock = Stock::firstOrCreate(
                ['product_id' => $validated['product_id'], 'location_id' => $validated['location_id']],
                ['quantity' => 0]
            );

            $stock->quantity += $quantityChange;
            $stock->save();

            StockMovement::create([
                'product_id' => $validated['product_id'],
                'location_id' => $validated['location_id'],
                'user_id' => $userId,
                'type' => $validated['type'],
                'quantity_change' => $quantityChange,
                'remarks' => $validated['remarks'],
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Stok berhasil diperbarui: ' . ($isPositive ? 'Ditambah' : 'Dikurangi'),
                'current_stock' => $stock->quantity
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal memproses stok: ' . $e->getMessage()], 500);
        }
    }
}