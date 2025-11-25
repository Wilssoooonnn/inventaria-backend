<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Location;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    /**
     * GET /admin/stock
     * Menampilkan daftar semua stok Bahan Baku saat ini (dengan pagination).
     */
    public function index()
    {
        $stocks = Stock::with(['product.unit', 'location'])
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->where('products.type', 'ingredient')
            ->select('stocks.*')
            ->latest('stocks.updated_at')
            ->paginate(15);

        return view('admin.stock.index', compact('stocks'));
    }

    /**
     * GET /admin/stock/create
     * Menampilkan form untuk Penyesuaian Stok (Barang Masuk/Keluar Manual).
     */
    public function create()
    {

        $ingredients = Product::where('type', 'ingredient')->get();

        $locations = Location::all();

        return view('admin.stock.create', compact('ingredients', 'locations'));
    }
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
            $userId = Auth::id();

            $stock = Stock::firstOrCreate(
                ['product_id' => $validated['product_id'], 'location_id' => $validated['location_id']],
                ['quantity' => 0]
            );

            if (!$isPositive && $stock->quantity < abs($quantityChange)) {
                throw new \Exception("Stok tidak mencukupi untuk pengurangan sebesar " . abs($quantityChange));
            }

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

            return redirect()->route('admin.stock.index')->with('success', 'Penyesuaian stok berhasil diproses.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal memproses penyesuaian: ' . $e->getMessage());
        }
    }

}