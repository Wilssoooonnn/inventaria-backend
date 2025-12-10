<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Models\Stock;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin')->except(['stockSummary', 'stockAudit', 'salesHistory']);
    }

    public function stockSummary(Request $request)
    {
        $query = Stock::with([
            'product:id,name,sku,stock_minimum,unit_id',
            'location:id,name',
        ]);

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $stocks = $query
            ->orderBy('product_id')
            ->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Ringkasan stok berhasil diambil.',
            'data'    => $stocks,
        ], 200);
    }

    public function stockAudit(Request $request)
    {
        $movements = StockMovement::with(['user:id,name', 'product:id,name', 'location:id,name'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'status'  => 'success',
            'message' => 'Laporan audit pergerakan stok berhasil diambil.',
            'data'    => $movements,
        ], 200);
    }

    public function salesHistory(Request $request)
    {
        $sales = Sale::with(['user:id,name', 'location:id,name', 'items'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'status'  => 'success',
            'message' => 'Riwayat penjualan berhasil diambil.',
            'data'    => $sales,
        ], 200);
    }
}
