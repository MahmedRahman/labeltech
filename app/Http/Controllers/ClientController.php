<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::query();

        // Check if logged in as employee with sales account type
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        
        // If employee is from sales team, filter clients by their team
        if ($employee && $employee->account_type === 'مبيعات' && !$isAdmin) {
            // Get employee's sales teams
            $employee->load('salesTeams');
            $teamIds = $employee->salesTeams->pluck('id')->toArray();
            
            if (!empty($teamIds)) {
                // Filter clients that belong to employee's teams
                $query->whereHas('salesTeams', function($q) use ($teamIds) {
                    $q->whereIn('sales_teams.id', $teamIds);
                });
            } else {
                // If employee has no teams, show no clients
                $query->whereRaw('1 = 0');
            }
        }

        // Filter by name
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // فلتر: العملاء اللي شغالين كمندوب فقط
        if ($request->boolean('representatives_only')) {
            $query->where('is_representative', true);
        }

        $clients = $query->with('salesTeams')->latest()->paginate(10)->withQueryString();

        // Get employee info for display
        $employeeTeams = null;
        if ($employee && $employee->account_type === 'مبيعات' && !$isAdmin) {
            $employee->load('salesTeams');
            $employeeTeams = $employee->salesTeams;
        }

        return view('clients.index', compact('clients', 'employeeTeams', 'employee', 'isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'opening_balance' => 'nullable|numeric|min:0',
            'is_representative' => 'nullable|boolean',
        ]);
        $validated['is_representative'] = (bool) ($request->input('is_representative', false));

        // Create the client
        $client = Client::create($validated);

        // If logged in as sales employee, attach client to employee's sales teams
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        
        if ($employee && $employee->account_type === 'مبيعات' && !$isAdmin) {
            // Get employee's sales teams
            $employee->load('salesTeams');
            $teamIds = $employee->salesTeams->pluck('id')->toArray();
            
            if (!empty($teamIds)) {
                // Attach client to employee's sales teams
                $client->salesTeams()->sync($teamIds);
            }
        }

        return redirect()->route('clients.index')
            ->with('success', 'تم إضافة العميل بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        // Get employee info for display
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        
        return view('clients.show', compact('client', 'employee', 'isAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        // Check if logged in as sales employee (not admin)
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        
        if ($employee && $employee->account_type === 'مبيعات' && !$isAdmin) {
            abort(403, 'ليس لديك صلاحية لتعديل العملاء');
        }
        
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        // Check if logged in as sales employee (not admin)
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        
        if ($employee && $employee->account_type === 'مبيعات' && !$isAdmin) {
            abort(403, 'ليس لديك صلاحية لتعديل العملاء');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'opening_balance' => 'nullable|numeric|min:0',
            'is_representative' => 'nullable|boolean',
        ]);
        $validated['is_representative'] = (bool) ($request->input('is_representative', false));

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        // Check if logged in as sales employee (not admin)
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        
        if ($employee && $employee->account_type === 'مبيعات' && !$isAdmin) {
            abort(403, 'ليس لديك صلاحية لحذف العملاء');
        }
        
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'تم حذف العميل بنجاح');
    }
}
