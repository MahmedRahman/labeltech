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

        // Filter by dragile_drive
        if ($request->filled('filter_dragile_drive')) {
            $query->where('dragile_drive', $request->filter_dragile_drive);
        }

        $knives = $query->latest()->paginate(20)->appends($request->query());
        $totalKnives = Knife::count();
        
        // Get unique values for filter dropdowns
        $types = Knife::distinct()->whereNotNull('type')->pluck('type')->sort()->values();
        
        // Get filtered values based on selected type
        $widths = [];
        $lengths = [];
        $dragileDrives = [];
        
        if ($request->filled('filter_type')) {
            $filterQuery = Knife::where('type', $request->filter_type);
            $widths = $filterQuery->distinct()->whereNotNull('width')->pluck('width')->sort()->values();
            $lengths = $filterQuery->distinct()->whereNotNull('length')->pluck('length')->sort()->values();
            $dragileDrives = $filterQuery->distinct()->whereNotNull('dragile_drive')->pluck('dragile_drive')->sort()->values();
        }
        
        return view('knives.index', compact('knives', 'totalKnives', 'types', 'widths', 'lengths', 'dragileDrives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('knives.create');
    }

    /**
     * Get next knife code for a given type (AJAX)
     */
    public function getNextKnifeCode(Request $request)
    {
        $type = $request->input('type');
        
        if (empty($type)) {
            return response()->json(['knife_code' => '']);
        }

        $knifeCode = $this->generateKnifeCode($type);
        
        return response()->json(['knife_code' => $knifeCode]);
    }

    /**
     * Get filter values for a given type (AJAX)
     */
    public function getFilterValues(Request $request)
    {
        $type = $request->input('type');
        
        if (empty($type)) {
            return response()->json([
                'lengths' => [],
                'widths' => [],
                'dragileDrives' => []
            ]);
        }

        $query = Knife::where('type', $type);
        
        $lengths = $query->distinct()->whereNotNull('length')->pluck('length')->sort()->values()->map(function($length) {
            return ['value' => $length, 'label' => number_format($length, 2)];
        });
        
        $widths = $query->distinct()->whereNotNull('width')->pluck('width')->sort()->values()->map(function($width) {
            return ['value' => $width, 'label' => number_format($width, 2)];
        });
        
        $dragileDrives = $query->distinct()->whereNotNull('dragile_drive')->pluck('dragile_drive')->sort()->values()->map(function($drive) {
            return ['value' => $drive, 'label' => $drive];
        });
        
        return response()->json([
            'lengths' => $lengths,
            'widths' => $widths,
            'dragileDrives' => $dragileDrives
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:مستطيل,دائرة,مربع,بيضاوي,شكل خاص',
            'gear' => 'nullable|integer|min:0|max:999',
            'dragile_drive' => 'required|numeric|min:0|max:999',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|numeric',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'knife_code' => 'nullable|string|max:255|unique:knives,knife_code',
            'notes' => 'nullable|string',
        ]);

        // Generate knife code automatically if not provided
        if (empty($validated['knife_code']) && !empty($validated['type'])) {
            $validated['knife_code'] = $this->generateKnifeCode($validated['type']);
        }

        // If still no code, generate a default one
        if (empty($validated['knife_code'])) {
            $validated['knife_code'] = $this->generateKnifeCode('مستطيل');
        }

        Knife::create($validated);

        return redirect()->route('knives.index')
            ->with('success', 'تم إضافة السكينة بنجاح');
    }

    /**
     * Generate automatic knife code based on type
     */
    private function generateKnifeCode($type)
    {
        // Map type to prefix
        $prefixMap = [
            'مستطيل' => 'M',
            'دائرة' => 'D',
            'مربع' => 'S',
            'بيضاوي' => 'O',
            'شكل خاص' => 'C',
        ];

        $prefix = $prefixMap[$type] ?? 'K';

        // Get all knives with this prefix
        $knives = Knife::where('type', $type)
            ->where('knife_code', 'like', $prefix . '-%')
            ->get();

        $maxNumber = 0;
        foreach ($knives as $knife) {
            if (preg_match('/^' . preg_quote($prefix, '/') . '-(\d+)$/', $knife->knife_code, $matches)) {
                $number = (int)$matches[1];
                if ($number > $maxNumber) {
                    $maxNumber = $number;
                }
            }
        }

        $nextNumber = $maxNumber + 1;

        return $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
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
            'type' => 'required|in:مستطيل,دائرة,مربع,بيضاوي,شكل خاص',
            'gear' => 'nullable|integer|min:0|max:999',
            'dragile_drive' => 'required|numeric|min:0|max:999',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|numeric',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
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

    /**
     * Export knives to CSV
     */
    public function export(Request $request)
    {
        $query = Knife::query();

        // Apply same filters as index
        if ($request->filled('filter_type')) {
            $query->where('type', $request->filter_type);
        }

        if ($request->filled('filter_width')) {
            $query->where('width', $request->filter_width);
        }

        if ($request->filled('filter_length')) {
            $query->where('length', $request->filter_length);
        }

        if ($request->filled('filter_dragile_drive')) {
            $query->where('dragile_drive', $request->filter_dragile_drive);
        }

        $knives = $query->orderBy('knife_code')->get();

        $filename = 'knives_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($knives) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers (without الجاب as it's calculated automatically)
            fputcsv($file, [
                'الرقم الكود',
                'النوع',
                'تُرس',
                'درافيل',
                'عدد الصفوف',
                'عدد العيون',
                'الطول',
                'العرض',
                'الملاحظات'
            ]);

            // Add data (without flap_size as it's calculated automatically)
            foreach ($knives as $knife) {
                fputcsv($file, [
                    $knife->knife_code ?? '',
                    $knife->type ?? '',
                    $knife->gear ?? '',
                    $knife->dragile_drive ?? '',
                    $knife->rows_count ?? '',
                    $knife->eyes_count ?? '',
                    $knife->length ?? '',
                    $knife->width ?? '',
                    $knife->notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import knives from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $data = array_map('str_getcsv', file($path));
        
        // Remove BOM if present
        if (!empty($data[0][0])) {
            $data[0][0] = preg_replace('/\x{EF}\x{BB}\x{BF}/u', '', $data[0][0]);
        }
        
        // Remove header row
        $header = array_shift($data);
        
        // Find column indices by header name (to support flexible column order)
        $headerMap = [];
        foreach ($header as $idx => $col) {
            $col = trim($col);
            $headerMap[$col] = $idx;
        }
        
        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Helper function to get value by header name or index
            $getValue = function($key, $defaultIndex = null) use ($row, $headerMap) {
                if (isset($headerMap[$key])) {
                    return isset($row[$headerMap[$key]]) ? trim($row[$headerMap[$key]]) : null;
                }
                return $defaultIndex !== null && isset($row[$defaultIndex]) ? trim($row[$defaultIndex]) : null;
            };

            // Map CSV columns to database fields (without flap_size - it will be calculated)
            $knifeData = [
                'knife_code' => $getValue('الرقم الكود', 0),
                'type' => $getValue('النوع', 1),
                'gear' => $getValue('تُرس', 2),
                'dragile_drive' => $getValue('درافيل', 3) ?: $getValue('دراغيل', 3), // Support both spellings
                'rows_count' => ($val = $getValue('عدد الصفوف', 4)) && $val !== '' ? (int)$val : null,
                'eyes_count' => ($val = $getValue('عدد العيون', 5)) && $val !== '' ? (int)$val : null,
                'length' => ($val = $getValue('الطول', 6)) && $val !== '' ? (float)$val : null,
                'width' => ($val = $getValue('العرض', 7)) && $val !== '' ? (float)$val : null,
                'notes' => $getValue('الملاحظات', 8),
            ];
            
            // Calculate flap_size automatically if dragile_drive and length are provided
            if (!empty($knifeData['dragile_drive']) && !empty($knifeData['length'])) {
                $dragileDrive = (float)$knifeData['dragile_drive'];
                $length = (float)$knifeData['length'];
                
                if ($dragileDrive > 0 && $length > 0) {
                    // Formula: (((3.175 * dragileDrive / 10) / INT(3.175 * dragileDrive / (length + 0.2) / 10)) - length) * 10
                    $numerator = (3.175 * $dragileDrive / 10);
                    $denominator = floor(3.175 * $dragileDrive / ($length + 0.2) / 10);
                    
                    if ($denominator != 0) {
                        $knifeData['flap_size'] = round((($numerator / $denominator) - $length) * 10, 3);
                    }
                }
            }

            // Validate knife_code is required
            if (empty($knifeData['knife_code'])) {
                $skipped++;
                $errors[] = "السطر " . ($index + 2) . ": الرقم الكود مطلوب";
                continue;
            }

            // Check if knife_code already exists
            $existingKnife = Knife::where('knife_code', $knifeData['knife_code'])->first();
            
            if ($existingKnife) {
                // Update existing knife
                try {
                    $existingKnife->update($knifeData);
                    $imported++;
                } catch (\Exception $e) {
                    $skipped++;
                    $errors[] = "السطر " . ($index + 2) . ": " . $e->getMessage();
                }
            } else {
                // Create new knife
                try {
                    Knife::create($knifeData);
                    $imported++;
                } catch (\Exception $e) {
                    $skipped++;
                    $errors[] = "السطر " . ($index + 2) . ": " . $e->getMessage();
                }
            }
        }

        $message = "تم استيراد {$imported} سكينة بنجاح";
        if ($skipped > 0) {
            $message .= "، تم تخطي {$skipped} سطر";
        }

        return redirect()->route('knives.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }
}
