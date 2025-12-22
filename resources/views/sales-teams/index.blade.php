<x-app-layout>
    @php
        $title = 'فرق المبيعات';
    @endphp

    <style>
        .data-table {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #f9fafb;
        }

        .data-table th {
            padding: 1rem;
            text-align: right;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .data-table td {
            padding: 1rem;
            text-align: right;
            font-size: 0.875rem;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-view, .btn-edit, .btn-delete {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-view {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background-color: #bfdbfe;
        }

        .btn-edit {
            background-color: #d1fae5;
            color: #065f46;
        }

        .btn-edit:hover {
            background-color: #a7f3d0;
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
            border: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #fecaca;
        }

        .employee-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            background-color: #e0e7ff;
            color: #4338ca;
            margin: 0.25rem;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">فرق المبيعات</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">إدارة فرق المبيعات وموظفيها</p>
        </div>
        <a href="{{ route('sales-teams.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة فريق مبيعات جديد
        </a>
    </div>

    @if($salesTeams->count() > 0)
        <!-- Table View -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>اسم الفريق</th>
                        <th>الوصف</th>
                        <th>عدد الموظفين</th>
                        <th>أعضاء الفريق</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesTeams as $team)
                        <tr>
                            <td>
                                <strong style="color: #111827;">{{ $team->name }}</strong>
                            </td>
                            <td>
                                <span style="color: #6b7280;">{{ $team->description ?? '-' }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #2563eb;">{{ $team->employees->count() }}</span>
                            </td>
                            <td>
                                @if($team->employees->count() > 0)
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.25rem;">
                                        @foreach($team->employees->take(3) as $employee)
                                            <span class="employee-badge">{{ $employee->name }}</span>
                                        @endforeach
                                        @if($team->employees->count() > 3)
                                            <span class="employee-badge" style="background-color: #f3f4f6; color: #6b7280;">
                                                +{{ $team->employees->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color: #9ca3af;">لا يوجد موظفين</span>
                                @endif
                            </td>
                            <td>
                                @if($team->created_at)
                                    {{ $team->created_at->format('Y-m-d') }}
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('sales-teams.show', $team->id) }}" class="btn-view">عرض</a>
                                    <a href="{{ route('sales-teams.edit', $team->id) }}" class="btn-edit">تعديل</a>
                                    <form action="{{ route('sales-teams.destroy', $team->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفريق؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0;">لا توجد فرق مبيعات</h3>
            <p style="font-size: 1rem; color: #6b7280; margin: 0 0 1.5rem 0;">ابدأ بإضافة فريق مبيعات جديد</p>
            <a href="{{ route('sales-teams.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                إضافة فريق مبيعات جديد
            </a>
        </div>
    @endif
</x-app-layout>

