<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function index()
    {
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount');

        $assetValue = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where('products.type', 'ingredient')
            ->sum(DB::raw('stocks.quantity * products.purchase_price'));

        $lowStocks = Stock::with(['product.unit'])
            ->whereHas('product', function ($q) {
                $q->whereColumn('stock_minimum', '>=', 'stocks.quantity');
            })
            ->orderBy('quantity', 'asc')
            ->get();

        $recentMovements = StockMovement::with(['product', 'user:id,name'])
            ->latest()
            ->limit(5)
            ->get();
        return view('admin.dashboard.index', compact(
            'todaySales',
            'assetValue',
            'lowStocks',
            'recentMovements'
        ));
    }
}