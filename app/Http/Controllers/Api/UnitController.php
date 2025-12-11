<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();
        return response()->json(['status' => 'success', 'data' => $units], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:units,name',
            'symbol' => 'required|unique:units,symbol',
        ]);

        $unit = Unit::create($validated);
        return response()->json(['status' => 'success', 'message' => 'Unit berhasil ditambahkan', 'data' => $unit], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::find($id);

        if (!$unit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Satuan unit tidak ditemukan.'
            ], 404);
        }

        return response()->json(['status' => 'success', 'data' => $unit], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return response()->json(['status' => 'error', 'message' => 'Satuan unit tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('units')->ignore($id)],
            'symbol' => ['required', 'string', Rule::unique('units')->ignore($id)],
        ]);

        $unit->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Satuan unit berhasil diperbarui',
            'data' => $unit
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return response()->json(['status' => 'error', 'message' => 'Satuan unit tidak ditemukan.'], 404);
        }

        $unit->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Satuan unit berhasil dihapus.'
        ], 200);
    }
}
