<x-app-layout>
    @php
        $title = 'لوحة التحكم';
    @endphp

    <style>
        .welcome-card {
            background: linear-gradient(to left, #2563eb, #1d4ed8);
            border-radius: 0.75rem;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #2563eb, #1d4ed8);
        }
        
        .stat-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-4px);
        }
        
        .stat-card-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .stat-info {
            flex: 1;
        }
        
        .stat-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
            line-height: 1;
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .stat-icon.work-orders {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }
        
        .stat-icon.knives {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }
        
        .section-card {
            background-color: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(to right, #f9fafb, #ffffff);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .section-icon {
            width: 24px;
            height: 24px;
            color: #2563eb;
        }
        
        .section-content {
            padding: 1.5rem;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table thead {
            background-color: #f9fafb;
        }
        
        .table th {
            text-align: right;
            padding: 1rem;
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
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.9375rem;
            color: #374151;
        }
        
        .table tbody tr {
            transition: background-color 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .action-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: color 0.2s;
        }
        
        .action-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6b7280;
        }
        
        .empty-state-icon {
            width: 64px;
            height: 64px;
            color: #d1d5db;
            margin: 0 auto 1rem;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .status-badge {
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>

    <!-- Welcome Section -->
    <div class="welcome-card">
        <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            مرحباً بك، {{ auth('employee')->user()->name }}
        </h2>
        <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 1rem;">إليك نظرة سريعة على أوامر الشغل قيد التشغيل</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Work Orders Card -->
        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">إجمالي أوامر الشغل</div>
                    <div class="stat-number">{{ $workOrdersCount }}</div>
                </div>
                <div class="stat-icon work-orders">
                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Knives Card -->
        <div class="stat-card">
            <div class="stat-card-content">
                <div class="stat-info">
                    <div class="stat-label">إجمالي السكاكين</div>
                    <div class="stat-number">{{ $knivesCount }}</div>
                </div>
                <div class="stat-icon knives">
                    <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Work Orders Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                أحدث أوامر الشغل
            </h3>
            <a href="{{ route('work-orders.index') }}" class="action-link">
                عرض الكل
                <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>
        <div class="section-content">
            @if($recentWorkOrders->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رقم أمر الشغل</th>
                                <th>العميل</th>
                                <th>التاريخ</th>
                                <th>حالة التشغيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentWorkOrders as $workOrder)
                                <tr>
                                    <td style="font-weight: 600; color: #2563eb;">#{{ $workOrder->id }}</td>
                                    <td style="font-weight: 500; color: #111827;">{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td style="color: #6b7280;">{{ $workOrder->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="status-badge">
                                            {{ $workOrder->production_status ?? 'بدون حالة' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('work-orders.show', $workOrder) }}" class="action-link">
                                            عرض التفاصيل
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p style="font-size: 0.9375rem; margin: 0;">لا توجد أوامر شغل حالياً</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Knives Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                أحدث السكاكين
            </h3>
            <a href="{{ route('knives.index') }}" class="action-link">
                عرض الكل
                <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>
        <div class="section-content">
            @if($recentKnives->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الرقم الكود</th>
                                <th>النوع</th>
                                <th>الطول</th>
                                <th>العرض</th>
                                <th>درافيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentKnives as $knife)
                                <tr>
                                    <td style="font-weight: 600; color: #2563eb;">{{ $knife->knife_code }}</td>
                                    <td style="color: #6b7280;">{{ $knife->type ?? '-' }}</td>
                                    <td style="color: #6b7280;">{{ $knife->length ? number_format($knife->length, 2) : '-' }}</td>
                                    <td style="color: #6b7280;">{{ $knife->width ? number_format($knife->width, 2) : '-' }}</td>
                                    <td style="color: #6b7280;">{{ $knife->dragile_drive ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('knives.show', $knife) }}" class="action-link">
                                            عرض التفاصيل
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p style="font-size: 0.9375rem; margin: 0;">لا توجد سكاكين حالياً</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

