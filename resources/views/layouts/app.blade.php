<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LabelTech - {{ $title ?? 'لوحة التحكم' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Tajawal', 'Tahoma', 'Arial', sans-serif;
                font-size: 16px;
                background-color: #f3f4f6;
                color: #111827;
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            
            h1, h2, h3, h4, h5, h6 {
                font-weight: 700;
                color: #111827;
                line-height: 1.3;
                font-size: 1.5rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.75rem;
            }
            
            h3 {
                font-size: 1.5rem;
            }
            
            p, span, div, label {
                color: #374151;
                font-size: 1rem;
            }
            
            input, textarea, select {
                font-family: 'Tajawal', 'Tahoma', 'Arial', sans-serif;
                font-size: 1rem;
            }
            
            .sidebar {
                width: 260px;
                background-color: #ffffff;
                border-left: 1px solid #d1d5db;
                height: 100vh;
                position: fixed;
                right: 0;
                top: 0;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
                box-shadow: -2px 0 8px rgba(0, 0, 0, 0.05);
            }
            
            .main-content {
                margin-right: 260px;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }
            
            .top-nav {
                height: 70px;
                background-color: #ffffff;
                border-bottom: 2px solid #e5e7eb;
                display: flex;
                align-items: center;
                padding: 0 2rem;
                position: sticky;
                top: 0;
                z-index: 10;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }
            
            .content-area {
                flex: 1;
                padding: 2rem;
                max-width: 1400px;
                margin: 0 auto;
                width: 100%;
            }
            
            @media (max-width: 1024px) {
                .sidebar {
                    display: none;
                }
                .main-content {
                    margin-right: 0;
                }
            }
            
            .nav-link {
                display: flex;
                align-items: center;
                padding: 0.875rem 1rem;
                color: #4b5563;
                text-decoration: none;
                border-radius: 0.5rem;
                margin-bottom: 0.375rem;
                transition: all 0.2s;
                font-size: 1.0625rem;
                font-weight: 600;
            }
            
            .nav-link:hover {
                background-color: #f3f4f6;
                color: #111827;
            }
            
            .nav-link.active {
                background-color: #eff6ff;
                color: #1d4ed8;
                border-right: 3px solid #2563eb;
                font-weight: 700;
            }
            
            .nav-section-title {
                display: flex;
                align-items: center;
                padding: 0.75rem 1rem;
                color: #111827;
                font-size: 1.25rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-top: 1rem;
                margin-bottom: 0.5rem;
            }
            
            .card {
                background-color: #ffffff;
                border-radius: 0.75rem;
                border: 1px solid #e5e7eb;
                padding: 2rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }
            
            .table-container {
                background-color: #ffffff;
                border-radius: 0.75rem;
                border: 1px solid #e5e7eb;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }
            
            .btn {
                display: inline-flex;
                align-items: center;
                padding: 0.5rem 1rem;
                border-radius: 0.375rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s;
            }
            
            .btn-primary {
                background-color: #2563eb;
                color: #ffffff;
            }
            
            .btn-primary:hover {
                background-color: #1d4ed8;
            }
            
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            
            .table th {
                text-align: right;
                padding: 1rem;
                background-color: #f9fafb;
                font-weight: 600;
                font-size: 1rem;
                color: #374151;
                border-bottom: 2px solid #e5e7eb;
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }
            
            .table td {
                text-align: right;
                padding: 1rem;
                border-bottom: 1px solid #e5e7eb;
                font-size: 1.0625rem;
                color: #374151;
            }
            
            .table tr:hover {
                background-color: #f9fafb;
            }
            
            .table tr:last-child td {
                border-bottom: none;
            }
            
            .table-content {
                padding: 1.5rem;
            }
            
            .table-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem;
                border-bottom: 1px solid #e5e7eb;
                background-color: #f9fafb;
            }
            
            .stat-card {
                background-color: #ffffff;
                border-radius: 0.75rem;
                border: 1px solid #e5e7eb;
                padding: 1.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                transition: all 0.2s;
            }
            
            .stat-card:hover {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }
            
            .stat-label {
                font-size: 1rem;
                font-weight: 500;
                color: #6b7280;
                margin-bottom: 0.5rem;
            }
            
            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #111827;
                line-height: 1.2;
            }
            
            .form-input, .form-textarea, .form-select {
                font-size: 1.0625rem;
                font-weight: 400;
            }
            
            .form-label {
                font-size: 1.0625rem;
                font-weight: 600;
                color: #374151;
            }
            
            button, .btn {
                font-weight: 600;
                font-size: 1.0625rem;
            }
            
            a {
                font-weight: 500;
                font-size: 1rem;
            }
            
        </style>
    </head>
    <body>
        <div style="display: flex; min-height: 100vh;">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Logo -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    @php
                        $isEmployee = auth('employee')->check();
                        $logoDashboardRoute = route('dashboard');
                        if ($isEmployee) {
                            $employeeAccountType = auth('employee')->user()->account_type;
                            if ($employeeAccountType === 'تصميم') {
                                $logoDashboardRoute = route('employee.designer.dashboard');
                            } elseif ($employeeAccountType === 'تشغيل') {
                                $logoDashboardRoute = route('employee.production.dashboard');
                            } else {
                                $logoDashboardRoute = route('employee.dashboard');
                            }
                        }
                    @endphp
                    <a href="{{ $logoDashboardRoute }}" style="display: flex; align-items: center; text-decoration: none;">
                        <div style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: bold; font-size: 1.125rem;">LT</span>
                        </div>
                        <div style="margin-right: 0.75rem;">
                            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.025em;">LabelTech</h1>
                            <p style="font-size: 0.9375rem; color: #6b7280; margin: 0.125rem 0 0 0; font-weight: 500;">
                                @if($isEmployee)
                                    @php
                                        $accountType = auth('employee')->user()->account_type;
                                        $typeLabels = [
                                            'مبيعات' => 'موظف مبيعات',
                                            'تصميم' => 'موظف تصميم',
                                            'تشغيل' => 'موظف تشغيل',
                                            'حسابات' => 'موظف حسابات',
                                        ];
                                    @endphp
                                    {{ $typeLabels[$accountType] ?? 'موظف' }}
                                @else
                                    نظام الإدارة
                                @endif
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Navigation -->
                <nav style="flex: 1; padding: 1rem; overflow-y: auto;">
                    @php
                        $isEmployee = auth('employee')->check();
                        $isAdmin = auth('web')->check(); // تحقق من guard 'web' فقط للادمن
                        $employeeAccountType = $isEmployee ? auth('employee')->user()->account_type : null;
                        $isSalesEmployee = $isEmployee && $employeeAccountType === 'مبيعات';
                        $isDesignEmployee = $isEmployee && $employeeAccountType === 'تصميم';
                        $isProductionEmployee = $isEmployee && $employeeAccountType === 'تشغيل';
                    @endphp

                    <!-- لوحة التحكم - تظهر لجميع المستخدمين -->
                    @php
                        $dashboardRoute = route('dashboard');
                        if ($isEmployee) {
                            if ($isDesignEmployee) {
                                $dashboardRoute = route('employee.designer.dashboard');
                            } elseif ($isProductionEmployee) {
                                $dashboardRoute = route('employee.production.dashboard');
                            } else {
                                $dashboardRoute = route('employee.dashboard');
                            }
                        }
                        $isDashboardActive = request()->routeIs('dashboard') || 
                                            request()->routeIs('employee.dashboard') || 
                                            request()->routeIs('employee.designer.dashboard') || 
                                            request()->routeIs('employee.production.dashboard');
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="nav-link {{ $isDashboardActive ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        لوحة التحكم
                    </a>

                    @if($isSalesEmployee || $isAdmin)
                        <!-- إدخال بيانات - للمبيعات والادمن فقط -->
                        <div class="nav-section-title " style="margin-top: 1rem; font-size: 1.25rem; font-weight: 700; color: #111827; border-top: 1px solid #e5e7eb; padding-top: 1rem;">   
                            إدخال بيانات
                        </div>

                        <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            العملاء
                        </a>
                    @endif

                    @if($isAdmin)
                        <a href="{{ route('sales-teams.index') }}" class="nav-link {{ request()->routeIs('sales-teams.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            فرق المبيعات
                        </a>
                        
                        <a href="{{ route('client-distribution.index') }}" class="nav-link {{ request()->routeIs('client-distribution.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            توزيع العملاء
                        </a>
                        
                        <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            الموظفين
                        </a>

                        <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            الموردين
                        </a>
                    @endif

                    @if($isSalesEmployee || $isProductionEmployee || $isAdmin)
                        <!-- أمر التصنيع -->
                        <div class="nav-section-title " style="margin-top: 1rem; font-size: 1.25rem; font-weight: 700; color: #111827; border-top: 1px solid #e5e7eb; padding-top: 1rem;">   
                            امر التصنيع
                        </div>

                        @php
                            $currentRoute = request()->route()?->getName() ?? '';
                            $route = request()->route();
                            $isWorkOrderRoute = $currentRoute === 'work-orders.index' || 
                                                $currentRoute === 'work-orders.create' ||
                                                ($currentRoute === 'work-orders.edit' && $route && $route->hasParameter('work_order')) ||
                                                ($currentRoute === 'work-orders.show' && $route && $route->hasParameter('work_order')) ||
                                                ($currentRoute === 'work-orders.print' && $route && $route->hasParameter('workOrder')) ||
                                                str_starts_with($currentRoute, 'work-orders.design.');
                            $isWorkOrderListRoute = $currentRoute === 'work-orders.list';
                        @endphp
                        <a href="{{ route('work-orders.index') }}" class="nav-link {{ $isWorkOrderRoute ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ $isSalesEmployee ? 'عرض السعر' : 'أمر الشغل' }}
                        </a>
                    @endif
                    
                    <!-- أمر شغل - يظهر لجميع المستخدمين -->
                    @php
                        $currentRoute = request()->route()?->getName() ?? '';
                        $isWorkOrderListRoute = $currentRoute === 'work-orders.list';
                    @endphp
                    <a href="{{ route('work-orders.list') }}" class="nav-link {{ $isWorkOrderListRoute ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        أمر شغل
                    </a>
                    
                    <!-- الأرشيف - يظهر لجميع المستخدمين -->
                    @php
                        $isArchiveRoute = $currentRoute === 'work-orders.archive';
                    @endphp
                    <a href="{{ route('work-orders.archive') }}" class="nav-link {{ $isArchiveRoute ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                        الأرشيف
                    </a>

                    @if($isDesignEmployee || $isProductionEmployee || $isAdmin)
                        <!-- السكاكين - للمصمم والتشغيل والادمن -->
                        <a href="{{ route('knives.index') }}" class="nav-link {{ request()->routeIs('knives.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            السكاكين
                        </a>
                    @endif

                    @if($isAdmin)
                        <a href="{{ route('work-orders.archive') }}" class="nav-link {{ request()->routeIs('work-orders.archive') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            الأرشيف
                        </a>

                        <div class="nav-section-title " style="margin-top: 1rem; font-size: 1.25rem; font-weight: 700; color: #111827; border-top: 1px solid #e5e7eb; padding-top: 1rem;">   
                            المصروفات
                        </div>
                        <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            المصروفات
                        </a>
                        <a href="{{ route('expense-types.index') }}" class="nav-link {{ request()->routeIs('expense-types.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            أنواع المصروفات
                        </a>

                        <!-- الإعدادات -->
                        <div class="nav-section-title " style="margin-top: 1rem; font-size: 1.25rem; font-weight: 700; color: #111827; border-top: 1px solid #e5e7eb; padding-top: 1rem;">   
                            الإعدادات
                        </div>

                        <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') || request()->routeIs('positions.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            أقسام الشركة
                        </a>

                        <a href="{{ route('payment-methods.index') }}" class="nav-link {{ request()->routeIs('payment-methods.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            طرق السداد
                        </a>

                        <a href="{{ route('materials.index') }}" class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            الخامات
                        </a>

                        <a href="{{ route('additions.index') }}" class="nav-link {{ request()->routeIs('additions.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            الاضافات
                        </a>

                        <a href="{{ route('wastes.index') }}" class="nav-link {{ request()->routeIs('wastes.*') ? 'active' : '' }}">
                            <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            الطباعة
                        </a>
                    @endif
                </nav>

                <!-- User Section -->
                <div style="padding: 1rem; border-top: 1px solid #e5e7eb;">
                    @php
                        $isEmployee = auth('employee')->check();
                        $isAdmin = auth('web')->check(); // تحقق من guard 'web' فقط للادمن
                    @endphp
                    <div style="display: flex; align-items: center;">
                        <div style="width: 40px; height: 40px; background-color: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            @if($isEmployee)
                                <span style="color: #2563eb; font-weight: 600; font-size: 0.875rem;">{{ strtoupper(substr(auth('employee')->user()->name, 0, 1)) }}</span>
                            @else
                                <span style="color: #2563eb; font-weight: 600; font-size: 0.875rem;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div style="margin-right: 0.75rem; flex: 1; min-width: 0;">
                            @if($isEmployee)
                                @php
                                    $accountType = auth('employee')->user()->account_type;
                                    $typeLabels = [
                                        'مبيعات' => 'موظف مبيعات',
                                        'تصميم' => 'موظف تصميم',
                                        'تشغيل' => 'موظف تشغيل',
                                        'حسابات' => 'موظف حسابات',
                                    ];
                                @endphp
                                <p style="font-size: 1rem; font-weight: 500; color: #111827; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ auth('employee')->user()->name }}</p>
                                <p style="font-size: 1rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $typeLabels[$accountType] ?? 'موظف' }}</p>
                            @else
                                <p style="font-size: 1rem; font-weight: 500; color: #111827; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</p>
                                <p style="font-size: 1rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->email }}</p>
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="margin-top: 0.75rem;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 0.5rem; background-color: #ef4444; color: white; border: none; border-radius: 0.375rem; font-size: 1rem; font-weight: 600; cursor: pointer;">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content" style="flex: 1;">
                <!-- Top Navigation -->
                <div class="top-nav">
                    <h1 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.025em;">{{ $title ?? 'لوحة التحكم' }}</h1>
                </div>

                <!-- Page Content -->
                <div class="content-area">
                    @if(session('success'))
                        <div style="margin-bottom: 1rem; padding: 1rem; background-color: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; border-radius: 0.5rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="margin-bottom: 1rem; padding: 1rem; background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; border-radius: 0.5rem;">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
