<x-app-layout>
    @php
        $title = 'المندوبين';
    @endphp

    <style>
        .data-table {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .data-table table { width: 100%; border-collapse: collapse; }
        .data-table thead { background: #f9fafb; }
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
        .data-table tbody tr:hover { background: #f9fafb; }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }
        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; }
        }
    </style>

    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">المندوبين</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">إدارة المندوبين — الاسم ورقم التليفون</p>
        </div>
        <a href="{{ route('employee.production.dashboard') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة للوحة التحكم
        </a>
    </div>

    @if (session('success'))
        <div style="margin-bottom: 1.5rem; padding: 0.75rem 1rem; background-color: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; border-radius: 0.5rem; font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add Representative Form -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0;">إضافة مندوب جديد</h3>
        <form action="{{ route('employee.production.representatives.store') }}" method="POST" class="form-row">
            @csrf
            <div>
                <label for="rep_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">الاسم</label>
                <input type="text" name="name" id="rep_name" value="{{ old('name') }}" required maxlength="255" placeholder="اسم المندوب" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem;">
                @error('name')
                    <div style="margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="rep_phone" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.375rem;">رقم التليفون</label>
                <input type="text" name="phone" id="rep_phone" value="{{ old('phone') }}" maxlength="50" placeholder="رقم التليفون" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.9375rem;">
                @error('phone')
                    <div style="margin-top: 0.25rem; font-size: 0.8125rem; color: #dc2626;">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" style="padding: 0.5rem 1.25rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; border: none; border-radius: 0.375rem; font-weight: 500; font-size: 0.875rem; cursor: pointer; white-space: nowrap;">
                إضافة مندوب
            </button>
        </form>
    </div>

    <!-- Representatives List -->
    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>رقم التليفون</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($representatives as $rep)
                    <tr>
                        <td style="font-weight: 500; color: #111827;">{{ $rep->name }}</td>
                        <td style="color: #6b7280;">{{ $rep->phone ?? '—' }}</td>
                        <td>
                            <form action="{{ route('employee.production.representatives.destroy', $rep) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل تريد حذف هذا المندوب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 0.25rem 0.5rem; background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 0.375rem; font-size: 0.8125rem; cursor: pointer;">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2rem; color: #6b7280;">لا يوجد مندوبون. استخدم النموذج أعلاه لإضافة مندوب.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
