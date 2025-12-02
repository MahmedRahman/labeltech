<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\Client;
use App\Models\Material;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workOrders = WorkOrder::with('client')
            ->where(function($query) {
                $query->whereNull('production_status')
                      ->orWhere('production_status', 'بدون حالة')
                      ->orWhereIn('production_status', ['طباعة', 'قص', 'تقفيل']);
            })
            ->latest()
            ->get();
        
        // Group work orders by production status
        $groupedOrders = [
            'بدون حالة' => $workOrders->filter(function($order) {
                return is_null($order->production_status) || $order->production_status === 'بدون حالة';
            })->values(),
            'طباعة' => $workOrders->where('production_status', 'طباعة')->values(),
            'قص' => $workOrders->where('production_status', 'قص')->values(),
            'تقفيل' => $workOrders->where('production_status', 'تقفيل')->values(),
        ];
        
        return view('work-orders.index', compact('groupedOrders', 'workOrders'));
    }

    /**
     * Display archived work orders.
     */
    public function archive()
    {
        $workOrders = WorkOrder::with('client')
            ->where('production_status', 'أرشيف')
            ->latest()
            ->paginate(20);
        
        return view('work-orders.archive', compact('workOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $materials = Material::where('is_active', true)->orderBy('name')->get();
        return view('work-orders.create', compact('clients', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_number' => 'nullable|string|max:255|unique:work_orders,order_number',
            'number_of_colors' => 'required|integer|min:0|max:6',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'final_product_shape' => 'nullable|string',
            'additions' => 'nullable|string',
            'fingerprint' => 'nullable|in:yes,no',
            'winding_direction' => 'nullable|in:yes,no',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|in:76,40,25',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
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
        $materials = Material::where('is_active', true)->orderBy('name')->get();
        return view('work-orders.edit', compact('workOrder', 'clients', 'materials'));
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
            'fingerprint' => 'nullable|in:yes,no',
            'winding_direction' => 'nullable|in:yes,no',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|numeric|min:0',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
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

    /**
     * Show the form for adding/editing design data.
     */
    public function showDesignForm(WorkOrder $workOrder)
    {
        $workOrder->load('client', 'designKnife');
        $knives = \App\Models\Knife::orderBy('knife_code')->get();
        $knivesData = $knives->map(function($knife) {
            return [
                'id' => $knife->id,
                'knife_code' => $knife->knife_code,
                'type' => $knife->type,
                'gear' => $knife->gear,
                'dragile_drive' => $knife->dragile_drive,
                'rows_count' => $knife->rows_count,
                'eyes_count' => $knife->eyes_count,
                'flap_size' => $knife->flap_size,
                'length' => $knife->length,
                'width' => $knife->width,
                'notes' => $knife->notes,
            ];
        });
        return view('work-orders.design', compact('workOrder', 'knives', 'knivesData'));
    }

    /**
     * Store design data for the work order.
     */
    public function storeDesign(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'design_knife_id' => 'nullable|exists:knives,id',
            'design_rows_count' => 'nullable|integer|min:1',
            'design_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,ai,psd|max:10240',
        ]);

        // Handle file upload
        if ($request->hasFile('design_file')) {
            // Delete old file if exists
            if ($workOrder->design_file && \Storage::disk('public')->exists('designs/' . $workOrder->design_file)) {
                \Storage::disk('public')->delete('designs/' . $workOrder->design_file);
            }
            
            $file = $request->file('design_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('designs', $fileName, 'public');
            $validated['design_file'] = $fileName;
        }

        // Check if design data exists
        $hasDesign = !empty($validated['design_knife_id']) || 
                     !empty($validated['design_rows_count']) || 
                     !empty($validated['design_file']);
        
        $validated['has_design'] = $hasDesign;

        $workOrder->update($validated);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم إضافة بيانات التصميم بنجاح');
    }

    /**
     * Update production status for a work order.
     */
    public function updateProductionStatus(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'production_status' => 'nullable|in:بدون حالة,طباعة,قص,تقفيل,أرشيف',
        ]);

        // Convert empty string to null for "بدون حالة"
        if (empty($validated['production_status']) || $validated['production_status'] === '') {
            $validated['production_status'] = 'بدون حالة';
        }

        $workOrder->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الإنتاج بنجاح',
            'production_status' => $workOrder->production_status,
        ]);
    }

}
