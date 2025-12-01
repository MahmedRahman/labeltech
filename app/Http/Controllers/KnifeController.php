<?php

namespace App\Http\Controllers;

use App\Models\Knife;
use Illuminate\Http\Request;

class KnifeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Knife::query();

        // Filter by type
        if ($request->filled('filter_type')) {
            $query->where('type', $request->filter_type);
        }

        // Filter by width
        if ($request->filled('filter_width')) {
            $query->where('width', $request->filter_width);
        }

        // Filter by length
        if ($request->filled('filter_length')) {
            $query->where('length', $request->filter_length);
        }

        $knives = $query->latest()->paginate(20)->appends($request->query());
        $totalKnives = Knife::count();
        
        // Get unique values for filter dropdowns
        $types = Knife::distinct()->whereNotNull('type')->pluck('type')->sort()->values();
        $widths = Knife::distinct()->whereNotNull('width')->pluck('width')->sort()->values();
        $lengths = Knife::distinct()->whereNotNull('length')->pluck('length')->sort()->values();
        
        return view('knives.index', compact('knives', 'totalKnives', 'types', 'widths', 'lengths'));
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
            'type' => 'nullable|in:مستطيل,دائرة,مربع,بيضاوي,شكل خاص',
            'gear' => 'nullable|string|max:255',
            'dragile_drive' => 'nullable|string|max:255',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|string|max:255',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'knife_code' => 'required|string|max:255|unique:knives,knife_code',
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
            'type' => 'nullable|in:مستطيل,دائرة,مربع,بيضاوي,شكل خاص',
            'gear' => 'nullable|string|max:255',
            'dragile_drive' => 'nullable|string|max:255',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|string|max:255',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'knife_code' => 'required|string|max:255|unique:knives,knife_code,' . $knife->id,
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
