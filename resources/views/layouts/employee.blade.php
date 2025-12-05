<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>LabelTech - {{ $title ?? 'أوامر التصنيع' }}</title>

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
                justify-content: space-between;
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
                color: #2563eb;
            }
            
            .nav-section-title {
                margin-top: 1rem;
                font-size: 1rem;
                font-weight: 600;
                color: #111827;
                border-top: 1px solid #e5e7eb;
                padding-top: 1rem;
                margin-bottom: 0.5rem;
            }
            
            .user-info {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem;
                border-top: 1px solid #e5e7eb;
                margin-top: auto;
            }
            
            .user-avatar {
                width: 40px;
                height: 40px;
                background-color: #2563eb;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 600;
            }
            
            .user-details {
                flex: 1;
            }
            
            .user-name {
                font-size: 0.875rem;
                font-weight: 600;
                color: #111827;
            }
            
            .user-role {
                font-size: 0.75rem;
                color: #6b7280;
            }
            
            .logout-btn {
                padding: 0.5rem 1rem;
                background-color: #ef4444;
                color: white;
                border: none;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: background-color 0.2s;
            }
            
            .logout-btn:hover {
                background-color: #dc2626;
            }
        </style>
    </head>
    <body>
        <div style="display: flex; min-height: 100vh;">
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Logo -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <a href="{{ route('employee.dashboard') }}" style="display: flex; align-items: center; text-decoration: none;">
                        <div style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: bold; font-size: 1.125rem;">LT</span>
                        </div>
                        <div style="margin-right: 0.75rem;">
                            <h1 style="font-size: 1.375rem; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.025em;">LabelTech</h1>
                            <p style="font-size: 0.8125rem; color: #6b7280; margin: 0.125rem 0 0 0; font-weight: 500;">موظف مبيعات</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation -->
                <nav style="flex: 1; padding: 1rem; overflow-y: auto;">
                    <a href="{{ route('employee.dashboard') }}" class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        لوحة التحكم
                    </a>

                    <div class="nav-section-title">
                        أمر التصنيع
                    </div>

                    <a href="{{ route('employee.work-orders.index') }}" class="nav-link {{ request()->routeIs('employee.work-orders.*') ? 'active' : '' }}">
                        <svg style="width: 20px; height: 20px; margin-left: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        أمر الشغل
                    </a>
                </nav>

                <!-- User Info -->
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth('employee')->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth('employee')->user()->name }}</div>
                        <div class="user-role">موظف مبيعات</div>
                    </div>
                </div>

                <!-- Logout -->
                <div style="padding: 1rem; border-top: 1px solid #e5e7eb;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn" style="width: 100%;">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Top Navigation -->
                <div class="top-nav">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0;">
                        {{ $title ?? 'أوامر التصنيع' }}
                    </h2>
                </div>

                <!-- Content Area -->
                <div class="content-area">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>

