<x-app-layout>
    @php
        $title = 'تفاصيل فريق المبيعات';
    @endphp

    <style>
        .card {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .employee-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: #e0e7ff;
            color: #4338ca;
            margin: 0.5rem 0.5rem 0.5rem 0;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">{{ $salesTeam->name }}</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">تفاصيل فريق المبيعات</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('sales-teams.edit', $salesTeam->id) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('sales-teams.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Team Information -->
    <div class="card">
        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0;">معلومات الفريق</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اسم الفريق</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $salesTeam->name }}</dd>
            </div>
            @if($salesTeam->description)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوصف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $salesTeam->description }}</dd>
            </div>
            @endif
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الموظفين</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $salesTeam->employees->count() }}</dd>
            </div>
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإنشاء</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $salesTeam->created_at->format('Y-m-d') }}</dd>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="card">
        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0;">أعضاء الفريق</h3>
        @if($salesTeam->employees->count() > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @foreach($salesTeam->employees as $employee)
                    <span class="employee-badge">{{ $employee->name }}</span>
                @endforeach
            </div>
        @else
            <p style="color: #6b7280; font-size: 0.875rem;">لا يوجد موظفين في هذا الفريق</p>
        @endif
    </div>
</x-app-layout>

