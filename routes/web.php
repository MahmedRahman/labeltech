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
    $recentClients = \App\Models\Client::latest()->take(5)->get();
    $recentEmployees = \App\Models\Employee::latest()->take(5)->get();
    $recentSuppliers = \App\Models\Supplier::latest()->take(5)->get();
    $recentWorkOrders = \App\Models\WorkOrder::with('client')->latest()->take(5)->get();
    return view('dashboard', compact('clientsCount', 'employeesCount', 'suppliersCount', 'workOrdersCount', 'recentClients', 'recentEmployees', 'recentSuppliers', 'recentWorkOrders'));
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
    Route::get('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'showDesignForm'])->name('work-orders.design.show');
    Route::post('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'storeDesign'])->name('work-orders.design.store');
    Route::post('work-orders/{workOrder}/production-status', [\App\Http\Controllers\WorkOrderController::class, 'updateProductionStatus'])->name('work-orders.production-status.update');
    Route::post('work-orders/{workOrder}/mark-as-sent', [\App\Http\Controllers\WorkOrderController::class, 'markAsSentToClient'])->name('work-orders.mark-as-sent');
    Route::post('work-orders/{workOrder}/client-response', [\App\Http\Controllers\WorkOrderController::class, 'updateClientResponse'])->name('work-orders.client-response.update');
    Route::post('work-orders/{workOrder}/convert-to-order', [\App\Http\Controllers\WorkOrderController::class, 'convertToOrder'])->name('work-orders.convert-to-order');
    Route::post('work-orders/{workOrder}/archive', [\App\Http\Controllers\WorkOrderController::class, 'archiveQuote'])->name('work-orders.archive-quote');
    Route::get('work-orders-list', [\App\Http\Controllers\WorkOrderController::class, 'workOrdersList'])->name('work-orders.list');
    Route::get('work-orders/archive', [\App\Http\Controllers\WorkOrderController::class, 'archive'])->name('work-orders.archive');
    Route::resource('work-orders', \App\Http\Controllers\WorkOrderController::class);
    
    // السكاكين - متاح للمصمم والادمن
    Route::get('knives/export', [\App\Http\Controllers\KnifeController::class, 'export'])->name('knives.export');
    Route::get('knives/get-next-code', [\App\Http\Controllers\KnifeController::class, 'getNextKnifeCode'])->name('knives.get-next-code');
    Route::get('knives/get-filter-values', [\App\Http\Controllers\KnifeController::class, 'getFilterValues'])->name('knives.get-filter-values');
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
});

require __DIR__.'/auth.php';

// Employee Authentication Routes - Redirect to main login
Route::middleware('guest')->group(function () {
    Route::get('employee/login', function () {
        return redirect()->route('login');
    })->name('employee.login');
});

// Employee Routes (Sales Employees Only) - Dashboard only
Route::middleware(['auth:employee', 'employee.sales'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () {
        $workOrdersCount = \App\Models\WorkOrder::where('production_status', '!=', 'أرشيف')->count();
        $recentWorkOrders = \App\Models\WorkOrder::with('client')
            ->where('production_status', '!=', 'أرشيف')
            ->latest()
            ->take(5)
            ->get();
        $clientsCount = \App\Models\Client::count();
        $recentClients = \App\Models\Client::latest()->take(5)->get();
        return view('employee.dashboard', compact('workOrdersCount', 'recentWorkOrders', 'clientsCount', 'recentClients'));
    })->name('dashboard');
    
    // Logout is handled by the main auth routes
    // Work Orders routes are now handled by auth.any middleware above
});

// Employee Routes (Design Employees) - Dashboard and Knives only
Route::middleware(['auth:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/designer/dashboard', function () {
        $employee = auth('employee')->user();
        if ($employee->account_type !== 'تصميم') {
            abort(403);
        }
        $knivesCount = \App\Models\Knife::count();
        $recentKnives = \App\Models\Knife::latest()->take(5)->get();
        return view('employee.designer-dashboard', compact('knivesCount', 'recentKnives'));
    })->name('designer.dashboard');
    
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
        
        return view('employee.production-dashboard', compact('workOrdersCount', 'recentWorkOrders', 'knivesCount', 'recentKnives'));
    })->name('production.dashboard');
});
