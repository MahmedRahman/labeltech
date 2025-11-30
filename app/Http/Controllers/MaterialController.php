<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        Material::create($validated);

        return redirect()->route('materials.index')
            ->with('success', 'تم إضافة الخامة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:materials,name,' . $material->id,
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $material->update($validated);

        return redirect()->route('materials.index')
            ->with('success', 'تم تحديث الخامة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'تم حذف الخامة بنجاح');
    }
}
