<x-app-layout>
    @php
        $title = 'قائمة عروض الأسعار';
    @endphp

    <style>
        .data-table {
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .data-table th {
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #111827;
        }

        .data-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .table-actions a {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .table-actions .btn-view {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .table-actions .btn-view:hover {
            background-color: #dbeafe;
        }

        .table-actions .btn-edit {
            background-color: #f0fdf4;
            color: #10b981;
        }

        .table-actions .btn-edit:hover {
            background-color: #dcfce7;
        }

        .table-actions .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .table-actions .btn-delete:hover {
            background-color: #fecaca;
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
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">
                قائمة عروض الأسعار
            </h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">
                إدارة جميع عروض الأسعار من مكان واحد
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة عرض سعر جديد
            </a>
        </div>
    </div>

    @if($workOrders->count() > 0)
        <!-- Sent Status Summary Cards -->
        <div style="margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <!-- Total Orders Card -->
                <div class="summary-card active" data-filter="all" onclick="filterWorkOrders('all')" style="background: white; border-radius: 0.5rem; border: 2px solid #2563eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.2s; cursor: pointer;">
                    <div style="background: #f8fafc; padding: 1rem; text-align: center;">
                        <div style="width: 45px; height: 45px; background: #e0e7ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin: 0 0 0.5rem 0;">إجمالي العروض</h4>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $workOrders->count() }}</p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">عرض سعر</p>
                    </div>
                </div>

                <!-- Sent to Client Card -->
                <div class="summary-card" data-filter="sent" onclick="filterWorkOrders('sent')" style="background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.2s; cursor: pointer;">
                    <div style="background: #f0fdf4; padding: 1rem; text-align: center;">
                        <div style="width: 45px; height: 45px; background: #dcfce7; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin: 0 0 0.5rem 0;">تم الإرسال</h4>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $sentCount ?? 0 }}</p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">عرض سعر</p>
                    </div>
                </div>

                <!-- Not Sent to Client Card -->
                <div class="summary-card" data-filter="not-sent" onclick="filterWorkOrders('not-sent')" style="background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.2s; cursor: pointer;">
                    <div style="background: #fffbeb; padding: 1rem; text-align: center;">
                        <div style="width: 45px; height: 45px; background: #fef3c7; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin: 0 0 0.5rem 0;">لم يتم الإرسال</h4>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $notSentCount ?? 0 }}</p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">عرض سعر</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table View for Sales Employees -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <th>رقم عرض السعر</th>
                        <th>العميل</th>
                        <th>الخامة</th>
                        <th>الكمية</th>
                        <th>المقاس</th>
                        <th>تم الإرسال للعميل</th>
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
                                'draft' => '#6b7280',
                                'pending' => '#f59e0b',
                                'in_progress' => '#2563eb',
                                'completed' => '#10b981',
                                'cancelled' => '#dc2626',
                                'client_approved' => '#10b981',
                                'client_rejected' => '#dc2626',
                                'client_no_response' => '#6b7280',
                                'work_order' => '#2563eb'
                            ];
                            $statusLabels = [
                                'draft' => 'مسودة',
                                'pending' => 'قيد الانتظار',
                                'in_progress' => 'قيد التنفيذ',
                                'completed' => 'مكتمل',
                                'cancelled' => 'ملغي',
                                'client_approved' => 'العميل موافق',
                                'client_rejected' => 'العميل رفض',
                                'client_no_response' => 'العميل لم يرد',
                                'work_order' => 'أمر شغل'
                            ];
                            $color = $statusColors[$workOrder->status] ?? '#6b7280';
                            $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                            $productionStatus = $workOrder->production_status ?? 'بدون حالة';
                        @endphp
                        <tr data-sent-to-client="{{ ($workOrder->sent_to_client ?? 'no') == 'yes' ? 'sent' : 'not-sent' }}">
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
                                @php
                                    $sentToClient = $workOrder->sent_to_client ?? 'no';
                                @endphp
                                @if($sentToClient == 'yes')
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #d1fae5; color: #065f46;">
                                        ✓ تم الإرسال
                                    </span>
                                @else
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #fee2e2; color: #991b1b;">
                                        ✗ لم يتم الإرسال
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $clientResponseColors = [
                                        'موافق' => '#10b981',
                                        'رفض' => '#dc2626',
                                        'لم يرد' => '#6b7280'
                                    ];
                                    $clientResponseLabels = [
                                        'موافق' => 'موافق',
                                        'رفض' => 'رفض',
                                        'لم يرد' => 'لم يرد'
                                    ];
                                    $responseColor = $clientResponseColors[$workOrder->client_response] ?? '#9ca3af';
                                    $responseLabel = $clientResponseLabels[$workOrder->client_response] ?? '-';
                                @endphp
                                @if($workOrder->client_response)
                                    <span class="status-badge" style="background-color: {{ $responseColor }}20; color: {{ $responseColor }};">
                                        {{ $responseLabel }}
                                    </span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $workOrder->status }}" style="background-color: {{ $color }}20; color: {{ $color }};">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                    <a href="{{ route('work-orders.edit', $workOrder->id) }}" class="btn-edit">تعديل</a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                لا توجد عروض أسعار
            </h3>
            <p style="font-size: 1rem; color: #6b7280; margin-bottom: 2rem;">
                ابدأ بإضافة عرض سعر جديد
            </p>
            <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة عرض سعر جديد
            </a>
        </div>
    @endif

    <script>
        // Confirm delete function using SweetAlert
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'هل أنت متأكد من حذف هذا الأمر؟ لا يمكن التراجع عن هذه العملية.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            
            return false;
        }
        
        // Filter work orders by sent to client status
        function filterWorkOrders(filterType) {
            // Remove active class from all summary cards
            document.querySelectorAll('.summary-card').forEach(card => {
                card.classList.remove('active');
                card.style.border = '1px solid #e5e7eb';
            });
            
            // Add active class to clicked card
            const clickedCard = event.currentTarget;
            clickedCard.classList.add('active');
            clickedCard.style.border = '2px solid #2563eb';
            clickedCard.style.boxShadow = '0 4px 12px rgba(37, 99, 235, 0.2)';
            
            // Filter table rows
            const tableRows = document.querySelectorAll('tbody tr[data-sent-to-client]');
            tableRows.forEach(row => {
                const sentStatus = row.getAttribute('data-sent-to-client');
                
                if (filterType === 'all') {
                    row.style.display = '';
                } else if (filterType === 'sent') {
                    row.style.display = sentStatus === 'sent' ? '' : 'none';
                } else if (filterType === 'not-sent') {
                    row.style.display = sentStatus === 'not-sent' ? '' : 'none';
                }
            });
        }
    </script>
</x-app-layout>

