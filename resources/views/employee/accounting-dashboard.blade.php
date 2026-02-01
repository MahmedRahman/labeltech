<x-app-layout>
    @php
        $title = 'لوحة التحكم - الحسابات';
    @endphp

    <style>
        .welcome-card {
            background: linear-gradient(to left, #059669, #047857);
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
            cursor: pointer;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #059669, #047857);
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
        
        .stat-icon.employees {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #047857;
        }
        
        .stat-icon.departments {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #047857;
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
            color: #059669;
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
            color: #059669;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: color 0.2s;
        }
        
        .action-link:hover {
            color: #047857;
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
        
        .status-badge.active {
            background-color: #d1fae5;
            color: #047857;
        }
        
        .status-badge.inactive {
            background-color: #fee2e2;
            color: #991b1b;
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
        <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 1rem;">إدارة الموظفين وأقسام الشركة</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Employees Card -->
        <a href="{{ route('employee.accounting.employees') }}" style="text-decoration: none; color: inherit;">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">إجمالي الموظفين</div>
                        <div class="stat-number">{{ $employeesCount }}</div>
                    </div>
                    <div class="stat-icon employees">
                        <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

        <!-- Departments Card -->
        <a href="{{ route('employee.accounting.departments') }}" style="text-decoration: none; color: inherit;">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">إجمالي الأقسام</div>
                        <div class="stat-number">{{ $departmentsCount }}</div>
                    </div>
                    <div class="stat-icon departments">
                        <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Recent Employees Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                أحدث الموظفين
            </h3>
            <a href="{{ route('employee.accounting.employees') }}" class="action-link">
                عرض الكل
                <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>
        <div class="section-content">
            @if($recentEmployees->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>نوع الحساب</th>
                                <th>القسم</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEmployees as $employee)
                                <tr>
                                    <td style="font-weight: 600; color: #059669;">{{ $employee->name }}</td>
                                    <td style="color: #6b7280;">{{ $employee->email }}</td>
                                    <td style="color: #6b7280;">{{ $employee->account_type ?? '-' }}</td>
                                    <td style="color: #6b7280;">{{ $employee->department->name ?? '-' }}</td>
                                    <td>
                                        <span class="status-badge {{ $employee->status === 'نشط' ? 'active' : 'inactive' }}">
                                            {{ $employee->status ?? 'غير محدد' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('employee.accounting.employees.show', $employee) }}" class="action-link">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <p style="font-size: 0.9375rem; margin: 0;">لا يوجد موظفين حالياً</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Departments Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                أقسام الشركة
            </h3>
            <a href="{{ route('employee.accounting.departments') }}" class="action-link">
                عرض الكل
                <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
        </div>
        <div class="section-content">
            @if($departments->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>اسم القسم</th>
                                <th>الوصف</th>
                                <th>عدد الموظفين</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <td style="font-weight: 600; color: #059669;">{{ $department->name }}</td>
                                    <td style="color: #6b7280;">{{ $department->description ?? '-' }}</td>
                                    <td style="color: #6b7280;">{{ $department->employees->count() ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('employee.accounting.departments.show', $department) }}" class="action-link">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p style="font-size: 0.9375rem; margin: 0;">لا توجد أقسام حالياً</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
