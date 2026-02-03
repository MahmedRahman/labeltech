<?php

namespace App\Http\Controllers;

use App\Models\Representative;
use Illuminate\Http\Request;

class RepresentativeController extends Controller
{
    /**
     * Display representatives list (production employee only).
     */
    public function index()
    {
        $employee = auth('employee')->user();
        if (!$employee || $employee->account_type !== 'تشغيل') {
            abort(403);
        }

        $representatives = Representative::latest()->get();
        return view('employee.representatives-index', compact('representatives'));
    }

    /**
     * Store a newly created representative (production employee only).
     */
    public function store(Request $request)
    {
        $employee = auth('employee')->user();
        if (!$employee || $employee->account_type !== 'تشغيل') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        Representative::create($validated);

        return redirect()->back()->with('success', 'تم إضافة المندوب بنجاح');
    }

    /**
     * Remove the specified representative (production employee only).
     */
    public function destroy(Representative $representative)
    {
        $employee = auth('employee')->user();
        if (!$employee || $employee->account_type !== 'تشغيل') {
            abort(403);
        }

        $representative->delete();

        return redirect()->back()->with('success', 'تم حذف المندوب بنجاح');
    }
}
