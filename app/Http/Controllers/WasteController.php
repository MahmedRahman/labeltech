<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use Illuminate\Http\Request;

class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wastes = Waste::orderBy('number_of_colors')->paginate(20);
        $totalWastes = Waste::count();
        
        return view('wastes.index', compact('wastes', 'totalWastes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wastes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number_of_colors' => 'required|integer|min:0|max:6|unique:wastes,number_of_colors',
            'waste_percentage' => 'required|numeric|min:0|max:100',
            'waste_per_roll' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Waste::create($validated);

        return redirect()->route('wastes.index')
            ->with('success', 'تم إضافة بيانات الهالك بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Waste $waste)
    {
        return view('wastes.show', compact('waste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waste $waste)
    {
        return view('wastes.edit', compact('waste'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Waste $waste)
    {
        $validated = $request->validate([
            'number_of_colors' => 'required|integer|min:0|max:6|unique:wastes,number_of_colors,' . $waste->id,
            'waste_percentage' => 'required|numeric|min:0|max:100',
            'waste_per_roll' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $waste->update($validated);

        return redirect()->route('wastes.index')
            ->with('success', 'تم تحديث بيانات الهالك بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waste $waste)
    {
        $waste->delete();

        return redirect()->route('wastes.index')
            ->with('success', 'تم حذف بيانات الهالك بنجاح');
    }
}
