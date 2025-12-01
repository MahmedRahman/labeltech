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
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Cairo', 'Arial', sans-serif;
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
            }
            
            p, span, div, label {
                color: #374151;
            }
            
            input, textarea, select {
                font-family: 'Cairo', 'Arial', sans-serif;
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
                font-size: 0.9375rem;
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
                color: #6b7280;
                font-size: 0.8125rem;
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
                font-size: 0.875rem;
                color: #374151;
                border-bottom: 2px solid #e5e7eb;
                text-transform: uppercase;
                letter-spacing: 0.025em;
            }
            
            .table td {
                text-align: right;
                padding: 1rem;
                border-bottom: 1px solid #e5e7eb;
                font-size: 0.9375rem;
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
                font-size: 0.875rem;
                font-weight: 500;
                color: #6b7280;
                margin-bottom: 0.5rem;
            }
            
            .stat-number {
                font-size: 2rem;
                font-weight: 700;
                color: #111827;
                line-height: 1.2;
            }
            
            .form-input, .form-textarea, .form-select {
                font-size: 0.9375rem;
                font-weight: 400;
            }
            
            .form-label {
                font-size: 0.9375rem;
                font-weight: 600;
                color: #374151;
            }
            
            button, .btn {
                font-weight: 600;
                font-size: 0.9375rem;
            }
            
            a {
                font-weight: 500;
            }
            
        </style>
    </head>
    <body>
        <div style="display: flex; min-height: 100vh;">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Logo -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; text-decoration: none;">
                        <div style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: bold; font-size: 1.125rem;">LT</span>
                        </div>
                        <div style="margin-right: 0.75rem;">
                            <h1 style="font-size: 1.375rem; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.025em;">LabelTech</h1>
                            <p style="font-size: 0.8125rem; color: #6b7280; margin: 0.125rem 0 0 0; font-weight: 500;">نظام الإدارة</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation -->
                <nav style="flex: 1; padding: 1rem; overflow-y: auto;">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        لوحة التحكم
                    </a>

                    <!-- إدخال بيانات -->
                    <div class="nav-section-title">
                        <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        إدخال بيانات
                    </div>

                    <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        العملاء
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

                    <a href="{{ route('work-orders.index') }}" class="nav-link {{ request()->routeIs('work-orders.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        أمر الشغل
                    </a>

                    <!-- الإعدادات -->
                    <div class="nav-section-title">
                        <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        الإعدادات
                    </div>

                    <a href="{{ route('expense-types.index') }}" class="nav-link {{ request()->routeIs('expense-types.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        أنواع المصروفات
                    </a>

                    <a href="{{ route('payment-methods.index') }}" class="nav-link {{ request()->routeIs('payment-methods.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        طرق السداد
                    </a>

                    <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        المصروفات
                    </a>

                    <a href="{{ route('materials.index') }}" class="nav-link {{ request()->routeIs('materials.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        الخامات
                    </a>

                    <a href="{{ route('knives.index') }}" class="nav-link {{ request()->routeIs('knives.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        السكاكين
                    </a>

                    <a href="{{ route('wastes.index') }}" class="nav-link {{ request()->routeIs('wastes.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        الهالك
                    </a>
                </nav>

                <!-- User Section -->
                <div style="padding: 1rem; border-top: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center;">
                        <div style="width: 40px; height: 40px; background-color: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span style="color: #2563eb; font-weight: 600; font-size: 0.875rem;">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div style="margin-right: 0.75rem; flex: 1; min-width: 0;">
                            <p style="font-size: 0.875rem; font-weight: 500; color: #111827; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->name }}</p>
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content" style="flex: 1;">
                <!-- Top Navigation -->
                <div class="top-nav">
                    <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.025em;">{{ $title ?? 'لوحة التحكم' }}</h1>
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
