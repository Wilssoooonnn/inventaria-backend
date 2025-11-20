<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitWebController extends BaseController
{
    public function __construct()
    {
        $this->middleware('check.admin');
    }

    /**
     * Menampilkan daftar semua Unit.
     */
    public function index()
    {
        $units = Unit::paginate(10);
        return view('admin.units.index', compact('units'));
    }

    /**
     * Menampilkan form untuk membuat Unit baru.
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Menyimpan Unit baru yang dibuat dari form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:units,name|max:50',
            'symbol' => 'required|unique:units,symbol|max:10',
        ]);

        Unit::create($validated);

        return redirect()->route('admin.units.index')->with('success', 'Satuan unit berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit untuk Unit.
     */
    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Memperbarui data Unit.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|unique:units,name,' . $unit->id,
            'symbol' => 'required|unique:units,symbol,' . $unit->id,
        ]);

        $unit->update($validated);

        return redirect()->route('admin.units.index')->with('success', 'Satuan unit berhasil diperbarui.');
    }

    /**
     * Menghapus Unit.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return back()->with('success', 'Satuan unit berhasil dihapus.');
    }
}
