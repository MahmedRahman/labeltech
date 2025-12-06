<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية - تسجيل الدخول
Route::get('/', function () {
    if (auth('employee')->check()) {
        return redirect()->route('employee.dashboard');
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
    Route::get('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'showDesignForm'])->name('work-orders.design.show');
    Route::post('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'storeDesign'])->name('work-orders.design.store');
    Route::post('work-orders/{workOrder}/production-status', [\App\Http\Controllers\WorkOrderController::class, 'updateProductionStatus'])->name('work-orders.production-status.update');
    Route::resource('work-orders', \App\Http\Controllers\WorkOrderController::class);
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
    
    // السكاكين
    Route::get('knives/export', [\App\Http\Controllers\KnifeController::class, 'export'])->name('knives.export');
    Route::post('knives/import', [\App\Http\Controllers\KnifeController::class, 'import'])->name('knives.import');
    Route::get('knives/get-next-code', [\App\Http\Controllers\KnifeController::class, 'getNextKnifeCode'])->name('knives.get-next-code');
    Route::resource('knives', \App\Http\Controllers\KnifeController::class);
    
    // الطباعة
    Route::resource('wastes', \App\Http\Controllers\WasteController::class);
    
    // المصروفات
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    
    // أوامر الشغل - الأرشيف (Admin only)
    Route::get('work-orders/archive', [\App\Http\Controllers\WorkOrderController::class, 'archive'])->name('work-orders.archive');
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
