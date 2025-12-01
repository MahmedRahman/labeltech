<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية - تسجيل الدخول
Route::get('/', function () {
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
    
    // العملاء
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    
    // الموظفين
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    
    // الموردين
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    
    // أنواع المصروفات
    Route::resource('expense-types', \App\Http\Controllers\ExpenseTypeController::class);
    
    // طرق السداد
    Route::resource('payment-methods', \App\Http\Controllers\PaymentMethodController::class);
    
    // الخامات
    Route::resource('materials', \App\Http\Controllers\MaterialController::class);
    
    // السكاكين
    Route::resource('knives', \App\Http\Controllers\KnifeController::class);
    
    // الهالك
    Route::resource('wastes', \App\Http\Controllers\WasteController::class);
    
    // المصروفات
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
    
    // أوامر الشغل
    Route::resource('work-orders', \App\Http\Controllers\WorkOrderController::class);
    Route::get('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'showDesignForm'])->name('work-orders.design.show');
    Route::post('work-orders/{workOrder}/design', [\App\Http\Controllers\WorkOrderController::class, 'storeDesign'])->name('work-orders.design.store');
    Route::get('work-orders/{workOrder}/production', [\App\Http\Controllers\WorkOrderController::class, 'showProductionForm'])->name('work-orders.production.show');
    Route::post('work-orders/{workOrder}/production', [\App\Http\Controllers\WorkOrderController::class, 'storeProduction'])->name('work-orders.production.store');
});

require __DIR__.'/auth.php';
