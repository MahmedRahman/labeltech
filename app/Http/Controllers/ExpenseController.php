<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Supplier;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with(['expenseType.parent', 'supplier', 'paymentMethod'])
            ->latest('date')
            ->latest()
            ->paginate(15);
        
        $totalAmount = Expense::sum('amount');
        $thisMonthAmount = Expense::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('amount');
        
        return view('expenses.index', compact('expenses', 'totalAmount', 'thisMonthAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expenseTypes = ExpenseType::with('children')->whereNull('parent_id')->orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('name')->get();
        
        return view('expenses.create', compact('expenseTypes', 'suppliers', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'تم إضافة المصروف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        $expense->load(['expenseType.parent', 'supplier', 'paymentMethod']);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $expenseTypes = ExpenseType::with('children')->whereNull('parent_id')->orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->orderBy('name')->get();
        
        return view('expenses.edit', compact('expense', 'expenseTypes', 'suppliers', 'paymentMethods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')
            ->with('success', 'تم تحديث المصروف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'تم حذف المصروف بنجاح');
    }
}
