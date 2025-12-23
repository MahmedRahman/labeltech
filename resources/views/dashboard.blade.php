<x-app-layout>
    @php
        $title = 'لوحة التحكم';
    @endphp

    <style>
        .welcome-card {
            background: linear-gradient(to left, #2563eb, #1d4ed8);
            border-radius: 0.5rem;
            padding: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #111827;
            margin: 0.5rem 0;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #6b7280;
            margin: 0;
        }
        
        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        
        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-content {
            padding: 1.5rem;
        }
    </style>

    <!-- Welcome Section -->
    <div class="welcome-card">
        <h2 style="font-size: 1.75rem; font-weight: bold; margin-bottom: 0.5rem;">مرحباً بك، {{ Auth::user()->name }}</h2>
        <p style="font-size: 1.125rem; color: rgba(255, 255, 255, 0.9); margin: 0;">إليك نظرة سريعة على إحصائيات النظام</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Total Clients -->
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p class="stat-label">إجمالي العملاء</p>
                    <p class="stat-number">{{ $clientsCount }}</p>
                </div>
                <div style="width: 48px; height: 48px; background-color: #dbeafe; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 32px; height: 32px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('clients.index') }}" style="margin-top: 1rem; display: inline-flex; align-items: center; color: #2563eb; text-decoration: none; font-size: 1rem;">
                عرض الكل
                <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>

        <!-- Total Employees -->
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p class="stat-label">إجمالي الموظفين</p>
                    <p class="stat-number">{{ $employeesCount }}</p>
                </div>
                <div style="width: 48px; height: 48px; background-color: #fef3c7; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 32px; height: 32px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('employees.index') }}" style="margin-top: 1rem; display: inline-flex; align-items: center; color: #2563eb; text-decoration: none; font-size: 1rem;">
                عرض الكل
                <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>

        <!-- Total Suppliers -->
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p class="stat-label">إجمالي الموردين</p>
                    <p class="stat-number">{{ $suppliersCount }}</p>
                </div>
                <div style="width: 48px; height: 48px; background-color: #e0e7ff; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 32px; height: 32px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('suppliers.index') }}" style="margin-top: 1rem; display: inline-flex; align-items: center; color: #2563eb; text-decoration: none; font-size: 1rem;">
                عرض الكل
                <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>

        <!-- Total Work Orders -->
        <a href="{{ route('work-orders.index') }}" style="text-decoration: none; display: block;">
            <div class="stat-card" style="cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p class="stat-label">إجمالي أوامر الشغل</p>
                        <p class="stat-number">{{ $workOrdersCount }}</p>
                    </div>
                    <div style="width: 48px; height: 48px; background-color: #fce7f3; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 32px; height: 32px; color: #ec4899;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: inline-flex; align-items: center; color: #2563eb; font-size: 1rem;">
                    عرض جميع أوامر الشغل
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Sales Teams -->
        <a href="{{ route('sales-teams.index') }}" style="text-decoration: none; display: block;">
            <div class="stat-card" style="cursor: pointer;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p class="stat-label">فرق المبيعات</p>
                        <p class="stat-number">{{ $salesTeamsCount ?? 0 }}</p>
                    </div>
                    <div style="width: 48px; height: 48px; background-color: #fef3c7; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 32px; height: 32px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: inline-flex; align-items: center; color: #f59e0b; font-size: 1rem;">
                    عرض جميع فرق المبيعات
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
            </div>
        </a>

        <!-- Quick Actions -->
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p class="stat-label">إجراءات سريعة</p>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #111827; margin: 0.5rem 0;">إضافة</p>
                </div>
                <div style="width: 48px; height: 48px; background-color: #d1fae5; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 32px; height: 32px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
            <div style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="{{ route('clients.create') }}" style="display: inline-flex; align-items: center; color: #10b981; text-decoration: none; font-size: 1rem;">
                    إضافة عميل
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <a href="{{ route('employees.create') }}" style="display: inline-flex; align-items: center; color: #10b981; text-decoration: none; font-size: 1rem;">
                    إضافة موظف
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <a href="{{ route('suppliers.create') }}" style="display: inline-flex; align-items: center; color: #10b981; text-decoration: none; font-size: 1rem;">
                    إضافة مورد
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                @php
                    $hasPendingQuote = \App\Models\WorkOrder::where('sent_to_client', 'yes')
                        ->where(function($q) {
                            $q->whereNull('client_response')
                              ->orWhere('client_response', '');
                        })
                        ->exists();
                @endphp
                @if(!$hasPendingQuote)
                <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; color: #10b981; text-decoration: none; font-size: 1rem;">
                    إضافة أمر شغل
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                @endif
                <a href="{{ route('client-distribution.index') }}" style="display: inline-flex; align-items: center; color: #10b981; text-decoration: none; font-size: 1rem;">
                    توزيع العملاء على الفرق
                    <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

   
</x-app-layout>
