<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية - تسجيل الدخول
Route::get('/', function () {
    if (auth('employee')->check()) {
        $employee = auth('employee')->user();
        if ($employee->account_type === 'تصميم') {
            return redirect()->route('employee.designer.dashboard');
        } elseif ($employee->account_type === 'تشغيل') {
            return redirect()->route('employee.production.dashboard');
        } elseif ($employee->account_type === 'حسابات') {
            return redirect()->route('employee.accounting.dashboard');
        } else {
            return redirect()->route('employee.dashboard');
        }
    }
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return app(AuthenticatedSessionController::class)->create();
})->name('home');

Route::get('/dashboard', function () {
    $clientsCount = \App\Models\Client::count();
    $employeesCount = \App\Models\Employee::count();
    $suppliersCount = \App\Models\Supplier::count();
    $workOrdersCount = \App\Models\WorkOrder::count();
    $salesTeamsCount = \App\Models\SalesTeam::count();
    $recentClients = \App\Models\Client::latest()->take(5)->get();
    $recentEmployees = \App\Models\Employee::latest()->take(5)->get();
    $recentSuppliers = \App\Models\Supplier::latest()->take(5)->get();
    $recentWorkOrders = \App\Models\WorkOrder::with('client')->latest()->take(5)->get();
    return view('dashboard', compact('clientsCount', 'employeesCount', 'suppliersCount', 'workOrdersCount', 'salesTeamsCount', 'recentClients', 'recentEmployees', 'recentSuppliers', 'recentWorkOrders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes accessible by both admin and sales employees
Route::middleware('auth.any')->group(function () {
    // العملاء - متاح للمبيعات والادمن
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    
    // أوامر الشغل - متاح للمبيعات والادمن
    Route::get('work-orders/{workOrder}/print', [\App\Http\Controllers\WorkOrderController::class, 'print'])->name('work-orders.print');
    Route::get('work-orders/{workOrder}/print-price-quote', [\App\Http\Controllers\WorkOrderController::class, 'printPriceQuote'])->name('work-orders.print-price-quote');
    Route::get('work-orders/{workOrder}/print-operation', [\App\Http\Controllers\WorkOrderController::class, 'printOperation'])->name('work-orders.print-operation');
    Route::get('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'showDesignForm'])->name('work-orders.design.show');
    Route::post('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'storeDesign'])->name('work-orders.design.store');
    Route::post('work-orders/{workOrder}/production-status', [\App\Http\Controllers\WorkOrderController::class, 'updateProductionStatus'])->name('work-orders.production-status.update');
    Route::post('work-orders/{workOrder}/mark-as-sent', [\App\Http\Controllers\WorkOrderController::class, 'markAsSentToClient'])->name('work-orders.mark-as-sent');
    Route::post('work-orders/{workOrder}/client-response', [\App\Http\Controllers\WorkOrderController::class, 'updateClientResponse'])->name('work-orders.client-response.update');
    Route::post('work-orders/{workOrder}/client-design-approval', [\App\Http\Controllers\WorkOrderController::class, 'updateClientDesignApproval'])->name('work-orders.client-design-approval.update');
    Route::post('work-orders/{workOrder}/complete-production-data', [\App\Http\Controllers\WorkOrderController::class, 'completeProductionData'])->name('work-orders.complete-production-data');
    Route::post('work-orders/{workOrder}/move-to-preparations', [\App\Http\Controllers\WorkOrderController::class, 'moveToPreparations'])->name('work-orders.move-to-preparations');
    Route::post('work-orders/{workOrder}/move-to-production', [\App\Http\Controllers\WorkOrderController::class, 'moveToProduction'])->name('work-orders.move-to-production');
    Route::post('work-orders/{workOrder}/convert-to-order', [\App\Http\Controllers\WorkOrderController::class, 'convertToOrder'])->name('work-orders.convert-to-order');
    Route::post('work-orders/{workOrder}/mark-as-sent-to-designer', [\App\Http\Controllers\WorkOrderController::class, 'markAsSentToDesigner'])->name('work-orders.mark-as-sent-to-designer');
    Route::post('work-orders/{workOrder}/request-proof-from-designer', [\App\Http\Controllers\WorkOrderController::class, 'requestProofFromDesigner'])->name('work-orders.request-proof-from-designer');
    Route::post('work-orders/{workOrder}/archive', [\App\Http\Controllers\WorkOrderController::class, 'archiveQuote'])->name('work-orders.archive-quote');
    Route::get('work-orders-list', [\App\Http\Controllers\WorkOrderController::class, 'workOrdersList'])->name('work-orders.list');
    Route::get('work-orders-list/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showProfile'])->name('work-orders-list.show');
    Route::post('work-orders-list/{workOrder}/update-notes', [\App\Http\Controllers\WorkOrderController::class, 'updateNotes'])->name('work-orders-list.update-notes');
    Route::get('work-orders-preparations', [\App\Http\Controllers\WorkOrderController::class, 'preparationsList'])->name('work-orders.preparations');
    Route::get('work-orders-preparations/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showPreparations'])->name('work-orders.preparations.show');
    Route::get('work-orders-production', [\App\Http\Controllers\WorkOrderController::class, 'productionList'])->name('work-orders.production');
    Route::get('work-orders-sent-to-designer', [\App\Http\Controllers\WorkOrderController::class, 'sentToDesignerList'])->name('work-orders.sent-to-designer');
    Route::get('work-orders-sent-to-designer/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showSentToDesigner'])->name('work-orders.sent-to-designer.show');
    Route::get('work-orders/archive', [\App\Http\Controllers\WorkOrderController::class, 'archive'])->name('work-orders.archive');
    Route::get('work-orders/archive/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showArchive'])->name('work-orders.archive.show');
    Route::post('work-orders/archive/{workOrder}/restore', [\App\Http\Controllers\WorkOrderController::class, 'restoreQuote'])->name('work-orders.archive.restore');
    Route::get('work-orders/workflow', [\App\Http\Controllers\WorkOrderController::class, 'workflow'])->name('work-orders.workflow');
    Route::post('work-orders/{workOrder}/update-status', [\App\Http\Controllers\WorkOrderController::class, 'updateStatus'])->name('work-orders.update-status');
    Route::resource('work-orders', \App\Http\Controllers\WorkOrderController::class);
    
    // السكاكين - متاح للمصمم والادمن
    Route::get('knives/export', [\App\Http\Controllers\KnifeController::class, 'export'])->name('knives.export');
    Route::get('knives/get-next-code', [\App\Http\Controllers\KnifeController::class, 'getNextKnifeCode'])->name('knives.get-next-code');
    Route::get('knives/get-filter-values', [\App\Http\Controllers\KnifeController::class, 'getFilterValues'])->name('knives.get-filter-values');
    Route::get('knives/get-all-filter-data', [\App\Http\Controllers\KnifeController::class, 'getAllFilterData'])->name('knives.get-all-filter-data');
    Route::delete('knives/delete-all', [\App\Http\Controllers\KnifeController::class, 'deleteAll'])->name('knives.delete-all');
    Route::resource('knives', \App\Http\Controllers\KnifeController::class)->except(['import']);
});

// Routes accessible by admin only
Route::middleware('auth')->group(function () {
    // الموظفين
    Route::get('employees/export', [\App\Http\Controllers\EmployeeController::class, 'export'])->name('employees.export');
    Route::post('employees/import', [\App\Http\Controllers\EmployeeController::class, 'import'])->name('employees.import');
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    
    // الموردين
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    
    // أنواع المصروفات
    Route::resource('expense-types', \App\Http\Controllers\ExpenseTypeController::class);
    
    // طرق السداد
    Route::resource('payment-methods', \App\Http\Controllers\PaymentMethodController::class);
    
    // الخامات
    Route::resource('materials', \App\Http\Controllers\MaterialController::class);
    
    // الاضافات
    Route::resource('additions', \App\Http\Controllers\AdditionController::class);
    
    // أقسام الشركة
    Route::resource('departments', \App\Http\Controllers\DepartmentController::class);
    Route::resource('positions', \App\Http\Controllers\PositionController::class);
    
    // السكاكين - Import فقط للادمن
    Route::post('knives/import', [\App\Http\Controllers\KnifeController::class, 'import'])->name('knives.import');
    
    // الطباعة
    Route::resource('wastes', \App\Http\Controllers\WasteController::class);
    
    // المصروفات
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    
    // فرق المبيعات
    Route::resource('sales-teams', \App\Http\Controllers\SalesTeamController::class);
    
    // توزيع العملاء على فرق المبيعات
    Route::get('client-distribution', [\App\Http\Controllers\ClientDistributionController::class, 'index'])->name('client-distribution.index');
    Route::post('client-distribution', [\App\Http\Controllers\ClientDistributionController::class, 'store'])->name('client-distribution.store');
    Route::put('client-distribution/{client}', [\App\Http\Controllers\ClientDistributionController::class, 'update'])->name('client-distribution.update');
});

require __DIR__.'/auth.php';

// Employee Authentication Routes - Redirect to main login
Route::middleware('guest')->group(function () {
    Route::get('employee/login', function () {
        return redirect()->route('login');
    })->name('employee.login');
});

// Employee Routes (Sales Employees Only) - Dashboard and Work Orders
Route::middleware(['auth:employee', 'employee.sales'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () {
        $workOrdersCount = \App\Models\WorkOrder::where('production_status', '!=', 'أرشيف')->count();
        $recentWorkOrders = \App\Models\WorkOrder::with('client')
            ->where('production_status', '!=', 'أرشيف')
            ->latest()
            ->take(5)
            ->get();
        
        // حساب عدد العملاء التابعين لموظف المبيعات (نفس المنطق في القائمة الجانبية)
        $employee = auth('employee')->user();
        $isAdmin = auth('web')->check();
        $employeeAccountType = $employee ? $employee->account_type : null;
        $isSalesEmployee = $employee && $employeeAccountType === 'مبيعات';
        
        $clientsCount = 0;
        if ($isSalesEmployee && !$isAdmin) {
            $employee->load('salesTeams');
            $teamIds = $employee->salesTeams->pluck('id')->toArray();
            
            if (!empty($teamIds)) {
                $clientsCount = \App\Models\Client::whereHas('salesTeams', function($q) use ($teamIds) {
                    $q->whereIn('sales_teams.id', $teamIds);
                })->count();
            }
        } elseif ($isAdmin) {
            $clientsCount = \App\Models\Client::count();
        } else {
            $clientsCount = \App\Models\Client::count();
        }
        
        $recentClients = \App\Models\Client::latest()->take(5)->get();
        
        // Counts for cards - نفس المنطق المستخدم في AppLayout.php
        $isAdmin = auth('web')->check();
        
        // عرض الأسعار (priceQuotesCount): status != 'work_order' and != 'cancelled'
        $quotesQuery = \App\Models\WorkOrder::where('status', '!=', 'work_order')
            ->where('status', '!=', 'cancelled');
        if ($isSalesEmployee && !$isAdmin) {
            $quotesQuery->where('created_by', $employee->name);
        }
        $quotesCount = $quotesQuery->count();
        
        // البروفا (proofsCount): status = 'work_order'
        $profileQuery = \App\Models\WorkOrder::where('status', 'work_order');
        if ($isSalesEmployee && !$isAdmin) {
            $profileQuery->where('created_by', $employee->name);
        }
        $profileCount = $profileQuery->count();
        
        // التجهيزات (preparationsCount): status = 'in_progress'
        $preparationsQuery = \App\Models\WorkOrder::where('status', 'in_progress');
        if ($isSalesEmployee && !$isAdmin) {
            $preparationsQuery->where('created_by', $employee->name);
        }
        $preparationsCount = $preparationsQuery->count();
        
        // التشغيل (productionCount): status = 'completed'
        $productionQuery = \App\Models\WorkOrder::where('status', 'completed');
        if ($isSalesEmployee && !$isAdmin) {
            $productionQuery->where('created_by', $employee->name);
        }
        $productionCount = $productionQuery->count();
        
        // الأرشيف (archiveCount): status = 'cancelled'
        $archiveQuery = \App\Models\WorkOrder::where('status', 'cancelled');
        if ($isSalesEmployee && !$isAdmin) {
            $archiveQuery->where('created_by', $employee->name);
        }
        $archiveCount = $archiveQuery->count();
        
        return view('employee.dashboard', compact('workOrdersCount', 'recentWorkOrders', 'clientsCount', 'recentClients', 'quotesCount', 'profileCount', 'preparationsCount', 'productionCount', 'archiveCount'));
    })->name('dashboard');
    
    // Sales Work Orders List
    Route::get('/sales/work-orders', [\App\Http\Controllers\WorkOrderController::class, 'salesEmployeeList'])->name('sales.work-orders');
    
    // Logout is handled by the main auth routes
    // Work Orders routes are now handled by auth.any middleware above
});

// Employee Routes (Design Employees) - Dashboard and Work Orders
Route::middleware(['auth:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/designer/dashboard', function () {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }
        return view('employee.designer-dashboard');
    })->name('designer.dashboard');
    
    Route::get('/designer/work-orders', function () {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }
        // Get work orders sent to designer, ordered by updated_at (newest first)
        $workOrders = \App\Models\WorkOrder::with('client')
            ->where('sent_to_designer', 'yes')
            ->where('status', 'work_order')
            ->latest('updated_at')
            ->get();
        
        // Count approved proofs
        $approvedCount = \App\Models\WorkOrder::where('sent_to_designer', 'yes')
            ->where('status', 'work_order')
            ->where('client_design_approval', 'موافق')
            ->count();
        
        // Count not approved proofs (لم يرد or رفض or null)
        $notApprovedCount = \App\Models\WorkOrder::where('sent_to_designer', 'yes')
            ->where('status', 'work_order')
            ->where(function($query) {
                $query->whereNull('client_design_approval')
                     ->orWhere('client_design_approval', 'لم يرد')
                     ->orWhere('client_design_approval', 'رفض');
            })
            ->count();
        
        return view('employee.designer-work-orders', compact('workOrders', 'approvedCount', 'notApprovedCount'));
    })->name('designer.work-orders');
    
    Route::get('/designer/work-orders/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showForDesigner'])->name('designer.work-orders.show');
    
    // Designer Preparations Routes
    Route::get('/designer/preparations', [\App\Http\Controllers\WorkOrderController::class, 'designerPreparationsList'])->name('designer.preparations');
    Route::get('/designer/preparations/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showDesignerPreparations'])->name('designer.preparations.show');
    Route::get('/designer/preparations/{workOrder}/edit', [\App\Http\Controllers\WorkOrderController::class, 'editDesignerPreparations'])->name('designer.preparations.edit');
    Route::post('/designer/preparations/{workOrder}/update', [\App\Http\Controllers\WorkOrderController::class, 'updateDesignerPreparations'])->name('designer.preparations.update');
    
    // Employee Routes (Production Employees) - Dashboard and Work Orders only
    Route::get('/production/dashboard', function () {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تشغيل') {
            abort(403);
        }
        // Get work orders in production (not archived)
        $workOrdersCount = \App\Models\WorkOrder::where('production_status', '!=', 'أرشيف')
            ->where(function($q) {
                $q->whereNull('production_status')
                  ->orWhere('production_status', 'بدون حالة')
                  ->orWhereIn('production_status', ['طباعة', 'قص', 'تقفيل']);
            })
            ->count();
        
        $recentWorkOrders = \App\Models\WorkOrder::with('client')
            ->where('production_status', '!=', 'أرشيف')
            ->where(function($q) {
                $q->whereNull('production_status')
                  ->orWhere('production_status', 'بدون حالة')
                  ->orWhereIn('production_status', ['طباعة', 'قص', 'تقفيل']);
            })
            ->latest()
            ->take(5)
            ->get();
        
        $knivesCount = \App\Models\Knife::count();
        $recentKnives = \App\Models\Knife::latest()->take(5)->get();
        $representatives = \App\Models\Representative::latest()->get();
        
        return view('employee.production-dashboard', compact('workOrdersCount', 'recentWorkOrders', 'knivesCount', 'recentKnives', 'representatives'));
    })->name('production.dashboard');
    
    // Production Price Quotes (عروض الأسعار - تابع مندوب)
    Route::get('/production/quotes', [\App\Http\Controllers\WorkOrderController::class, 'productionQuotesList'])->name('production.quotes');
    // Production Workflow (سير العمل لعروض المندوبين)
    Route::get('/production/workflow', [\App\Http\Controllers\WorkOrderController::class, 'productionWorkflow'])->name('production.workflow');
    
    // Production Representatives (المندوبين)
    Route::get('/production/representatives', [\App\Http\Controllers\RepresentativeController::class, 'index'])->name('production.representatives.index');
    Route::post('/production/representatives', [\App\Http\Controllers\RepresentativeController::class, 'store'])->name('production.representatives.store');
    Route::delete('/production/representatives/{representative}', [\App\Http\Controllers\RepresentativeController::class, 'destroy'])->name('production.representatives.destroy');
    
    // Production Work Orders List
    Route::get('/production/work-orders', [\App\Http\Controllers\WorkOrderController::class, 'productionEmployeeList'])->name('production.work-orders');
    
    // Production Work Order Show
    Route::get('/production/work-orders/{workOrder}', [\App\Http\Controllers\WorkOrderController::class, 'showForProduction'])->name('production.work-orders.show');
    
    // Production Work Order Update Design Fields
    Route::post('/production/work-orders/{workOrder}/update-design-fields', [\App\Http\Controllers\WorkOrderController::class, 'updateProductionDesignFields'])->name('production.work-orders.update-design-fields');
    
    // Production Work Order Update Knife
    Route::post('/production/work-orders/{workOrder}/update-knife', [\App\Http\Controllers\WorkOrderController::class, 'updateProductionKnife'])->name('production.work-orders.update-knife');
    
    // Production Preparations List
    Route::get('/production/preparations', [\App\Http\Controllers\WorkOrderController::class, 'productionPreparationsList'])->name('production.preparations');
    
    // Employee Routes (Accounting Employees) - Dashboard, Employees, and Departments
    Route::get('/accounting/dashboard', function () {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'حسابات') {
            abort(403);
        }
        
        $employeesCount = \App\Models\Employee::count();
        $departmentsCount = \App\Models\Department::count();
        $recentEmployees = \App\Models\Employee::with('department')->latest()->take(5)->get();
        $departments = \App\Models\Department::with('employees')->get();
        
        return view('employee.accounting-dashboard', compact('employeesCount', 'departmentsCount', 'recentEmployees', 'departments'));
    })->name('accounting.dashboard');
    
    // Accounting Employees Routes
    Route::get('/accounting/employees', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('accounting.employees');
    Route::get('/accounting/employees/{employee}', [\App\Http\Controllers\EmployeeController::class, 'show'])->name('accounting.employees.show');
    
    // Accounting Departments Routes
    Route::get('/accounting/departments', [\App\Http\Controllers\DepartmentController::class, 'index'])->name('accounting.departments');
    Route::get('/accounting/departments/{department}', [\App\Http\Controllers\DepartmentController::class, 'show'])->name('accounting.departments.show');
    
    // Accounting Materials Routes
    Route::get('/accounting/materials', [\App\Http\Controllers\MaterialController::class, 'index'])->name('accounting.materials');
    Route::get('/accounting/materials/{material}', [\App\Http\Controllers\MaterialController::class, 'show'])->name('accounting.materials.show');
    
    // Accounting Payment Methods Routes
    Route::get('/accounting/payment-methods', [\App\Http\Controllers\PaymentMethodController::class, 'index'])->name('accounting.payment-methods');
    Route::get('/accounting/payment-methods/{paymentMethod}', [\App\Http\Controllers\PaymentMethodController::class, 'show'])->name('accounting.payment-methods.show');
    
    // Accounting Additions Routes
    Route::get('/accounting/additions', [\App\Http\Controllers\AdditionController::class, 'index'])->name('accounting.additions');
    Route::get('/accounting/additions/{addition}', [\App\Http\Controllers\AdditionController::class, 'show'])->name('accounting.additions.show');
    
    // Accounting Expenses Routes
    Route::get('/accounting/expenses', [\App\Http\Controllers\ExpenseController::class, 'index'])->name('accounting.expenses');
    Route::get('/accounting/expenses/{expense}', [\App\Http\Controllers\ExpenseController::class, 'show'])->name('accounting.expenses.show');
    
    // Accounting Expense Types Routes
    Route::get('/accounting/expense-types', [\App\Http\Controllers\ExpenseTypeController::class, 'index'])->name('accounting.expense-types');
    Route::get('/accounting/expense-types/{expenseType}', [\App\Http\Controllers\ExpenseTypeController::class, 'show'])->name('accounting.expense-types.show');
    
    // Accounting Suppliers Routes
    Route::get('/accounting/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('accounting.suppliers');
    Route::get('/accounting/suppliers/{supplier}', [\App\Http\Controllers\SupplierController::class, 'show'])->name('accounting.suppliers.show');
    
    // Accounting Wastes Routes
    Route::get('/accounting/wastes', [\App\Http\Controllers\WasteController::class, 'index'])->name('accounting.wastes');
    Route::get('/accounting/wastes/{waste}', [\App\Http\Controllers\WasteController::class, 'show'])->name('accounting.wastes.show');
});
