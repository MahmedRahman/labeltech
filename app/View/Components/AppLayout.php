<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Models\WorkOrder;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // Get counts for sidebar navigation (only for sales employees and admin)
        $priceQuotesCount = 0;
        $proofsCount = 0;
        $preparationsCount = 0;
        $productionCount = 0;
        $archiveCount = 0;
        $sentToDesignerCount = 0;
        $designerWorkOrdersCount = 0;

        if (auth('employee')->check()) {
            $employee = auth('employee')->user();
            $isSalesEmployee = $employee->account_type === 'مبيعات';
            $isDesignEmployee = $employee->account_type === 'تصميم';
            
            if ($isSalesEmployee || auth('web')->check()) {
                // Price quotes count (status != work_order and != cancelled)
                $priceQuotesQuery = WorkOrder::where('status', '!=', 'work_order')
                    ->where('status', '!=', 'cancelled');
                
                // Filter by employee if sales employee
                if ($isSalesEmployee) {
                    $priceQuotesQuery->where('created_by', $employee->name);
                }
                
                $priceQuotesCount = $priceQuotesQuery->count();

                // Proofs count (status = work_order)
                $proofsQuery = WorkOrder::where('status', 'work_order');
                
                if ($isSalesEmployee) {
                    $proofsQuery->where('created_by', $employee->name);
                }
                
                $proofsCount = $proofsQuery->count();

                // Archive count (status = cancelled)
                $archiveQuery = WorkOrder::where('status', 'cancelled');
                
                if ($isSalesEmployee) {
                    $archiveQuery->where('created_by', $employee->name);
                }
                
                $archiveCount = $archiveQuery->count();

                // Preparations count (status = in_progress)
                $preparationsQuery = WorkOrder::where('status', 'in_progress');
                
                if ($isSalesEmployee) {
                    $preparationsQuery->where('created_by', $employee->name);
                }
                
                $preparationsCount = $preparationsQuery->count();

                // Production count (status = completed)
                $productionQuery = WorkOrder::where('status', 'completed');
                
                if ($isSalesEmployee) {
                    $productionQuery->where('created_by', $employee->name);
                }
                
                $productionCount = $productionQuery->count();

                // Sent to designer count (sent_to_designer = yes and status = work_order)
                $sentToDesignerQuery = WorkOrder::where('sent_to_designer', 'yes')
                    ->where('status', 'work_order');
                
                if ($isSalesEmployee) {
                    $sentToDesignerQuery->where('created_by', $employee->name);
                }
                
                $sentToDesignerCount = $sentToDesignerQuery->count();
            }
            
            // Designer work orders count (for design employees)
            if ($isDesignEmployee) {
                $designerWorkOrdersCount = WorkOrder::where('sent_to_designer', 'yes')
                    ->where('status', 'work_order')
                    ->count();
                
                // Preparations count for designers (all in_progress orders)
                $preparationsCount = WorkOrder::where('status', 'in_progress')->count();
            }
        } elseif (auth('web')->check()) {
            // Admin users see all counts
            $priceQuotesCount = WorkOrder::where('status', '!=', 'work_order')
                ->where('status', '!=', 'cancelled')
                ->count();
            
            $proofsCount = WorkOrder::where('status', 'work_order')->count();
            $preparationsCount = WorkOrder::where('status', 'in_progress')->count();
            $productionCount = WorkOrder::where('status', 'completed')->count();
            $archiveCount = WorkOrder::where('status', 'cancelled')->count();
            $sentToDesignerCount = WorkOrder::where('sent_to_designer', 'yes')
                ->where('status', 'work_order')
                ->count();
        }

        return view('layouts.app', [
            'priceQuotesCount' => $priceQuotesCount,
            'proofsCount' => $proofsCount,
            'preparationsCount' => $preparationsCount,
            'productionCount' => $productionCount,
            'archiveCount' => $archiveCount,
            'sentToDesignerCount' => $sentToDesignerCount,
            'designerWorkOrdersCount' => $designerWorkOrdersCount,
        ]);
    }
}
