<x-app-layout>
    @php
        $title = 'أمر شغل';
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

        .btn-view {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            background-color: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background-color: #bfdbfe;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">أمر شغل</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">عرض جميع أوامر الشغل المحولة من عروض الأسعار</p>
        </div>
        <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة للقائمة
        </a>
    </div>

    <!-- Filters -->
    <div style="margin-bottom: 1.5rem; background: white; padding: 1.25rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
        <form method="GET" action="{{ route('work-orders.list') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 250px;">
                <label for="client_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">فلترة بالعميل</label>
                <select name="client_id" id="client_id" style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; background-color: white; cursor: pointer;">
                    <option value="">جميع العملاء</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }} @if($client->company) - {{ $client->company }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 250px;">
                <label for="order_number" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">البحث برقم عرض السعر</label>
                <input type="text" 
                       name="order_number" 
                       id="order_number" 
                       value="{{ request('order_number') }}" 
                       placeholder="أدخل رقم عرض السعر للبحث..."
                       style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; background-color: white;">
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" style="padding: 0.625rem 1.25rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                    بحث
                </button>
                <a href="{{ route('work-orders.list') }}" style="padding: 0.625rem 1.25rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; display: inline-flex; align-items: center;">
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    @if($workOrders->count() > 0)
        <!-- Table View -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <th>رقم عرض السعر</th>
                        <th>العميل</th>
                        <th>اسم العمل</th>
                        <th>الخامة</th>
                        <th>الكمية</th>
                        <th>الأبعاد</th>
                        <th>رد العميل على عرض السعر</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workOrders as $workOrder)
                        @if(isset($workOrder->id) && !is_null($workOrder->id))
                        @php
                            $statusColors = [
                                'work_order' => '#2563eb'
                            ];
                            $statusLabels = [
                                'work_order' => 'أمر شغل'
                            ];
                            $color = $statusColors[$workOrder->status] ?? '#6b7280';
                            $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                        @endphp
                        <tr>
                            <td>
                                @if($workOrder->created_at)
                                    {{ $workOrder->created_at->format('Y-m-d') }}
                                    <br>
                                    <small style="color: #9ca3af; font-size: 0.75rem;">{{ $workOrder->created_at->format('H:i') }}</small>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #111827;">{{ $workOrder->order_number ?? 'بدون رقم' }}</strong>
                            </td>
                            <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                            <td>
                                @if($workOrder->job_name)
                                    <span style="color: #2563eb; font-weight: 500;">{{ $workOrder->job_name }}</span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>{{ $workOrder->material ?? '-' }}</td>
                            <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                            <td>
                                @if($workOrder->width && $workOrder->length)
                                    {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }}
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($workOrder->client_response)
                                    @php
                                        $clientResponseColors = [
                                            'موافق' => '#10b981',
                                            'رفض' => '#dc2626',
                                            'لم يرد' => '#6b7280'
                                        ];
                                        $responseColor = $clientResponseColors[$workOrder->client_response] ?? '#6b7280';
                                    @endphp
                                    <span class="status-badge" style="background-color: {{ $responseColor }}20; color: {{ $responseColor }};">
                                        {{ $workOrder->client_response }}
                                    </span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge" style="background-color: {{ $color }}20; color: {{ $color }};">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0;">لا توجد أوامر شغل</h3>
            <p style="font-size: 1rem; color: #6b7280; margin: 0 0 1.5rem 0;">لم يتم تحويل أي عرض سعر إلى أمر شغل بعد</p>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة الرئيسية
            </a>
        </div>
    @endif
</x-app-layout>

