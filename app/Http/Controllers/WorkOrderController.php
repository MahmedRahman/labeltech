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
        $query = WorkOrder::with('client')
            ->where(function($q) {
                $q->whereNull('production_status')
                  ->orWhere('production_status', 'بدون حالة')
                  ->orWhereIn('production_status', ['طباعة', 'قص', 'تقفيل']);
            });

        // Filter work orders based on user type:
        // - Employees: show only work orders they created
        // - Admin (web guard): show all work orders (no filter)
        if (auth('employee')->check()) {
            $employeeName = auth('employee')->user()->name;
            $query->where('created_by', $employeeName);
        }
        // Admin users (auth('web')->check()) will see all work orders
        // No additional filter is applied for admin users

        $workOrders = $query->latest()->get();
        
        // Group work orders by production status
        // Filter out any orders without an ID (shouldn't happen, but safety check)
        $workOrders = $workOrders->filter(function($order) {
            return !is_null($order->id);
        });
        
        $groupedOrders = [
            'بدون حالة' => $workOrders->filter(function($order) {
                return is_null($order->production_status) || $order->production_status === 'بدون حالة';
            })->values(),
            'طباعة' => $workOrders->filter(function($order) {
                return $order->production_status === 'طباعة';
            })->values(),
            'قص' => $workOrders->filter(function($order) {
                return $order->production_status === 'قص';
            })->values(),
            'تقفيل' => $workOrders->filter(function($order) {
                return $order->production_status === 'تقفيل';
            })->values(),
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
        $additions = \App\Models\Addition::orderBy('name')->get();
        $externalBreakingPrice = \App\Models\SystemSetting::getValue('external_breaking_price', 4);
        $wastes = \App\Models\Waste::orderBy('number_of_colors')->get();
        return view('work-orders.create', compact('clients', 'materials', 'additions', 'externalBreakingPrice', 'wastes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_number' => 'nullable|string|max:255|unique:work_orders,order_number',
            'job_name' => 'nullable|string|max:255',
            'number_of_colors' => 'required|integer|min:0|max:6',
            'rows_count' => 'nullable|integer|min:1',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'final_product_shape' => 'nullable|string',
            'additions' => 'nullable|string',
            'addition_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->additions && $request->additions !== 'لا يوجد' && $value !== null) {
                        $addition = \App\Models\Addition::where('name', $request->additions)->first();
                        if ($addition && $value < $addition->price) {
                            $fail('سعر الإضافة يجب أن يكون أكبر من أو يساوي السعر الافتراضي (' . number_format($addition->price, 2) . ' ج.م)');
                        }
                    }
                },
            ],
            'fingerprint' => 'nullable|in:yes,no',
            'fingerprint_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->fingerprint === 'yes' && empty($value)) {
                        $fail('سعر البصمة مطلوب عند اختيار وجود البصمة');
                    }
                },
            ],
            'winding_direction' => 'nullable|in:no,clockwise,counterclockwise',
            'knife_exists' => 'nullable|in:yes,no',
            'knife_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->knife_exists === 'yes' && empty($value)) {
                        $fail('سعر السكينة مطلوب عند اختيار وجود السكينة');
                    }
                },
            ],
            'external_breaking' => 'nullable|in:yes,no',
            'external_breaking_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->external_breaking === 'yes' && empty($value)) {
                        $fail('سعر التكسير الخارجي مطلوب عند اختيار وجود التكسير الخارجي');
                    }
                },
            ],
            'film_price' => 'nullable|numeric|min:0',
            'film_count' => 'nullable|integer|min:1',
            'sales_percentage' => 'nullable|numeric|min:0|max:100',
            'material_price_per_meter' => 'nullable|numeric|min:0',
            'manufacturing_price_per_meter' => 'nullable|numeric|min:0',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|in:76,40,25',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
            'paper_width' => 'nullable|numeric|min:0',
            'gap_count' => 'nullable|numeric|min:0',
            'waste_per_roll' => 'nullable|integer|min:0',
            'increase' => 'nullable|numeric|min:0',
            'linear_meter' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed,cancelled',
        ]);

        // Generate order number if not provided
        if (empty($validated['order_number'])) {
            $validated['order_number'] = 'WO-' . str_pad(WorkOrder::count() + 1, 6, '0', STR_PAD_LEFT);
        }

        // Get the current authenticated user (admin or employee)
        if (auth('employee')->check()) {
            $validated['created_by'] = auth('employee')->user()->name;
        } elseif (auth('web')->check()) {
            $validated['created_by'] = auth('web')->user()->name;
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
        $workOrder->load('client', 'designKnife');
        return view('work-orders.show', compact('workOrder'));
    }

    /**
     * Print work order.
     */
    public function print(WorkOrder $workOrder)
    {
        $workOrder->load('client', 'designKnife');
        
        // Calculate values for printing
        $calculations = $this->calculatePrintValues($workOrder);
        
        return view('work-orders.print', compact('workOrder', 'calculations'));
    }

    /**
     * Calculate print values for work order.
     */
    private function calculatePrintValues(WorkOrder $workOrder)
    {
        $calculations = [];
        
        // Net Linear Meter calculation
        // Formula: (Quantity / Pieces per roll) * (Length in cm / 100)
        if ($workOrder->number_of_rolls && $workOrder->length) {
            $piecesPerRoll = $workOrder->number_of_rolls > 0 ? ($workOrder->quantity / $workOrder->number_of_rolls) : 0;
            $calculations['net_linear_meter'] = $piecesPerRoll * ($workOrder->length / 100);
        } elseif ($workOrder->quantity && $workOrder->length) {
            // Fallback calculation
            $calculations['net_linear_meter'] = ($workOrder->quantity * $workOrder->length) / 100;
        } else {
            $calculations['net_linear_meter'] = 0;
        }
        
        // Linear Meter + Waste Percentage
        if ($workOrder->waste_percentage && $calculations['net_linear_meter'] > 0) {
            $calculations['linear_meter_with_waste'] = $calculations['net_linear_meter'] * (1 + ($workOrder->waste_percentage / 100));
        } else {
            $calculations['linear_meter_with_waste'] = $calculations['net_linear_meter'];
        }
        
        // Square Meter = (Paper Width in cm / 100) * (Linear Meter)
        if ($workOrder->paper_width && $calculations['net_linear_meter'] > 0) {
            $calculations['square_meter'] = ($workOrder->paper_width / 100) * $calculations['net_linear_meter'];
        } else {
            $calculations['square_meter'] = 0;
        }
        
        // Weight calculation (if paper weight is available)
        if ($workOrder->paper_weight && $calculations['square_meter'] > 0) {
            $calculations['weight'] = $calculations['square_meter'] * $workOrder->paper_weight;
        } else {
            $calculations['weight'] = $workOrder->paper_weight ?? 0;
        }
        
        // Number of turns/wraps for rolls (approximate calculation)
        if ($workOrder->number_of_rolls && $workOrder->core_size && $workOrder->paper_width) {
            // Approximate: based on roll diameter and paper width
            $rollDiameter = $workOrder->core_size; // Starting diameter
            $calculations['number_of_turns'] = 0; // Complex calculation, placeholder
        }
        
        // Pieces per roll
        if ($workOrder->number_of_rolls && $workOrder->number_of_rolls > 0) {
            $calculations['pieces_per_roll'] = $workOrder->quantity / $workOrder->number_of_rolls;
        } else {
            $calculations['pieces_per_roll'] = $workOrder->quantity;
        }
        
        return $calculations;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkOrder $workOrder)
    {
        $clients = Client::orderBy('name')->get();
        $materials = Material::where('is_active', true)->orderBy('name')->get();
        $additions = \App\Models\Addition::orderBy('name')->get();
        return view('work-orders.edit', compact('workOrder', 'clients', 'materials', 'additions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'order_number' => 'nullable|string|max:255|unique:work_orders,order_number,' . $workOrder->id,
            'job_name' => 'nullable|string|max:255',
            'number_of_colors' => 'required|integer|min:0|max:6',
            'rows_count' => 'nullable|integer|min:1',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'final_product_shape' => 'nullable|string',
            'additions' => 'nullable|string',
            'addition_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->additions && $request->additions !== 'لا يوجد' && $value !== null) {
                        $addition = \App\Models\Addition::where('name', $request->additions)->first();
                        if ($addition && $value < $addition->price) {
                            $fail('سعر الإضافة يجب أن يكون أكبر من أو يساوي السعر الافتراضي (' . number_format($addition->price, 2) . ' ج.م)');
                        }
                    }
                },
            ],
            'fingerprint' => 'nullable|in:yes,no',
            'fingerprint_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->fingerprint === 'yes' && empty($value)) {
                        $fail('سعر البصمة مطلوب عند اختيار وجود البصمة');
                    }
                },
            ],
            'winding_direction' => 'nullable|in:no,clockwise,counterclockwise',
            'knife_exists' => 'nullable|in:yes,no',
            'knife_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->knife_exists === 'yes' && empty($value)) {
                        $fail('سعر السكينة مطلوب عند اختيار وجود السكينة');
                    }
                },
            ],
            'external_breaking' => 'nullable|in:yes,no',
            'external_breaking_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->external_breaking === 'yes' && empty($value)) {
                        $fail('سعر التكسير الخارجي مطلوب عند اختيار وجود التكسير الخارجي');
                    }
                },
            ],
            'film_price' => 'nullable|numeric|min:0',
            'film_count' => 'nullable|integer|min:1',
            'sales_percentage' => 'nullable|numeric|min:0|max:100',
            'material_price_per_meter' => 'nullable|numeric|min:0',
            'manufacturing_price_per_meter' => 'nullable|numeric|min:0',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|in:76,40,25',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
            'paper_width' => 'nullable|numeric|min:0',
            'gap_count' => 'nullable|numeric|min:0',
            'waste_per_roll' => 'nullable|integer|min:0',
            'increase' => 'nullable|numeric|min:0',
            'linear_meter' => 'nullable|numeric|min:0',
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
