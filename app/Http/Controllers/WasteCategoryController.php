<?php

namespace App\Http\Controllers;

use App\Models\WasteCategory;
use Illuminate\Http\Request;

class WasteCategoryController extends Controller
{
    public function index()
    {
        $categories = WasteCategory::all();
        return view('admin.waste-category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'point_per_kg' => 'required|integer',
        ]);

        WasteCategory::create($request->only(['name', 'point_per_kg']));
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'point_per_kg' => 'required|integer',
        ]);

        $category = WasteCategory::findOrFail($id);
        $category->update($request->only(['name', 'point_per_kg']));
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        WasteCategory::destroy($id);
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
