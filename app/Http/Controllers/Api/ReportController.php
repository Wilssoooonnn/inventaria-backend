<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Hanya Admin yang boleh melihat laporan audit
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * GET /api/reports/stock-audit
     * Mengambil ledger riwayat pergerakan stok.
     */
    public function stockAudit(Request $request)
    {
        $movements = StockMovement::with(['user:id,name', 'product:id,name', 'location:id,name'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan audit pergerakan stok berhasil diambil.',
            'data' => $movements
        ], 200);
    }

    public function salesHistory(Request $request)
    {
        $sales = Sale::with(['user:id,name', 'location:id,name', 'items'])
            ->latest()
            ->paginate(20); // Gunakan pagination

        return response()->json([
            'status' => 'success',
            'message' => 'Riwayat penjualan berhasil diambil.',
            'data' => $sales
        ], 200);
    }
}