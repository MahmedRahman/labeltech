<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\Client;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WorkOrder::with('client')
            ->where(function($q) {
                $q->whereNull('production_status')
                  ->orWhere('production_status', 'بدون حالة')
                  ->orWhereIn('production_status', ['طباعة', 'قص', 'تقفيل']);
            })
            ->where(function($q) {
                // Exclude work_order and cancelled statuses from main index (they have their own pages)
                $q->where(function($subQ) {
                    $subQ->where('status', '!=', 'work_order')
                         ->where('status', '!=', 'cancelled');
                })->orWhereNull('status');
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

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number (رقم عرض السعر)
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->limit(1000)->get();
        
        // Initialize groups (optimized - single pass)
        $groupedOrders = [
            'بدون حالة' => collect(),
            'طباعة' => collect(),
            'قص' => collect(),
            'تقفيل' => collect(),
        ];

        $statusGroups = [
            'draft' => collect(),
            'pending' => collect(),
            'client_approved' => collect(),
            'client_rejected' => collect(),
            'client_no_response' => collect(),
            'work_order' => collect(),
            'in_progress' => collect(),
            'completed' => collect(),
            'cancelled' => collect(),
        ];

        $sentCount = 0;
        $notSentCount = 0;

        // Single pass through work orders to group and count
        foreach ($workOrders as $order) {
            if (is_null($order->id)) {
                continue;
            }

            // Group by production status
            $prodStatus = $order->production_status ?? 'بدون حالة';
            if (isset($groupedOrders[$prodStatus])) {
                $groupedOrders[$prodStatus]->push($order);
            } elseif (is_null($order->production_status)) {
                $groupedOrders['بدون حالة']->push($order);
            }

            // Group by status
            $status = $order->status ?? 'draft';
            if (isset($statusGroups[$status])) {
                $statusGroups[$status]->push($order);
            }

            // Count sent/not sent
            $sentToClient = $order->sent_to_client ?? 'no';
            if ($sentToClient === 'yes') {
                $sentCount++;
            } else {
                $notSentCount++;
            }
        }

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Check if there's a pending price quote sent to client
        $hasPendingQuote = WorkOrder::where('sent_to_client', 'yes')
            ->where(function($q) {
                $q->whereNull('client_response')
                  ->orWhere('client_response', '');
            })
            ->exists();

        return view('work-orders.index', compact('groupedOrders', 'workOrders', 'clients', 'statusGroups', 'sentCount', 'notSentCount', 'hasPendingQuote'));
    }

    /**
     * Display archived work orders (cancelled status).
     */
    public function archive(Request $request)
    {
        $query = WorkOrder::with('client')
            ->where('status', 'cancelled');

        // Filter work orders based on user type:
        // - Employees: show only work orders they created
        // - Admin (web guard): show all work orders (no filter)
        if (auth('employee')->check()) {
            $employeeName = auth('employee')->user()->name;
            $query->where('created_by', $employeeName);
        }
        // Admin users (auth('web')->check()) will see all work orders
        // No additional filter is applied for admin users

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        return view('work-orders.archive', compact('workOrders', 'clients'));
    }

    /**
     * Display work orders list (status = work_order).
     */
    public function workOrdersList(Request $request)
    {
        $query = WorkOrder::with('client')
            ->where('status', 'work_order');

        // Filter work orders based on user type:
        // - Employees: show only work orders they created
        // - Admin (web guard): show all work orders (no filter)
        if (auth('employee')->check()) {
            $employeeName = auth('employee')->user()->name;
            $query->where('created_by', $employeeName);
        }
        // Admin users (auth('web')->check()) will see all work orders
        // No additional filter is applied for admin users

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Calculate statistics
        $totalCount = $workOrders->count();
        
        // Count work orders where client approved the design (client_design_approval === 'موافق')
        $approvedCount = $workOrders->filter(function($order) {
            return ($order->client_design_approval ?? '') === 'موافق';
        })->count();
        
        // Count work orders where preparations were not requested (client_design_approval != 'موافق')
        $notRequestedPreparationsCount = $workOrders->filter(function($order) {
            return ($order->client_design_approval ?? '') !== 'موافق';
        })->count();

        return view('work-orders.work-orders-list', compact('workOrders', 'clients', 'totalCount', 'approvedCount', 'notRequestedPreparationsCount'));
    }

    /**
     * Display preparations list (status = in_progress).
     */
    public function preparationsList(Request $request)
    {
        $query = WorkOrder::with('client')
            ->where('status', 'in_progress');

        // Filter work orders based on user type:
        // - Sales Employees: show only work orders they created
        // - Design Employees: show all work orders (no filter)
        // - Admin (web guard): show all work orders (no filter)
        if (auth('employee')->check()) {
            $employee = auth('employee')->user();
            $isSalesEmployee = $employee->account_type === 'مبيعات';
            // Only filter by created_by for sales employees, not for design employees
            if ($isSalesEmployee) {
                $query->where('created_by', $employee->name);
            }
        }
        // Admin users (auth('web')->check()) will see all work orders
        // No additional filter is applied for admin users

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Calculate total count (before filtering by client/order number for display)
        $totalCountQuery = WorkOrder::where('status', 'in_progress');
        if (auth('employee')->check()) {
            $employee = auth('employee')->user();
            $isSalesEmployee = $employee->account_type === 'مبيعات';
            // Only filter by created_by for sales employees, not for design employees
            if ($isSalesEmployee) {
                $totalCountQuery->where('created_by', $employee->name);
            }
        }
        $totalCount = $totalCountQuery->count();

        // Ensure $workOrders is always a collection, even if empty
        if (!$workOrders) {
            $workOrders = collect();
        }

        return view('work-orders.preparations-list', compact('workOrders', 'clients', 'totalCount'));
    }

    /**
     * Display production list (status = completed).
     */
    public function productionList(Request $request)
    {
        $query = WorkOrder::with('client')
            ->where('status', 'completed');

        // Filter work orders based on user type:
        // - Production employees: see all work orders in production (no filter by created_by)
        // - Sales employees: show only work orders they created
        // - Admin (web guard): show all work orders (no filter)
        if (auth('employee')->check()) {
            $employee = auth('employee')->user();
            $isProductionEmployee = $employee->account_type === 'تشغيل';
            $isSalesEmployee = $employee->account_type === 'مبيعات';
            
            // Production employees see all work orders in production
            if (!$isProductionEmployee && $isSalesEmployee) {
                $query->where('created_by', $employee->name);
            }
            // If production employee, no filter is applied (see all)
        }
        // Admin users (auth('web')->check()) will see all work orders
        // No additional filter is applied for admin users

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Calculate total count
        $totalCount = $workOrders->count();

        return view('work-orders.production-list', compact('workOrders', 'clients', 'totalCount'));
    }

    /**
     * Display production list for production employees (status = completed).
     */
    public function productionEmployeeList(Request $request)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تشغيل') {
            abort(403);
        }

        $query = WorkOrder::with('client')
            ->where('status', 'completed');

        // Production employees see all work orders in production (no filter by created_by)

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Calculate total count
        $totalCount = $workOrders->count();

        return view('employee.production-work-orders', compact('workOrders', 'clients', 'totalCount'));
    }

    /**
     * Display work orders list for sales employees.
     */
    public function salesEmployeeList(Request $request)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'مبيعات') {
            abort(403);
        }

        $query = WorkOrder::with('client')
            ->where(function($q) {
                $q->whereNull('production_status')
                  ->orWhere('production_status', 'بدون حالة')
                  ->orWhereIn('production_status', ['طباعة', 'قص', 'تقفيل']);
            })
            ->where(function($q) {
                // Exclude work_order and cancelled statuses from main index (they have their own pages)
                $q->where(function($subQ) {
                    $subQ->where('status', '!=', 'work_order')
                         ->where('status', '!=', 'cancelled');
                })->orWhereNull('status');
            })
            ->where('created_by', $employee->name);

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number (رقم عرض السعر)
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->limit(1000)->get();
        
        // Initialize groups (optimized - single pass)
        $groupedOrders = [
            'بدون حالة' => collect(),
            'طباعة' => collect(),
            'قص' => collect(),
            'تقفيل' => collect(),
        ];

        $statusGroups = [
            'draft' => collect(),
            'pending' => collect(),
            'client_approved' => collect(),
            'client_rejected' => collect(),
            'client_no_response' => collect(),
            'work_order' => collect(),
            'in_progress' => collect(),
            'completed' => collect(),
            'cancelled' => collect(),
        ];

        $sentCount = 0;
        $notSentCount = 0;

        // Single pass through work orders to group and count
        foreach ($workOrders as $order) {
            if (is_null($order->id)) {
                continue;
            }

            // Group by production status
            $prodStatus = $order->production_status ?? 'بدون حالة';
            if (isset($groupedOrders[$prodStatus])) {
                $groupedOrders[$prodStatus]->push($order);
            } elseif (is_null($order->production_status)) {
                $groupedOrders['بدون حالة']->push($order);
            }

            // Group by status
            $status = $order->status ?? 'draft';
            if (isset($statusGroups[$status])) {
                $statusGroups[$status]->push($order);
            }

            // Count sent/not sent
            $sentToClient = $order->sent_to_client ?? 'no';
            if ($sentToClient === 'yes') {
                $sentCount++;
            } else {
                $notSentCount++;
            }
        }

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Check if there's a pending price quote sent to client
        $hasPendingQuote = WorkOrder::where('sent_to_client', 'yes')
            ->where('created_by', $employee->name)
            ->where(function($q) {
                $q->whereNull('client_response')
                  ->orWhere('client_response', '');
            })
            ->exists();

        return view('employee.sales-work-orders', compact('groupedOrders', 'workOrders', 'clients', 'statusGroups', 'sentCount', 'notSentCount', 'hasPendingQuote'));
    }

    /**
     * Display work orders sent to designer list.
     */
    public function sentToDesignerList(Request $request)
    {
        $query = WorkOrder::with('client')
            ->where('sent_to_designer', 'yes')
            ->where('status', 'work_order');

        // Filter work orders based on user type:
        // - Employees: show only work orders they created
        // - Admin (web guard): show all work orders (no filter)
        if (auth('employee')->check()) {
            $employeeName = auth('employee')->user()->name;
            $query->where('created_by', $employeeName);
        }
        // Admin users (auth('web')->check()) will see all work orders
        // No additional filter is applied for admin users

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Calculate total count
        $totalCountQuery = WorkOrder::where('sent_to_designer', 'yes')
            ->where('status', 'work_order');
        if (auth('employee')->check()) {
            $employeeName = auth('employee')->user()->name;
            $totalCountQuery->where('created_by', $employeeName);
        }
        $totalCount = $totalCountQuery->count();

        // Ensure $workOrders is always a collection, even if empty
        if (!$workOrders) {
            $workOrders = collect();
        }

        return view('work-orders.sent-to-designer-list', compact('workOrders', 'clients', 'totalCount'));
    }

    /**
     * Display workflow page with all work order stages (for admin only).
     */
    public function workflow(Request $request)
    {
        // Only allow admin users
        if (!auth('web')->check()) {
            abort(403);
        }

        // Get all clients for filter dropdown
        $clients = Client::orderBy('name')->get();

        // Filter by client
        $clientFilter = $request->filled('client_id') ? $request->client_id : null;
        // Filter by order number
        $orderNumberFilter = $request->filled('order_number') ? $request->order_number : null;

        // 0. عروض الأسعار (Price Quotes) - status != 'work_order' and != 'cancelled' and != 'in_progress' and != 'completed'
        $priceQuotesQuery = WorkOrder::with('client')
            ->where('status', '!=', 'work_order')
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'in_progress')
            ->where('status', '!=', 'completed');
        if ($clientFilter) {
            $priceQuotesQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $priceQuotesQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $priceQuotes = $priceQuotesQuery->latest()->get();
        $priceQuotesCount = $priceQuotes->count();
        $sentQuotesCount = $priceQuotes->filter(function($order) {
            return ($order->sent_to_client ?? 'no') === 'yes';
        })->count();
        $notSentQuotesCount = $priceQuotes->filter(function($order) {
            return ($order->sent_to_client ?? 'no') !== 'yes';
        })->count();

        // 1. البروفا (Proofs) - status = 'work_order'
        $proofsQuery = WorkOrder::with('client')
            ->where('status', 'work_order');
        if ($clientFilter) {
            $proofsQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $proofsQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $proofs = $proofsQuery->latest()->get();
        $proofsCount = $proofs->count();
        $approvedProofsCount = $proofs->filter(function($order) {
            return ($order->client_design_approval ?? '') === 'موافق';
        })->count();
        $notApprovedProofsCount = $proofs->filter(function($order) {
            return ($order->client_design_approval ?? '') !== 'موافق';
        })->count();

        // 2. أوامر الشغل المرسلة إلى المصمم - sent_to_designer = 'yes' and status = 'work_order'
        $sentToDesignerQuery = WorkOrder::with('client')
            ->where('sent_to_designer', 'yes')
            ->where('status', 'work_order');
        if ($clientFilter) {
            $sentToDesignerQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $sentToDesignerQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $sentToDesigner = $sentToDesignerQuery->latest()->get();
        $sentToDesignerCount = $sentToDesigner->count();

        // 3. التجهيزات (Preparations) - status = 'in_progress'
        $preparationsQuery = WorkOrder::with('client')
            ->where('status', 'in_progress');
        if ($clientFilter) {
            $preparationsQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $preparationsQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $preparations = $preparationsQuery->latest()->get();
        $preparationsCount = $preparations->count();

        // 4. التشغيل (Production) - status = 'completed'
        $productionQuery = WorkOrder::with('client')
            ->where('status', 'completed');
        if ($clientFilter) {
            $productionQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $productionQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $production = $productionQuery->latest()->get();
        $productionCount = $production->count();

        // 5. الأرشيف (Archive) - status = 'cancelled'
        $archiveQuery = WorkOrder::with('client')
            ->where('status', 'cancelled');
        if ($clientFilter) {
            $archiveQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $archiveQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $archive = $archiveQuery->latest()->get();
        $archiveCount = $archive->count();

        // 6. جميع أوامر الشغل - جميع الحالات
        $allWorkOrdersQuery = WorkOrder::with('client');
        if ($clientFilter) {
            $allWorkOrdersQuery->where('client_id', $clientFilter);
        }
        if ($orderNumberFilter) {
            $allWorkOrdersQuery->where('order_number', 'like', '%' . $orderNumberFilter . '%');
        }
        $allWorkOrders = $allWorkOrdersQuery->latest()->get();
        $allWorkOrdersCount = $allWorkOrders->count();

        return view('work-orders.workflow', compact(
            'clients',
            'priceQuotes', 'priceQuotesCount', 'sentQuotesCount', 'notSentQuotesCount',
            'proofs', 'proofsCount', 'approvedProofsCount', 'notApprovedProofsCount',
            'sentToDesigner', 'sentToDesignerCount',
            'preparations', 'preparationsCount',
            'production', 'productionCount',
            'archive', 'archiveCount',
            'allWorkOrders', 'allWorkOrdersCount',
            'clientFilter', 'orderNumberFilter'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $query = Client::query();
        
        // Check if logged in as employee with sales account type
        $employee = Auth::guard('employee')->user();
        $isAdmin = Auth::guard('web')->check();
        $isSalesEmployee = $employee && $employee->account_type === 'مبيعات' && !$isAdmin;
        
        // Only apply the restriction for admin users, not for sales employees
        // Sales employees can create multiple price quotes at the same time
        if ($isAdmin) {
            // Check if there's a pending price quote sent to client
            $pendingQuote = WorkOrder::where('sent_to_client', 'yes')
                ->where(function($q) {
                    $q->whereNull('client_response')
                      ->orWhere('client_response', '');
                })
                ->first();
            
            if ($pendingQuote) {
                return redirect()->route('work-orders.index')
                    ->with('error', 'لا يمكن إضافة أمر شغل جديد. يوجد عرض سعر تم إرساله للعميل ولم يرد عليه بعد. يرجى الانتظار حتى يرد العميل على عرض السعر.');
            }
        }
        
        // If employee is from sales team, filter clients by their team
        if ($isSalesEmployee) {
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
        
        $clients = $query->orderBy('name')->get();
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
            // order_number is auto-generated, so we don't validate it from request
            'job_name' => 'nullable|string|max:255',
            'number_of_colors' => 'required|integer|min:0|max:6',
            'rows_count' => 'nullable|integer|min:1',
            'material' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'width' => 'required|numeric|min:0|max:20',
            'length' => 'required|numeric|min:0|max:50',
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
            'film_count' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value !== null && $request->number_of_colors !== null) {
                        if ($value > $request->number_of_colors) {
                            $fail('العدد في التجهيزات لا يمكن أن يكون أكبر من عدد الألوان المختار (' . $request->number_of_colors . ')');
                        }
                    }
                },
            ],
            'sales_percentage' => 'nullable|numeric|min:0|max:100',
            'material_price_per_meter' => 'nullable|numeric|min:0',
            'manufacturing_price_per_meter' => 'nullable|numeric|min:0',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|in:76,40,25',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
            'paper_width' => 'nullable|numeric|min:0|max:20',
            'gap_count' => 'nullable|numeric|min:0',
            'waste_per_roll' => 'nullable|integer|min:0',
            'increase' => 'nullable|numeric|min:0',
            'linear_meter' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:draft,pending,in_progress,completed,cancelled,client_approved,client_rejected,client_no_response,work_order',
            'sent_to_client' => 'nullable|in:yes,no',
        ]);

        // Set default sent_to_client to 'no' if not provided
        if (!isset($validated['sent_to_client']) || empty($validated['sent_to_client'])) {
            $validated['sent_to_client'] = 'no';
        }

        // Generate order number automatically (optimized)
        $maxId = WorkOrder::max('id') ?? 0;
        $attempts = 0;
        do {
            $orderNumber = 'WO-' . str_pad($maxId + $attempts + 1, 6, '0', STR_PAD_LEFT);
            $exists = WorkOrder::where('order_number', $orderNumber)->exists();
            $attempts++;
            // Safety check to prevent infinite loop
            if ($attempts > 100) {
                // Fallback: use timestamp if too many attempts
                $orderNumber = 'WO-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                break;
            }
        } while ($exists);
        
        $validated['order_number'] = $orderNumber;

        // Set default status to 'draft' if not provided
        if (!isset($validated['status']) || empty($validated['status'])) {
            $validated['status'] = 'draft';
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
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        return view('work-orders.show', compact('workOrder', 'calculations'));
    }

    /**
     * Show work order for designer (simplified view)
     */
    /**
     * Display preparations list for designer employees.
     */
    public function designerPreparationsList(Request $request)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }

        $query = WorkOrder::with('client')
            ->where('status', 'in_progress');

        // Designers see all work orders in preparations (no filter by created_by)

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by order number
        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        $workOrders = $query->latest()->get();

        // Ensure $workOrders is always a collection, even if empty
        if (!$workOrders) {
            $workOrders = collect();
        }

        return view('employee.designer-preparations', compact('workOrders'));
    }

    /**
     * Show preparations work order details for designer.
     */
    public function showDesignerPreparations(WorkOrder $workOrder)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }

        // Verify that this is in preparations (status = 'in_progress')
        if ($workOrder->status !== 'in_progress') {
            abort(404, 'هذا العنصر غير موجود في التجهيزات');
        }
        
        $workOrder->load('client', 'designKnife');
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        return view('work-orders.preparations-show', compact('workOrder', 'calculations'));
    }

    /**
     * Show edit form for designer preparations.
     */
    public function editDesignerPreparations(WorkOrder $workOrder)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }

        // Verify that this is in preparations (status = 'in_progress')
        if ($workOrder->status !== 'in_progress') {
            abort(404, 'هذا العنصر غير موجود في التجهيزات');
        }
        
        $workOrder->load('client');
        
        return view('employee.designer-preparations-edit', compact('workOrder'));
    }

    /**
     * Update designer preparations.
     */
    public function updateDesignerPreparations(Request $request, WorkOrder $workOrder)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }

        // Verify that this is in preparations (status = 'in_progress')
        if ($workOrder->status !== 'in_progress') {
            abort(404, 'هذا العنصر غير موجود في التجهيزات');
        }

        $validated = $request->validate([
            'designer_number_of_colors' => 'nullable|integer|min:1',
            'designer_drills' => 'nullable|string|max:255',
            'designer_breaking_gear' => 'nullable|string|max:255',
            'designer_paper_width' => 'nullable|numeric|min:0|max:20',
            'designer_gap' => 'nullable|numeric|min:0',
        ]);

        $workOrder->update($validated);

        return redirect()->route('employee.designer.preparations.show', $workOrder)
            ->with('success', 'تم تحديث التجهيزات بنجاح');
    }

    public function showForDesigner(WorkOrder $workOrder)
    {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }
        
        // Verify that this work order is sent to designer
        if (($workOrder->sent_to_designer ?? 'no') !== 'yes') {
            abort(403, 'هذا أمر الشغل لم يتم إرساله إلى المصمم');
        }
        
        $workOrder->load('client', 'designKnife');
        
        return view('employee.designer-work-order-show', compact('workOrder'));
    }

    /**
     * Show profile (work order) from work-orders-list page
     */
    public function showProfile(WorkOrder $workOrder)
    {
        // Verify that this is a work order (status = 'work_order')
        if ($workOrder->status !== 'work_order') {
            abort(404, 'هذا ليس بروفا');
        }
        
        $workOrder->load('client', 'designKnife');
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        return view('work-orders.profile-show', compact('workOrder', 'calculations'));
    }

    /**
     * Show archived work order from archive page
     */
    public function showArchive(WorkOrder $workOrder)
    {
        // Verify that this is archived (status = 'cancelled')
        if ($workOrder->status !== 'cancelled') {
            abort(404, 'هذا العنصر غير موجود في الأرشيف');
        }
        
        $workOrder->load('client', 'designKnife');
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        return view('work-orders.archive-show', compact('workOrder', 'calculations'));
    }

    /**
     * Show preparations work order from preparations list page
     */
    public function showPreparations(WorkOrder $workOrder)
    {
        // Verify that this is in preparations (status = 'in_progress')
        if ($workOrder->status !== 'in_progress') {
            abort(404, 'هذا العنصر غير موجود في التجهيزات');
        }
        
        $workOrder->load('client', 'designKnife');
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        return view('work-orders.preparations-show', compact('workOrder', 'calculations'));
    }

    /**
     * Show sent to designer work order from sent-to-designer list page
     */
    public function showSentToDesigner(WorkOrder $workOrder)
    {
        // Verify that this is sent to designer (sent_to_designer = yes and status = work_order)
        if (($workOrder->sent_to_designer ?? 'no') !== 'yes' || $workOrder->status !== 'work_order') {
            abort(404, 'هذا العنصر غير موجود في قائمة أوامر الشغل المرسلة إلى المصمم');
        }
        
        $workOrder->load('client', 'designKnife');
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        return view('work-orders.sent-to-designer-show', compact('workOrder', 'calculations'));
    }

    /**
     * Calculate all values dynamically from work order data
     */
    private function calculateAllValues(WorkOrder $workOrder)
    {
        $calculations = [];
        
        // 1. Paper Width: Use value from database if exists, otherwise calculate
        if ($workOrder->paper_width && $workOrder->paper_width > 0) {
            // Use the value stored in database
            $calculations['paper_width'] = $workOrder->paper_width;
        } elseif ($workOrder->width && $workOrder->rows_count) {
            // Fallback: Calculate if not stored in database
            $calculations['paper_width'] = ($workOrder->width * $workOrder->rows_count) + (($workOrder->rows_count - 1) * 0.3) + 1.2;
        } else {
            $calculations['paper_width'] = 0;
        }
        
        // 2. Linear Meter: (الكمية × 1000 × (الطول + الجاب)) ÷ (100 × عدد الصفوف)
        if ($workOrder->quantity && $workOrder->length && $workOrder->rows_count) {
            $gapCount = $workOrder->gap_count ?? 0.4;
            $calculations['linear_meter'] = ($workOrder->quantity * 1000 * ($workOrder->length + $gapCount)) / (100 * $workOrder->rows_count);
        } else {
            $calculations['linear_meter'] = $workOrder->linear_meter ?? 0;
        }
        
        // 3. Rolls Count: ceil(المتر الطولي ÷ 1000)
        if ($calculations['linear_meter'] > 0) {
            $calculations['rolls_count'] = ceil($calculations['linear_meter'] / 1000);
        } else {
            $calculations['rolls_count'] = 0;
        }
        
        // 4. Waste: عدد البكر × عدد الهالك للبكره
        $wastePerRoll = $workOrder->waste_per_roll ?? 0;
        if ($calculations['rolls_count'] > 0 && $wastePerRoll > 0) {
            $calculations['waste'] = $calculations['rolls_count'] * $wastePerRoll;
        } else {
            $calculations['waste'] = 0;
        }
        
        // 5. Waste Percentage: from wastes table based on number_of_colors
        if ($workOrder->number_of_colors !== null) {
            $waste = \App\Models\Waste::where('number_of_colors', $workOrder->number_of_colors)->first();
            $calculations['waste_percentage'] = $waste ? $waste->waste_percentage : 0;
        } else {
            $calculations['waste_percentage'] = 0;
        }
        
        // 6. Linear Meter with Waste: المتر الطولي + الهالك + نسبة الهالك
        $calculations['linear_meter_with_waste'] = $calculations['linear_meter'] + $calculations['waste'] + $calculations['waste_percentage'];
        
        // 7. Square Meter: (المتر الطولي مضاف اليه الهالك × عرض الورق) ÷ 100
        if ($calculations['linear_meter_with_waste'] > 0 && $calculations['paper_width'] > 0) {
            $calculations['square_meter'] = ($calculations['linear_meter_with_waste'] * $calculations['paper_width']) / 100;
        } else {
            $calculations['square_meter'] = 0;
        }
        
        // 8. Total Prices Sum: سعر المتر الخام + سعر متر التصنيع + سعر الإضافي + سعر البصمة + سعر التكسير
        $materialPricePerMeter = $workOrder->material_price_per_meter ?? 0;
        $manufacturingPricePerMeter = $workOrder->manufacturing_price_per_meter ?? 0;
        $additionPrice = ($workOrder->additions && $workOrder->additions != 'لا يوجد') ? ($workOrder->addition_price ?? 0) : 0;
        $fingerprintPrice = ($workOrder->fingerprint == 'yes') ? ($workOrder->fingerprint_price ?? 0) : 0;
        $externalBreakingPrice = ($workOrder->external_breaking == 'yes') ? ($workOrder->external_breaking_price ?? 0) : 0;
        
        $calculations['total_prices_sum'] = $materialPricePerMeter + $manufacturingPricePerMeter + $additionPrice + $fingerprintPrice + $externalBreakingPrice;
        
        // 9. Total Amount: إجمالي المبلغ (الأسعار) × المتر المربع
        $calculations['total_amount'] = $calculations['total_prices_sum'] * $calculations['square_meter'];
        
        // 10. Sales Percentage Amount: إجمالي المبلغ × نسبة المبيعات / 100
        $salesPercentage = $workOrder->sales_percentage ?? 0;
        if ($calculations['total_amount'] > 0 && $salesPercentage > 0) {
            $calculations['sales_percentage_amount'] = $calculations['total_amount'] * $salesPercentage / 100;
        } else {
            $calculations['sales_percentage_amount'] = 0;
        }
        
        // 11. Total Amount with Sales Percentage: إجمالي المبلغ + نسبة المبيعات
        $calculations['total_amount_with_sales'] = $calculations['total_amount'] + $calculations['sales_percentage_amount'];
        
        // 12. Total Preparations: (سعر الفيلم الواحد × العدد) + سعر السكينة
        $filmPrice = $workOrder->film_price ?? 0;
        $filmCount = $workOrder->film_count ?? 0;
        $knifePrice = ($workOrder->knife_exists == 'yes') ? ($workOrder->knife_price ?? 0) : 0;
        $calculations['total_preparations'] = ($filmPrice * $filmCount) + $knifePrice;
        
        // 13. Total Order: (إجمالي المبلغ + نسبة المبيعات) + إجمالي التجهيزات
        $calculations['total_order'] = $calculations['total_amount_with_sales'] + $calculations['total_preparations'];
        
        // 14. Price Per Thousand: إجمالي الطلب ÷ الكمية
        $quantity = $workOrder->quantity ?? 0;
        if ($calculations['total_order'] > 0 && $quantity > 0) {
            $calculations['price_per_thousand'] = $calculations['total_order'] / $quantity;
        } else {
            $calculations['price_per_thousand'] = 0;
        }
        
        return $calculations;
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
     * Print price quote for client.
     */
    public function printPriceQuote(WorkOrder $workOrder)
    {
        $workOrder->load('client', 'designKnife');
        
        // Calculate all values dynamically
        $calculations = $this->calculateAllValues($workOrder);
        
        // Calculate pieces per roll (البكر به كام تكيت)
        // Formula: الكمية ÷ عدد البكر
        if ($workOrder->number_of_rolls && $workOrder->number_of_rolls > 0) {
            $calculations['pieces_per_roll'] = ceil($workOrder->quantity / $workOrder->number_of_rolls);
        } else {
            // Fallback: use rolls_count from calculations
            if ($calculations['rolls_count'] > 0) {
                $calculations['pieces_per_roll'] = ceil($workOrder->quantity / $calculations['rolls_count']);
            } else {
                // If no rolls, assume all pieces are in one roll
                $calculations['pieces_per_roll'] = $workOrder->quantity ?? 0;
            }
        }
        
        // Calculate price per unit (سعر التكيت)
        // Formula: إجمالي الطلب ÷ الكمية
        $quantity = $workOrder->quantity ?? 0;
        if ($calculations['total_order'] > 0 && $quantity > 0) {
            $calculations['price_per_unit'] = $calculations['total_order'] / $quantity;
        } else {
            $calculations['price_per_unit'] = 0;
        }
        
        return view('work-orders.print-price-quote', compact('workOrder', 'calculations'));
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
        
        $clients = $query->orderBy('name')->get();
        $materials = Material::where('is_active', true)->orderBy('name')->get();
        $additions = \App\Models\Addition::orderBy('name')->get();
        $externalBreakingPrice = \App\Models\SystemSetting::getValue('external_breaking_price', 4);
        $wastes = \App\Models\Waste::orderBy('number_of_colors')->get();
        return view('work-orders.edit', compact('workOrder', 'clients', 'materials', 'additions', 'externalBreakingPrice', 'wastes'));
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
            'width' => 'required|numeric|min:0|max:20',
            'length' => 'required|numeric|min:0|max:50',
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
            'film_count' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value !== null && $request->number_of_colors !== null) {
                        if ($value > $request->number_of_colors) {
                            $fail('العدد في التجهيزات لا يمكن أن يكون أكبر من عدد الألوان المختار (' . $request->number_of_colors . ')');
                        }
                    }
                },
            ],
            'sales_percentage' => 'nullable|numeric|min:0|max:100',
            'material_price_per_meter' => 'nullable|numeric|min:0',
            'manufacturing_price_per_meter' => 'nullable|numeric|min:0',
            'number_of_rolls' => 'nullable|integer|min:1',
            'core_size' => 'nullable|in:76,40,25',
            'pieces_per_sheet' => 'nullable|integer|min:1',
            'sheets_per_stack' => 'nullable|integer|min:1',
            'paper_width' => 'nullable|numeric|min:0|max:20',
            'gap_count' => 'nullable|numeric|min:0',
            'waste_per_roll' => 'nullable|integer|min:0',
            'increase' => 'nullable|numeric|min:0',
            'linear_meter' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'nullable|in:draft,pending,in_progress,completed,cancelled,client_approved,client_rejected,client_no_response,work_order',
            'sent_to_client' => 'nullable|in:yes,no',
        ]);

        $workOrder->update($validated);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم تحديث أمر الشغل بنجاح');
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

    /**
     * Mark work order as sent to client.
     */
    public function markAsSentToClient(WorkOrder $workOrder)
    {
        $workOrder->update([
            'sent_to_client' => 'yes'
        ]);

        return redirect()->back()
            ->with('success', 'تم تحديث حالة الإرسال للعميل بنجاح');
    }

    /**
     * Update client response status.
     */
    public function updateClientResponse(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'client_response' => 'required|in:موافق,رفض,لم يرد',
        ]);

        // If client rejected or didn't respond, change status to cancelled and redirect to archive page
        if (in_array($validated['client_response'], ['رفض', 'لم يرد'])) {
            $workOrder->update([
                'client_response' => $validated['client_response'],
                'status' => 'cancelled'
            ]);

            return redirect()->route('work-orders.archive')
                ->with('success', 'تم تحديث حالة رد العميل بنجاح وتم نقل عرض السعر إلى الأرشيف');
        }

        // If client approved, update client_response only
        $workOrder->update([
            'client_response' => $validated['client_response']
        ]);

        // If client approved, convert to work_order, send to designer, and redirect to proofs page
        if ($validated['client_response'] === 'موافق') {
            $workOrder->update([
                'status' => 'work_order',
                'sent_to_designer' => 'yes'
            ]);

            return redirect()->route('work-orders.list')
                ->with('success', 'تم موافقة العميل على عرض السعر. تم تحويله إلى بروفا وإرساله إلى المصمم بنجاح.');
        }

        // Fallback (should not reach here)
        return redirect()->back()
            ->with('success', 'تم تحديث حالة رد العميل بنجاح');
    }

    /**
     * Update client design approval status.
     */
    public function updateClientDesignApproval(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'client_design_approval' => 'required|in:موافق,رفض,لم يرد',
        ]);

        $workOrder->update([
            'client_design_approval' => $validated['client_design_approval']
        ]);

        return redirect()->back()
            ->with('success', 'تم تحديث حالة موافقة العميل على التصميم بنجاح');
    }

    /**
     * Complete production data (final product shape and production method data).
     */
    public function completeProductionData(Request $request, WorkOrder $workOrder)
    {
        // Only allow if client has approved the design
        if (($workOrder->client_design_approval ?? '') !== 'موافق') {
            return redirect()->back()
                ->with('error', 'لا يمكن استكمال البيانات إلا بعد موافقة العميل على التصميم');
        }

        $validated = $request->validate([
            'final_product_shape' => 'required|in:بكر,شيت',
            'number_of_rolls' => 'required_if:final_product_shape,بكر|nullable|integer|min:1',
            'core_size' => 'required_if:final_product_shape,بكر|nullable|numeric|in:76,40,25',
            'pieces_per_sheet' => 'required_if:final_product_shape,شيت|nullable|integer|min:1',
            'sheets_per_stack' => 'required_if:final_product_shape,شيت|nullable|integer|min:1',
        ]);

        $updateData = [
            'final_product_shape' => $validated['final_product_shape'],
        ];

        if ($validated['final_product_shape'] === 'بكر') {
            $updateData['number_of_rolls'] = $validated['number_of_rolls'];
            $updateData['core_size'] = $validated['core_size'];
            // Clear sheet fields
            $updateData['pieces_per_sheet'] = null;
            $updateData['sheets_per_stack'] = null;
        } else {
            $updateData['pieces_per_sheet'] = $validated['pieces_per_sheet'];
            $updateData['sheets_per_stack'] = $validated['sheets_per_stack'];
            // Clear roll fields
            $updateData['number_of_rolls'] = null;
            $updateData['core_size'] = null;
        }

        $workOrder->update($updateData);

        return redirect()->back()
            ->with('success', 'تم حفظ بيانات شكل المنتج النهائي وطريقة التشغيل بنجاح');
    }

    /**
     * Update notes for a work order (from profile show page).
     */
    public function updateNotes(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $workOrder->update([
            'notes' => $validated['notes'] ?? null
        ]);

        return redirect()->back()
            ->with('success', 'تم تحديث الملاحظات بنجاح');
    }

    /**
     * Move work order to preparations (change status to in_progress).
     */
    public function moveToPreparations(WorkOrder $workOrder)
    {
        // Only allow if client has approved the design
        if (($workOrder->client_design_approval ?? '') !== 'موافق') {
            return redirect()->back()
                ->with('error', 'لا يمكن نقل البروفا إلى التجهيزات إلا بعد موافقة العميل على التصميم');
        }

        // Only allow if production data is completed
        if (!$workOrder->final_product_shape) {
            return redirect()->back()
                ->with('error', 'يرجى استكمال بيانات شكل المنتج النهائي وطريقة التشغيل أولاً');
        }

        // Only allow if status is work_order
        if ($workOrder->status !== 'work_order') {
            return redirect()->back()
                ->with('error', 'لا يمكن نقل البروفا إلى التجهيزات إلا إذا كانت حالة البروفا');
        }

        // Update status to in_progress
        $workOrder->update([
            'status' => 'in_progress'
        ]);

        return redirect()->route('work-orders.preparations')
            ->with('success', 'تم نقل البروفا إلى التجهيزات بنجاح');
    }

    /**
     * Move work order to production (change status to completed).
     */
    public function moveToProduction(WorkOrder $workOrder)
    {
        // Only allow if status is in_progress
        if ($workOrder->status !== 'in_progress') {
            return redirect()->route('work-orders.preparations')
                ->with('error', 'يمكن نقل الطلبات جاري التجهيز فقط إلى التشغيل');
        }

        // Update status to completed
        $workOrder->update([
            'status' => 'completed'
        ]);

        return redirect()->route('work-orders.production')
            ->with('success', 'تم نقل الطلب إلى التشغيل بنجاح');
    }

    /**
     * Convert price quote to work order.
     */
    /**
     * Mark work order as sent to designer.
     */
    public function markAsSentToDesigner(WorkOrder $workOrder)
    {
        // Only allow if status is work_order
        if ($workOrder->status !== 'work_order') {
            return redirect()->route('work-orders.show', $workOrder)
                ->with('error', 'يمكن إرسال أمر الشغل إلى المصمم فقط عندما تكون الحالة "أمر شغل"');
        }

        $workOrder->update([
            'sent_to_designer' => 'yes'
        ]);

        return redirect()->route('work-orders.show', $workOrder)
            ->with('success', 'تم إرسال أمر الشغل إلى المصمم بنجاح');
    }

    /**
     * Request proof from designer (convert to work_order and send to designer).
     */
    public function requestProofFromDesigner(WorkOrder $workOrder)
    {
        // Only allow if client has approved
        if (($workOrder->client_response ?? '') !== 'موافق') {
            return redirect()->back()
                ->with('error', 'لا يمكن طلب بروفا من المصمم إلا بعد موافقة العميل على عرض السعر');
        }

        // Update status to work_order and send to designer
        $workOrder->update([
            'status' => 'work_order',
            'sent_to_designer' => 'yes'
        ]);

        return redirect()->route('work-orders.list')
            ->with('success', 'تم طلب البروفا من المصمم بنجاح. تم تحويل عرض السعر إلى بروفا وإرساله إلى المصمم.');
    }

    public function convertToOrder(WorkOrder $workOrder)
    {
        // Check if the client response is موافق
        if (($workOrder->client_response ?? '') !== 'موافق') {
            return redirect()->back()
                ->with('error', 'لا يمكن تحويل عرض السعر إلى أمر شغل إلا بعد موافقة العميل');
        }

        // Update status to work_order
        $workOrder->update([
            'status' => 'work_order'
        ]);

        return redirect()->back()
            ->with('success', 'تم تحويل عرض السعر إلى أمر شغل بنجاح. الحالة الآن: أمر شغل');
    }

    /**
     * Archive work order (for rejected or no response quotes).
     */
    public function archiveQuote(WorkOrder $workOrder)
    {
        // Check if the client response is رفض or لم يرد
        if (!in_array($workOrder->client_response ?? '', ['رفض', 'لم يرد'])) {
            return redirect()->back()
                ->with('error', 'لا يمكن أرشفة عرض السعر إلا إذا كان العميل قد رفض أو لم يرد');
        }

        // Update status to cancelled (archived)
        $workOrder->update([
            'status' => 'cancelled'
        ]);

        return redirect()->back()
            ->with('success', 'تم أرشفة عرض السعر بنجاح. الحالة الآن: ملغي');
    }

    /**
     * Restore archived quote (change status back to pending).
     */
    public function restoreQuote(WorkOrder $workOrder)
    {
        // Verify that this is an archived quote
        if ($workOrder->status !== 'cancelled') {
            return redirect()->back()
                ->with('error', 'هذا العنصر غير موجود في الأرشيف');
        }

        // Update status to pending and reset client response
        $workOrder->update([
            'status' => 'pending',
            'client_response' => null,
            'sent_to_client' => 'no'
        ]);

        return redirect()->route('work-orders.index')
            ->with('success', 'تم إعادة عرض السعر بنجاح. الحالة الآن: قيد الانتظار');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkOrder $workOrder)
    {
        try {
            $workOrder->delete();
            
            return redirect()->route('work-orders.index')
                ->with('success', 'تم حذف أمر الشغل بنجاح');
        } catch (\Exception $e) {
            return redirect()->route('work-orders.index')
                ->with('error', 'حدث خطأ أثناء حذف أمر الشغل: ' . $e->getMessage());
        }
    }

}
