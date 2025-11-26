<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentTypes = ExpenseType::whereNull('parent_id')->with('children')->latest()->get();
        return view('expense-types.index', compact('parentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentTypes = ExpenseType::whereNull('parent_id')->get();
        return view('expense-types.create', compact('parentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:expense_types,id',
            'description' => 'nullable|string',
        ]);

        ExpenseType::create($validated);

        return redirect()->route('expense-types.index')
            ->with('success', $validated['parent_id'] ? 'تم إضافة النوع الفرعي بنجاح' : 'تم إضافة نوع المصروف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseType $expenseType)
    {
        $expenseType->load('parent', 'children');
        return view('expense-types.show', compact('expenseType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseType $expenseType)
    {
        $parentTypes = ExpenseType::whereNull('parent_id')->where('id', '!=', $expenseType->id)->get();
        return view('expense-types.edit', compact('expenseType', 'parentTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseType $expenseType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:expense_types,id',
            'description' => 'nullable|string',
        ]);

        // Prevent setting itself as parent
        if ($validated['parent_id'] == $expenseType->id) {
            return back()->withErrors(['parent_id' => 'لا يمكن تعيين النوع كوالد لنفسه']);
        }

        $expenseType->update($validated);

        return redirect()->route('expense-types.index')
            ->with('success', 'تم تحديث نوع المصروف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseType $expenseType)
    {
        // Check if it has children
        if ($expenseType->children()->count() > 0) {
            return redirect()->route('expense-types.index')
                ->with('error', 'لا يمكن حذف هذا النوع لأنه يحتوي على أنواع فرعية');
        }

        $expenseType->delete();

        return redirect()->route('expense-types.index')
            ->with('success', 'تم حذف نوع المصروف بنجاح');
    }
}
