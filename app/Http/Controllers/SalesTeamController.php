<?php

namespace App\Http\Controllers;

use App\Models\SalesTeam;
use App\Models\Employee;
use Illuminate\Http\Request;

class SalesTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesTeams = SalesTeam::with('employees')->latest()->get();
        return view('sales-teams.index', compact('salesTeams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('account_type', 'مبيعات')->orderBy('name')->get();
        return view('sales-teams.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        $salesTeam = SalesTeam::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (!empty($validated['employee_ids'])) {
            $salesTeam->employees()->attach($validated['employee_ids']);
        }

        return redirect()->route('sales-teams.index')
            ->with('success', 'تم إنشاء فريق المبيعات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesTeam $salesTeam)
    {
        $salesTeam->load('employees');
        return view('sales-teams.show', compact('salesTeam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesTeam $salesTeam)
    {
        $employees = Employee::where('account_type', 'مبيعات')->orderBy('name')->get();
        $salesTeam->load('employees');
        return view('sales-teams.edit', compact('salesTeam', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesTeam $salesTeam)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'employee_ids' => 'nullable|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        $salesTeam->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        if (isset($validated['employee_ids'])) {
            $salesTeam->employees()->sync($validated['employee_ids']);
        } else {
            $salesTeam->employees()->detach();
        }

        return redirect()->route('sales-teams.index')
            ->with('success', 'تم تحديث فريق المبيعات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesTeam $salesTeam)
    {
        $salesTeam->delete();
        return redirect()->route('sales-teams.index')
            ->with('success', 'تم حذف فريق المبيعات بنجاح');
    }
}
