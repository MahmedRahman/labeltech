<?php

namespace App\Http\Controllers;

use App\Models\Addition;
use Illuminate\Http\Request;

class AdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $additions = Addition::latest()->paginate(10);
        return view('additions.index', compact('additions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('additions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Addition::create($validated);

        return redirect()->route('additions.index')
            ->with('success', 'تم إضافة الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Addition $addition)
    {
        return view('additions.show', compact('addition'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Addition $addition)
    {
        return view('additions.edit', compact('addition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addition $addition)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $addition->update($validated);

        return redirect()->route('additions.index')
            ->with('success', 'تم تحديث الاضافة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addition $addition)
    {
        $addition->delete();

        return redirect()->route('additions.index')
            ->with('success', 'تم حذف الاضافة بنجاح');
    }
}
