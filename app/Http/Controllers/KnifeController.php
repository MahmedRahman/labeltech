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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:مستطيل,دائرة,مربع,بيضاوي,شكل خاص',
            'gear' => 'nullable|string|max:255',
            'dragile_drive' => 'nullable|string|max:255',
            'rows_count' => 'nullable|integer|min:0',
            'eyes_count' => 'nullable|integer|min:0',
            'flap_size' => 'nullable|string|max:255',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
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

    /**
     * Export knives to CSV
     */
    public function export()
    {
        $knives = Knife::orderBy('knife_code')->get();

        $filename = 'knives_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($knives) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($file, [
                'الرقم الكود',
                'النوع',
                'تُرس',
                'دراغيل',
                'عدد الصفوف',
                'عدد العيون',
                'الجيب',
                'الطول',
                'العرض',
                'الملاحظات'
            ]);

            // Add data
            foreach ($knives as $knife) {
                fputcsv($file, [
                    $knife->knife_code ?? '',
                    $knife->type ?? '',
                    $knife->gear ?? '',
                    $knife->dragile_drive ?? '',
                    $knife->rows_count ?? '',
                    $knife->eyes_count ?? '',
                    $knife->flap_size ?? '',
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
        
        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Map CSV columns to database fields
            $knifeData = [
                'knife_code' => isset($row[0]) ? trim($row[0]) : null,
                'type' => isset($row[1]) ? trim($row[1]) : null,
                'gear' => isset($row[2]) ? trim($row[2]) : null,
                'dragile_drive' => isset($row[3]) ? trim($row[3]) : null,
                'rows_count' => isset($row[4]) && $row[4] !== '' ? (int)$row[4] : null,
                'eyes_count' => isset($row[5]) && $row[5] !== '' ? (int)$row[5] : null,
                'flap_size' => isset($row[6]) ? trim($row[6]) : null,
                'length' => isset($row[7]) && $row[7] !== '' ? (float)$row[7] : null,
                'width' => isset($row[8]) && $row[8] !== '' ? (float)$row[8] : null,
                'notes' => isset($row[9]) ? trim($row[9]) : null,
            ];

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
