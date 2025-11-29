<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\Client;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workOrders = WorkOrder::with('client')->latest()->paginate(10);
        return view('work-orders.index', compact('workOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('work-orders.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_number' => 'nullable|string|max:255|unique:work_orders,order_number',
            'number_of_colors' => 'required|integer|min:1',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'final_product_shape' => 'nullable|string',
            'additions' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
        ]);

        // Generate order number if not provided
        if (empty($validated['order_number'])) {
            $validated['order_number'] = 'WO-' . str_pad(WorkOrder::count() + 1, 6, '0', STR_PAD_LEFT);
        }

        WorkOrder::create($validated);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم إضافة أمر الشغل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkOrder $workOrder)
    {
        $workOrder->load('client');
        return view('work-orders.show', compact('workOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkOrder $workOrder)
    {
        $clients = Client::orderBy('name')->get();
        return view('work-orders.edit', compact('workOrder', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_number' => 'nullable|string|max:255|unique:work_orders,order_number,' . $workOrder->id,
            'number_of_colors' => 'required|integer|min:1',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'final_product_shape' => 'nullable|string',
            'additions' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
        ]);

        $workOrder->update($validated);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم تحديث أمر الشغل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();

        return redirect()->route('work-orders.index')
            ->with('success', 'تم حذف أمر الشغل بنجاح');
    }
}
