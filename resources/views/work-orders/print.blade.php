<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة أمر الشغل - {{ $workOrder->order_number ?? 'بدون رقم' }}</title>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .print-container {
                border: none;
                padding: 10mm;
            }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Tahoma', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #000;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .print-container {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 15mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #000;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
            border: 2px solid #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
            color: #2563eb;
            background: white;
            position: relative;
        }
        
        .logo::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid #dc2626;
            border-radius: 50%;
            top: -2px;
            left: -2px;
        }
        
        .header-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        
        .header-info-row {
            display: flex;
            gap: 20px;
        }
        
        .header-info-item {
            display: flex;
            gap: 5px;
        }
        
        .header-label {
            font-weight: bold;
            min-width: 90px;
        }
        
        .section {
            margin-bottom: 15px;
            border: 1px solid #ccc;
            padding: 8px;
        }
        
        .section-title {
            font-size: 13px;
            font-weight: bold;
            background: #e5e7eb;
            padding: 5px 8px;
            margin: -8px -8px 8px -8px;
            border-bottom: 1px solid #000;
        }
        
        .section-content {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
        
        .section-row {
            display: flex;
            gap: 8px;
        }
        
        .section-label {
            font-weight: bold;
            min-width: 130px;
        }
        
        .section-value {
            flex: 1;
        }
        
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 8px;
        }
        
        .checkbox {
            width: 12px;
            height: 12px;
            border: 1.5px solid #000;
            display: inline-block;
        }
        
        .three-columns {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .signature-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px solid #000;
        }
        
        .signature-box {
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 50px;
        }
        
        .print-actions {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 5px;
        }
        
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-print {
            background: #2563eb;
            color: white;
        }
        
        .btn-back {
            background: #6b7280;
            color: white;
        }
        
        .highlight {
            background-color: #fef3c7;
        }
    </style>
