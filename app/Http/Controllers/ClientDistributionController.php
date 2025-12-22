<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SalesTeam;
use Illuminate\Http\Request;

class ClientDistributionController extends Controller
{
    /**
     * Display the client distribution page.
     */
    public function index()
    {
        $clients = Client::with('salesTeams')->orderBy('name')->get();
        $salesTeams = SalesTeam::with('clients')->orderBy('name')->get();
        $unassignedClients = $clients->filter(function ($client) {
            return $client->salesTeams->isEmpty();
        });
        $assignedClients = $clients->filter(function ($client) {
            return $client->salesTeams->isNotEmpty();
        });
        
        $assignedCount = $assignedClients->count();
        $unassignedCount = $unassignedClients->count();
        $totalCount = $clients->count();
        
        return view('client-distribution.index', compact('clients', 'salesTeams', 'unassignedClients', 'assignedCount', 'unassignedCount', 'totalCount'));
    }

    /**
     * Store client distribution.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sales_team_ids' => 'nullable|array',
            'sales_team_ids.*' => 'exists:sales_teams,id',
        ]);

        $client = Client::findOrFail($validated['client_id']);
        
        if (isset($validated['sales_team_ids'])) {
            $client->salesTeams()->sync($validated['sales_team_ids']);
        } else {
            $client->salesTeams()->detach();
        }

        return redirect()->route('client-distribution.index')
            ->with('success', 'تم توزيع العميل على فرق المبيعات بنجاح');
    }

    /**
     * Update client distribution.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'sales_team_ids' => 'nullable|array',
            'sales_team_ids.*' => 'exists:sales_teams,id',
        ]);

        if (isset($validated['sales_team_ids']) && !empty($validated['sales_team_ids'])) {
            $client->salesTeams()->sync($validated['sales_team_ids']);
        } else {
            $client->salesTeams()->detach();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث توزيع العميل بنجاح'
            ]);
        }

        return redirect()->route('client-distribution.index')
            ->with('success', 'تم تحديث توزيع العميل بنجاح');
    }
}

