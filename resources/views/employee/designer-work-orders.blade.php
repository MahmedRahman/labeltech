<x-app-layout>
    @php
        $title = 'البروفا';
        
        // Function to convert diffForHumans to Arabic
        function arabicDiffForHumans($date) {
            if (!$date) return '-';
            
            $now = \Carbon\Carbon::now();
            $diff = $date->diffInSeconds($now);
            
            if ($diff < 60) {
                return 'منذ ' . $diff . ' ثانية';
            } elseif ($diff < 3600) {
                $minutes = floor($diff / 60);
                return 'منذ ' . $minutes . ($minutes == 1 ? ' دقيقة' : ' دقائق');
            } elseif ($diff < 86400) {
                $hours = floor($diff / 3600);
                return 'منذ ' . $hours . ($hours == 1 ? ' ساعة' : ' ساعات');
            } elseif ($diff < 604800) {
                $days = floor($diff / 86400);
                return 'منذ ' . $days . ($days == 1 ? ' يوم' : ' أيام');
            } elseif ($diff < 2592000) {
                $weeks = floor($diff / 604800);
                return 'منذ ' . $weeks . ($weeks == 1 ? ' أسبوع' : ' أسابيع');
            } elseif ($diff < 31536000) {
                $months = floor($diff / 2592000);
                return 'منذ ' . $months . ($months == 1 ? ' شهر' : ' أشهر');
            } else {
                $years = floor($diff / 31536000);
                return 'منذ ' . $years . ($years == 1 ? ' سنة' : ' سنوات');
            }
        }
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

        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-card-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            margin: 0;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .stat-card.filter-card {
            cursor: pointer;
            transition: all 0.3s;
        }

        .stat-card.filter-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .stat-card.filter-card.active {
            border: 2px solid;
            transform: translateY(-2px);
        }

        .stat-card.filter-card[data-filter="approved"].active {
            border-color: #10b981;
        }

        .stat-card.filter-card[data-filter="not-approved"].active {
            border-color: #dc2626;
        }

        .stat-card.filter-card[data-filter="all"].active {
            border-color: #2563eb;
        }

        .work-order-row {
            transition: opacity 0.3s, transform 0.3s;
        }

        .work-order-row.hidden {
            display: none;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">البروفا</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">عرض جميع البروفا المرسلة إليك للتصميم</p>
        </div>
        <a href="{{ route('employee.designer.dashboard') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة للوحة التحكم
        </a>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
        <!-- Approved Proofs Card -->
        <div class="stat-card filter-card active" data-filter="approved" onclick="filterTable('approved')">
            <div class="stat-card-header">
                <h3 class="stat-card-title">البروفا الموافق عليها</h3>
                <div class="stat-card-icon" style="background-color: #d1fae5;">
                    <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value" style="color: #10b981;">{{ $approvedCount ?? 0 }}</p>
        </div>

        <!-- Not Approved Proofs Card -->
        <div class="stat-card filter-card" data-filter="not-approved" onclick="filterTable('not-approved')">
            <div class="stat-card-header">
                <h3 class="stat-card-title">البروفا غير الموافق عليها</h3>
                <div class="stat-card-icon" style="background-color: #fee2e2;">
                    <svg style="width: 24px; height: 24px; color: #dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value" style="color: #dc2626;">{{ $notApprovedCount ?? 0 }}</p>
        </div>

        <!-- Total Proofs Card -->
        <div class="stat-card filter-card" data-filter="all" onclick="filterTable('all')">
            <div class="stat-card-header">
                <h3 class="stat-card-title">إجمالي البروفا</h3>
                <div class="stat-card-icon" style="background-color: #dbeafe;">
                    <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value" style="color: #2563eb;">{{ $workOrders->count() }}</p>
        </div>
    </div>

    @if($workOrders->count() > 0)
        <!-- Table View -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>تاريخ التحديث</th>
                        <th>رقم عرض السعر</th>
                        <th>موظف المبيعات المسؤول</th>
                        <th>الخامة</th>
                        <th>الأبعاد</th>
                        <th>عدد الألوان</th>
                        <th>موافقة العميل على التصميم</th>
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
                        <tr class="work-order-row" data-approval-status="{{ $workOrder->client_design_approval ?? 'لم يرد' }}">
                            <td>
                                @if($workOrder->updated_at)
                                    <span style="color: #6b7280; font-size: 0.875rem;">{{ arabicDiffForHumans($workOrder->updated_at) }}</span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #111827;">{{ $workOrder->order_number ?? 'بدون رقم' }}</strong>
                            </td>
                            <td>
                                @if($workOrder->created_by)
                                    <span style="color: #6366f1; font-weight: 500;">{{ $workOrder->created_by }}</span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>{{ $workOrder->material ?? '-' }}</td>
                            <td>
                                @if($workOrder->width && $workOrder->length)
                                    {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }}
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td>{{ $workOrder->number_of_colors ?? '-' }}</td>
                            <td>
                                @if($workOrder->client_design_approval)
                                    @php
                                        $designApprovalColors = [
                                            'موافق' => '#10b981',
                                            'رفض' => '#dc2626',
                                            'لم يرد' => '#6b7280'
                                        ];
                                        $approvalColor = $designApprovalColors[$workOrder->client_design_approval] ?? '#6b7280';
                                    @endphp
                                    <span class="status-badge" style="background-color: {{ $approvalColor }}20; color: {{ $approvalColor }};">
                                        @if($workOrder->client_design_approval == 'موافق')
                                            <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @elseif($workOrder->client_design_approval == 'رفض')
                                            <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                        {{ $workOrder->client_design_approval }}
                                    </span>
                                @else
                                    <span class="status-badge" style="background-color: #6b728020; color: #6b7280;">
                                        لم يرد
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('employee.designer.work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
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
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0;">لا توجد بروفا</h3>
            <p style="font-size: 1rem; color: #6b7280; margin: 0 0 1.5rem 0;">لم يتم إرسال أي بروفا إليك للتصميم بعد</p>
            <a href="{{ route('employee.designer.dashboard') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للوحة التحكم
            </a>
        </div>
    @endif

    <script>
        function filterTable(filterType) {
            // Remove active class from all cards
            document.querySelectorAll('.filter-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Add active class to clicked card
            const clickedCard = document.querySelector(`[data-filter="${filterType}"]`);
            if (clickedCard) {
                clickedCard.classList.add('active');
            }
            
            // Filter table rows
            const rows = document.querySelectorAll('.work-order-row');
            rows.forEach(row => {
                const approvalStatus = row.getAttribute('data-approval-status');
                
                if (filterType === 'all') {
                    row.classList.remove('hidden');
                } else if (filterType === 'approved') {
                    if (approvalStatus === 'موافق') {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                } else if (filterType === 'not-approved') {
                    if (approvalStatus === 'موافق') {
                        row.classList.add('hidden');
                    } else {
                        row.classList.remove('hidden');
                    }
                }
            });
        }
    </script>
</x-app-layout>

