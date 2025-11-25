<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    public function index()
    {
        $locations = Location::latest()->get();
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:locations,name|max:100',
            'address' => 'nullable|string',
        ]);

        Location::create($validated);
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi baru berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required|unique:locations,name,' . $location->id . '|max:100',
            'address' => 'nullable|string',
        ]);

        $location->update($validated);
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return back()->with('success', 'Lokasi berhasil dihapus.');
    }
}