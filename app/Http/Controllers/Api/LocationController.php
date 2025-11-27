<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /** GET /api/locations (List) */
    public function index()
    {
        $locations = Location::latest()->get();
        return response()->json(['status' => 'success', 'data' => $locations], 200);
    }

    /** POST /api/locations (Create) */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:locations,name|max:100',
            'address' => 'nullable|string'
        ]);
        $location = Location::create($validated);
        return response()->json(['status' => 'success', 'message' => 'Lokasi berhasil dibuat.', 'data' => $location], 201);
    }

    /** PUT/PATCH /api/locations/{id} (Update) */
    public function update(Request $request, int $id)
    {
        $location = Location::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'max:100', Rule::unique('locations', 'name')->ignore($id)],
            'address' => 'nullable|string',
        ]);
        $location->update($validated);
        return response()->json(['status' => 'success', 'message' => 'Lokasi berhasil diperbarui.', 'data' => $location], 200);
    }

    /** DELETE /api/locations/{id} (Delete) */
    public function destroy(int $id)
    {
        Location::findOrFail($id)->delete();
        return response()->json(['status' => 'success', 'message' => 'Lokasi berhasil dihapus.'], 200);
    }
}