</head>
<body>
    <div class="print-actions no-print">
        <button onclick="window.print()" class="btn btn-print">طباعة</button>
        <a href="{{ route('work-orders.show', $workOrder) }}" class="btn btn-back">العودة</a>
    </div>

    <div class="print-container">
        <!-- Header -->
        <div class="print-header">
            <div class="logo-section">
                <div class="logo">LT</div>
                <div class="header-info">
                    <div class="header-info-row">
                        <div class="header-info-item">
                            <span class="header-label">أمر الشغل:</span>
                            <span>{{ $workOrder->order_number ?? 'بدون رقم' }}</span>
                        </div>
                        <div class="header-info-item">
                            <span class="header-label">اسم العميل:</span>
                            <span>{{ $workOrder->client->name }}</span>
                        </div>
                    </div>
                    <div class="header-info-row">
                        <div class="header-info-item">
                            <span class="header-label">اتجاه الجر:</span>
                            <span>{{ $workOrder->winding_direction == 'yes' ? 'نعم' : ($workOrder->winding_direction == 'no' ? 'لا' : 'لا يوجد') }}</span>
                        </div>
                        <div class="header-info-item">
                            <span class="header-label">الإضافات:</span>
                            <span>{{ $workOrder->additions ?? '-' }}</span>
                        </div>
                        <div class="header-info-item">
                            <span class="header-label">عدد الألوان:</span>
                            <span>{{ $workOrder->number_of_colors }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- المبيعات -->
        <div class="section">
            <div class="section-title">المبيعات</div>
            <div class="section-content">
                <!-- First Row: Order Number, Client Name, Pull Direction, Additions, Number of Colors -->
                <div class="section-row">
                    <span class="section-label">أمر الشغل:</span>
                    <span class="section-value">{{ $workOrder->order_number ?? 'بدون رقم' }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">أسم العميل:</span>
                    <span class="section-value">{{ $workOrder->client->name }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">أتجاه الجر:</span>
                    <span class="section-value">{{ $workOrder->winding_direction == 'yes' ? 'نعم' : ($workOrder->winding_direction == 'no' ? 'لا' : 'لا يوجد') }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">الاضافات:</span>
                    <span class="section-value">{{ $workOrder->additions ?? 'لا يوجد' }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">عدد الألوان:</span>
                    <span class="section-value">{{ $workOrder->number_of_colors ?? '-' }}</span>
                </div>
                <!-- Second Row: Job Name, Date, Width, Material Type, Quantity, Winding Direction -->
                <div class="section-row">
                    <span class="section-label">اسم الشغلانة:</span>
                    <span class="section-value">{{ $workOrder->job_name ?? ($workOrder->order_number ?? 'بدون رقم') }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">التاريخ:</span>
                    <span class="section-value">{{ $workOrder->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">العرض:</span>
                    <span class="section-value">{{ $workOrder->width ? number_format($workOrder->width, 1) : '-' }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">نوع الخامة:</span>
                    <span class="section-value">{{ $workOrder->material }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">الكمية:</span>
                    <span class="section-value">{{ number_format($workOrder->quantity) }}</span>
                </div>
                <div class="section-row">
                    <span class="section-label">اتجاه اللف:</span>
                    <span class="section-value">{{ $workOrder->winding_direction == 'yes' ? 'نعم' : ($workOrder->winding_direction == 'no' ? 'لا' : 'لا يوجد') }}</span>
                </div>
            </div>
            
            <!-- شكل المنتج النهائي وبيانات طريقة التشغيل -->
            <div class="two-columns" style="margin-top: 12px;">
                <div>
                    <div class="checkbox-group">
                        <span class="checkbox" style="{{ $workOrder->final_product_shape == 'شيت' ? 'background: #000;' : '' }}"></span>
                        <strong>شيت</strong>
                    </div>
                    <div class="section-row">
                        <span class="section-label">عدد التكت في الشيت:</span>
                        <span class="section-value">{{ $workOrder->pieces_per_sheet ?? 0 }}</span>
                    </div>
                    <div class="section-row">
                        <span class="section-label">عدد الشيت في الباكو:</span>
                        <span class="section-value">{{ $workOrder->sheets_per_stack ?? 0 }}</span>
                    </div>
                </div>
                <div>
                    <div class="checkbox-group">
                        <span class="checkbox" style="{{ $workOrder->final_product_shape == 'بكر' ? 'background: #000;' : '' }}"></span>
                        <strong>بكر</strong>
                    </div>
                    <div class="section-row">
                        <span class="section-label">عدد التكت بالبكرة:</span>
                        <span class="section-value">{{ $calculations['pieces_per_roll'] ?? ($workOrder->number_of_rolls ? number_format($workOrder->quantity / $workOrder->number_of_rolls, 0) : '-') }}</span>
                    </div>
                    <div class="section-row">
                        <span class="section-label">نوع الكور:</span>
                        <span class="section-value">{{ $workOrder->core_size ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- التصميم -->
        @if($workOrder->has_design ?? false)
        <div class="section">
            <div class="section-title">التصميم</div>
            <div class="two-columns">
                <!-- Left Column -->
                <div>
                    @if($workOrder->designKnife)
                    <div class="section-row">
                        <span class="section-label">سكاكين:</span>
                        <span class="section-value">{{ $workOrder->designKnife->knife_code ?? '-' }}</span>
                    </div>
                    @endif
                    @if($workOrder->design_breaking_gear)
                    <div class="section-row">
                        <span class="section-label">ترس التكسير:</span>
                        <span class="section-value">{{ $workOrder->design_breaking_gear }}</span>
                    </div>
                    @endif
                    @if($workOrder->design_rows_count)
                    <div class="section-row">
                        <span class="section-label">عدد الصفوف:</span>
                        <span class="section-value">{{ $workOrder->design_rows_count }}</span>
                    </div>
                    @endif
                </div>
                <!-- Right Column -->
                <div>
                    @if($workOrder->design_shape)
                    <div class="section-row">
                        <span class="section-label">الشكل:</span>
                        <span class="section-value">{{ $workOrder->design_shape }}</span>
                    </div>
                    @endif
                    @if($workOrder->design_films)
                    <div class="section-row">
                        <span class="section-label">افلام:</span>
                        <span class="section-value">{{ $workOrder->design_films }}</span>
                    </div>
                    @else
                    <div class="section-row">
                        <span class="section-label">افلام:</span>
                        <span class="section-value">جديده</span>
                    </div>
                    @endif
                    @if($workOrder->design_drills)
                    <div class="section-row">
                        <span class="section-label">الدرافيل:</span>
                        <span class="section-value">{{ $workOrder->design_drills }}</span>
                    </div>
                    @endif
                    @if($workOrder->design_gab)
                    <div class="section-row highlight">
                        <span class="section-label">الجاب:</span>
                        <span class="section-value">{{ $workOrder->design_gab }}</span>
                    </div>
                    @endif
                    @if($workOrder->design_cliches)
                    <div class="section-row">
                        <span class="section-label">الاكلاشيهات المعادة:</span>
                        <span class="section-value">{{ $workOrder->design_cliches }}</span>
                    </div>
                    @else
                    <div class="section-row">
                        <span class="section-label">الاكلاشيهات المعادة:</span>
                        <span class="section-value">0</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- التشغيل -->
        <div class="section">
            <div class="section-title">التشغيل</div>
            <div class="three-columns">
                <!-- Left Column: Calculated Lengths -->
                <div>
                    <div class="section-row highlight">
                        <span class="section-label">المتر الطولي الصافي:</span>
                        <span class="section-value">{{ number_format($calculations['net_linear_meter'] ?? 0, 3) }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">المتر الطولي + نسبه الهاليك:</span>
                        <span class="section-value">{{ number_format($calculations['linear_meter_with_waste'] ?? 0, 3) }}</span>
                    </div>
                </div>
                <!-- Middle Column: Waste & Weight -->
                <div>
                    <div class="section-row highlight">
                        <span class="section-label">نسبة الهاليك:</span>
                        <span class="section-value">{{ $workOrder->waste_percentage ? number_format($workOrder->waste_percentage, 1) : '-' }}%</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">الوزن:</span>
                        <span class="section-value">{{ $calculations['weight'] ? number_format($calculations['weight'], 2) : ($workOrder->paper_weight ? number_format($workOrder->paper_weight, 2) : '-') }}</span>
                    </div>
                </div>
                <!-- Right Column: Paper/Square Meter -->
                <div>
                    <div class="section-row highlight">
                        <span class="section-label">عرض الورق:</span>
                        <span class="section-value">{{ $workOrder->paper_width ? number_format($workOrder->paper_width, 3) : '-' }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">المتر المربع:</span>
                        <span class="section-value">{{ number_format($calculations['square_meter'] ?? 0, 3) }}</span>
                    </div>
                </div>
            </div>
            
            <!-- شيت / بكر في التشغيل -->
            <div class="two-columns" style="margin-top: 12px;">
                <div>
                    <div class="checkbox-group">
                        <span class="checkbox" style="{{ $workOrder->final_product_shape == 'شيت' ? 'background: #000;' : '' }}"></span>
                        <strong>شيت</strong>
                    </div>
                    <div class="section-row">
                        <span class="section-label">عدد التكت في الشيت:</span>
                        <span class="section-value">{{ $workOrder->pieces_per_sheet ?? 0 }}</span>
                    </div>
                    <div class="section-row">
                        <span class="section-label">عدد الشيت في الباكو:</span>
                        <span class="section-value">{{ $workOrder->sheets_per_stack ?? 0 }}</span>
                    </div>
                    <div class="section-row">
                        <span class="section-label">عدد التكت في الباكو:</span>
                        <span class="section-value">{{ $workOrder->pieces_per_stack ?? 0 }}</span>
                    </div>
                </div>
                <div>
                    <div class="checkbox-group">
                        <span class="checkbox" style="{{ $workOrder->final_product_shape == 'بكر' ? 'background: #000;' : '' }}"></span>
                        <strong>بكر</strong>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">عدد البكر:</span>
                        <span class="section-value">{{ $workOrder->number_of_rolls ?? '-' }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">عدد اللفات:</span>
                        <span class="section-value">{{ $calculations['number_of_turns'] ?? '-' }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">عدد الامتار للمقص 32:</span>
                        <span class="section-value">-</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">عدد العيون:</span>
                        <span class="section-value">{{ $workOrder->designKnife->eyes_count ?? '-' }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">مقاس الكور:</span>
                        <span class="section-value">{{ $workOrder->core_size ?? '-' }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">إجمالي عدد الامتار للطقم:</span>
                        <span class="section-value">0.00</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">عدد التكت بالبكرة:</span>
                        <span class="section-value">{{ $calculations['pieces_per_roll'] ? number_format($calculations['pieces_per_roll']) : '-' }}</span>
                    </div>
                    <div class="section-row highlight">
                        <span class="section-label">عدد الاطقم:</span>
                        <span class="section-value">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- المنتج النهائي -->
        <div class="section">
            <div class="section-title">المنتج النهائي</div>
            <div class="section-content">
                <div class="section-row">
                    <span class="section-label">الكمية:</span>
                    <span class="section-value">{{ number_format($workOrder->quantity) }}</span>
                </div>
                @if($workOrder->final_product_shape == 'بكر')
                <div class="section-row">
                    <span class="section-label">عدد البكر:</span>
                    <span class="section-value">{{ $workOrder->number_of_rolls ?? '-' }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- التوقيعات -->
        <div class="signature-section">
            <div class="signature-box">
                <strong>توقيع التصميم</strong>
            </div>
            <div class="signature-box">
                <strong>توقيع التشغيل</strong>
            </div>
            <div class="signature-box">
                <strong>توقيع التسليم</strong>
            </div>
        </div>
    </div>
</body>
</html>
