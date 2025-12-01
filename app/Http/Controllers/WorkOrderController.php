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
        $workOrders = WorkOrder::with('client')->latest()->paginate(10);
        return view('work-orders.index', compact('workOrders'));
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
        
        // Calculate production values if production data exists
        $calculations = [];
        if ($workOrder->has_production) {
            $calculations = $this->calculateProduction($workOrder);
        }
        
        return view('work-orders.show', compact('workOrder', 'calculations'));
    }

    /**
     * Calculate production values based on work order data.
     */
    private function calculateProduction(WorkOrder $workOrder): array
    {
        $calculations = [];
        
        // Basic paper calculations
        $paperWidth = $workOrder->paper_width ?? 0; // in cm
        $paperWeight = $workOrder->paper_weight ?? 0; // grams per m²
        $wastePercentage = $workOrder->waste_percentage ?? 0; // percentage
        $quantity = $workOrder->quantity ?? 0; // sets count
        $width = $workOrder->width ?? 0; // product width in cm
        $length = $workOrder->length ?? 0; // product length in cm
        
        // Convert cm to meters
        $widthM = $width / 100;
        $lengthM = $length / 100;
        $paperWidthM = $paperWidth / 100;
        
        // 1. Net linear meters (per piece)
        $netLinearMetersPerPiece = $lengthM;
        
        // 2. Linear meters with waste (per piece)
        $linearMetersWithWastePerPiece = $netLinearMetersPerPiece * (1 + ($wastePercentage / 100));
        
        // 3. Square meters (per piece)
        $squareMetersPerPiece = $widthM * $lengthM;
        
        // 4. Total weight calculations
        $totalSquareMeters = $squareMetersPerPiece * $quantity;
        $totalWeightKg = ($totalSquareMeters * $paperWeight) / 1000;
        $totalWeightTon = $totalWeightKg / 1000;
        
        // Total linear meters with waste for all pieces
        $totalLinearMetersWithWaste = $linearMetersWithWastePerPiece * $quantity;
        
        $calculations['basic'] = [
            'net_linear_meters' => $netLinearMetersPerPiece,
            'linear_meters_with_waste' => $linearMetersWithWastePerPiece,
            'total_linear_meters_with_waste' => $totalLinearMetersWithWaste,
            'square_meters_per_piece' => $squareMetersPerPiece,
            'total_square_meters' => $totalSquareMeters,
            'total_weight_kg' => $totalWeightKg,
            'total_weight_ton' => $totalWeightTon,
        ];
        
        // Roll calculations (if final_product_shape is 'بكر')
        if ($workOrder->final_product_shape == 'بكر') {
            $numberOfRolls = $workOrder->number_of_rolls ?? 0;
            $coreSize = $workOrder->core_size ?? 0; // in cm
            
            // 5. Roll size = paper width / appropriate repeat count
            // Calculate repeat count based on paper width and product width
            $repeatCount = 32; // Default
            if ($paperWidth > 0 && $width > 0) {
                $repeatCount = floor($paperWidth / $width);
            }
            
            // Roll size is the product width (after cutting)
            $rollSize = $width;
            
            // 6. Repeat count for cutting
            $cuttingRepeatCount = $repeatCount;
            
            // 7. Output per roll (pieces per roll)
            // Estimate roll length: standard rolls are typically 1000-2000 meters
            // We'll use a standard 1000m roll length, but this should ideally come from user input
            $standardRollLengthM = 1000; // meters
            $outputPerRoll = $linearMetersWithWastePerPiece > 0 ? floor($standardRollLengthM / $linearMetersWithWastePerPiece) : 0;
            
            // 8. Total meters per roll (assuming standard roll length)
            $totalMetersPerRoll = $standardRollLengthM;
            
            // 9. Total pieces per roll
            $totalPiecesPerRoll = $outputPerRoll * $cuttingRepeatCount; // pieces across width × pieces along length
            
            // 10. Total sets from roll (assuming 1 piece = 1 set, or adjust based on business logic)
            $totalSetsFromRoll = $totalPiecesPerRoll;
            
            $calculations['roll'] = [
                'roll_size' => $rollSize,
                'cutting_repeat_count' => $cuttingRepeatCount,
                'output_per_roll' => $outputPerRoll,
                'total_meters_per_roll' => $totalMetersPerRoll,
                'total_pieces_per_roll' => $totalPiecesPerRoll,
                'total_sets_from_roll' => $totalSetsFromRoll,
                'number_of_rolls' => $numberOfRolls,
                'core_size' => $coreSize,
            ];
        }
        
        // Sheet calculations (if final_product_shape is 'شيت')
        if ($workOrder->final_product_shape == 'شيت') {
            $piecesPerSheet = $workOrder->pieces_per_sheet ?? 0;
            $sheetsPerStack = $workOrder->sheets_per_stack ?? 0;
            $piecesPerStack = $workOrder->pieces_per_stack ?? 0;
            
            // 11. Sheets per stack (from data)
            // 12. Pieces per sheet (from data)
            // 13. Total pieces per stack
            $calculatedPiecesPerStack = $piecesPerSheet * $sheetsPerStack;
            $finalPiecesPerStack = $piecesPerStack > 0 ? $piecesPerStack : $calculatedPiecesPerStack;
            
            // 14. Total pieces needed for sets (assuming 1 piece = 1 set)
            $totalPiecesNeeded = $quantity;
            
            // 15. Total sheets needed
            $totalSheetsNeeded = $piecesPerSheet > 0 ? ceil($totalPiecesNeeded / $piecesPerSheet) : 0;
            
            // 16. Total stacks needed
            $totalStacksNeeded = $finalPiecesPerStack > 0 ? ceil($totalPiecesNeeded / $finalPiecesPerStack) : 0;
            
            $calculations['sheet'] = [
                'sheets_per_stack' => $sheetsPerStack,
                'pieces_per_sheet' => $piecesPerSheet,
                'pieces_per_stack' => $finalPiecesPerStack,
                'total_pieces_needed' => $totalPiecesNeeded,
                'total_sheets_needed' => $totalSheetsNeeded,
                'total_stacks_needed' => $totalStacksNeeded,
            ];
        }
        
        // Final results
        $actualWasteConsumed = ($linearMetersWithWastePerPiece - $netLinearMetersPerPiece) * $quantity;
        
        $calculations['final'] = [
            'total_production' => $quantity,
            'actual_waste_consumed' => $actualWasteConsumed,
            'rolls_needed' => $workOrder->final_product_shape == 'بكر' ? ($workOrder->number_of_rolls ?? 0) : null,
            'stacks_needed' => $workOrder->final_product_shape == 'شيت' ? ($calculations['sheet']['total_stacks_needed'] ?? 0) : null,
        ];
        
        return $calculations;
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
        $workOrder->load('client');
        return view('work-orders.design', compact('workOrder'));
    }

    /**
     * Store design data for the work order.
     */
    public function storeDesign(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'design_shape' => 'nullable|in:مستطيل,دائرة,مربع,بيضاوي,شكل خاص',
            'design_films' => 'nullable|string|max:255',
            'design_knives' => 'nullable|string|max:255',
            'design_drills' => 'nullable|string|max:255',
            'design_breaking_gear' => 'nullable|string|max:255',
            'design_gab' => 'nullable|string|max:255',
            'design_cliches' => 'nullable|string|max:255',
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
        $hasDesign = !empty($validated['design_shape']) || 
                     !empty($validated['design_films']) || 
                     !empty($validated['design_knives']) || 
                     !empty($validated['design_drills']) || 
                     !empty($validated['design_breaking_gear']) || 
                     !empty($validated['design_gab']) || 
                     !empty($validated['design_cliches']) || 
                     !empty($validated['design_file']);
        
        $validated['has_design'] = $hasDesign;

        $workOrder->update($validated);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم إضافة بيانات التصميم بنجاح');
    }

    /**
     * Show the form for adding/editing production data.
     */
    public function showProductionForm(WorkOrder $workOrder)
    {
        $workOrder->load('client');
        return view('work-orders.production', compact('workOrder'));
    }

    /**
     * Store production data for the work order.
     */
    public function storeProduction(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'paper_width' => 'nullable|numeric|min:0',
            'paper_weight' => 'nullable|numeric|min:0',
            'waste_percentage' => 'nullable|numeric|min:0|max:100',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|in:76,40,25',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
            'pieces_per_stack' => 'nullable|integer|min:1',
        ]);

        // Check if production data exists
        $hasProduction = !empty($validated['paper_width']) || 
                       !empty($validated['paper_weight']) || 
                       !empty($validated['waste_percentage']) || 
                       !empty($validated['number_of_rolls']) || 
                       !empty($validated['core_size']) || 
                       !empty($validated['pieces_per_sheet']) || 
                       !empty($validated['sheets_per_stack']) || 
                       !empty($validated['pieces_per_stack']);
        
        $validated['has_production'] = $hasProduction;

        $workOrder->update($validated);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم إضافة بيانات التشغيل بنجاح');
    }
}
