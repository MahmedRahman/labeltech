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
    </style>

    <!-- Welcome Section -->
    <div class="welcome-card">
        <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 32px; height: 32px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            مرحباً بك، {{ auth('employee')->user()->name }}
        </h2>
        <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 1rem;">لوحة التحكم الخاصة بالمصمم</p>
    </div>

    <!-- Quick Actions -->
    <div class="stats-grid">
        <a href="{{ route('employee.designer.work-orders') }}" style="text-decoration: none;">
            <div class="stat-card" style="cursor: pointer;">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">أوامر الشغل المرسلة</div>
                        <div class="stat-number">{{ \App\Models\WorkOrder::where('sent_to_designer', 'yes')->where('status', 'work_order')->count() }}</div>
                    </div>
                    <div class="stat-icon knives">
                        <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        
        <a href="{{ route('employee.designer.preparations') }}" style="text-decoration: none;">
            <div class="stat-card" style="cursor: pointer;">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <div class="stat-label">التجهيزات</div>
                        <div class="stat-number">{{ \App\Models\WorkOrder::where('status', 'in_progress')->count() }}</div>
                    </div>
                    <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #f59e0b;">
                        <svg style="width: 28px; height: 28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
    </div>
</x-app-layout>

