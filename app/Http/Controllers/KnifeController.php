<?php

namespace App\Http\Controllers;

use App\Models\Knife;
use Illuminate\Http\Request;

class KnifeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $knives = Knife::latest()->paginate(20);
        $totalKnives = Knife::count();
        $activeKnives = Knife::where('knife_status', 'active')->count();
        
        return view('knives.index', compact('knives', 'totalKnives', 'activeKnives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('knives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'knife_code' => 'required|string|max:255|unique:knives,knife_code',
            'knife_name' => 'required|string|max:255',
            'knife_type' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|string|max:255',
            'grain_direction' => 'nullable|string|max:255',
            'knife_thickness' => 'nullable|numeric|min:0',
            'crease_lines' => 'nullable|integer|min:0',
            'punch_holes' => 'nullable|integer|min:0',
            'drill_size' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'knife_status' => 'required|in:active,inactive,maintenance,retired',
            'usage_count' => 'nullable|integer|min:0',
            'storage_location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Knife::create($validated);

        return redirect()->route('knives.index')
            ->with('success', 'تم إضافة السكينة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Knife $knife)
    {
        return view('knives.show', compact('knife'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Knife $knife)
    {
        return view('knives.edit', compact('knife'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Knife $knife)
    {
        $validated = $request->validate([
            'knife_code' => 'required|string|max:255|unique:knives,knife_code,' . $knife->id,
            'knife_name' => 'required|string|max:255',
            'knife_type' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|string|max:255',
            'grain_direction' => 'nullable|string|max:255',
            'knife_thickness' => 'nullable|numeric|min:0',
            'crease_lines' => 'nullable|integer|min:0',
            'punch_holes' => 'nullable|integer|min:0',
            'drill_size' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'knife_status' => 'required|in:active,inactive,maintenance,retired',
            'usage_count' => 'nullable|integer|min:0',
            'storage_location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $knife->update($validated);

        return redirect()->route('knives.index')
            ->with('success', 'تم تحديث السكينة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Knife $knife)
    {
        $knife->delete();

        return redirect()->route('knives.index')
            ->with('success', 'تم حذف السكينة بنجاح');
    }
}
