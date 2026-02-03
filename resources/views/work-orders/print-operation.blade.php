<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طباعة التشغيل - {{ $workOrder->order_number ?? 'بدون رقم' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page { size: A4; margin: 12mm; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 0; background: white; }
            .print-container { box-shadow: none; border: none; }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Cairo', 'Arial', 'Tahoma', sans-serif;
            font-size: 14px;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }
        .print-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
        }
        .op-title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #333;
        }
        .val-box {
            background: #fef9c3;
            border: 1px solid #d4b106;
            padding: 4px 10px;
            min-width: 90px;
            text-align: left;
            font-weight: 600;
        }
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #333; padding: 6px 10px; vertical-align: middle; }
        .label-cell { font-weight: 500; }
        .section-head {
            font-weight: 700;
            font-size: 15px;
            background: #f1f5f9;
        }
        .checkbox-sq {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #333;
            margin-right: 6px;
            vertical-align: middle;
        }
        .no-print {
            text-align: center;
            margin-bottom: 12px;
        }
        .no-print button {
            padding: 8px 20px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button type="button" onclick="window.print();">طباعة</button>
    </div>
    <div class="print-container">
        <h1 class="op-title">التشغيل</h1>

        {{-- الصف العلوي: الماز الطول الصال، الماز الطول + نسبه الهاليك، المتر الطولي، نسبة الهاليك، الوزن --}}
        <table style="margin-bottom: 12px;">
            <tr>
                <td class="label-cell">الماز الطول الصال</td>
                <td><span class="val-box">{{ number_format($calculations['linear_meter'] ?? 0, 3) }}</span></td>
                <td class="label-cell">الماز الطول + نسبه الهاليك</td>
                <td><span class="val-box">{{ number_format($calculations['linear_meter_with_waste'] ?? 0, 3) }}</span></td>
                <td class="label-cell">المتر الطولي الصافي</td>
                <td><span class="val-box">{{ number_format($calculations['net_linear_meter'] ?? 0, 3) }}</span></td>
                <td class="label-cell">المتر الطولي + نسبه الهاليك</td>
                <td><span class="val-box">{{ number_format($calculations['linear_meter_with_waste'] ?? 0, 2) }}</span></td>
            </tr>
            <tr>
                <td class="label-cell">نسبة الهاليك :-</td>
                <td><span class="val-box">{{ number_format($calculations['waste_percentage'] ?? 0, 1) }}</span></td>
                <td class="label-cell">الوزن :-</td>
                <td><span class="val-box">{{ number_format($calculations['weight'] ?? 0, 2) }}</span></td>
                <td colspan="4"></td>
            </tr>
        </table>

        {{-- شيت و بكر --}}
        <table>
            <tr>
                <td class="section-head" style="width: 28%;">
                    <span class="checkbox-sq"></span> شيت
                </td>
                <td class="section-head" style="width: 36%;"></td>
                <td class="section-head" style="width: 36%;">
                    <span class="checkbox-sq"></span> بكر
                </td>
            </tr>
            <tr>
                <td class="label-cell">عدد التكت في الشيت :-</td>
                <td><span class="val-box">{{ (int) ($workOrder->pieces_per_sheet ?? 0) }}</span></td>
                <td class="label-cell">عرض الورق</td>
                <td><span class="val-box">{{ number_format($calculations['paper_width'] ?? 0, 0) }}</span></td>
            </tr>
            <tr>
                <td class="label-cell">عدد الشيت في الباكو :-</td>
                <td><span class="val-box">{{ (int) ($workOrder->sheets_per_stack ?? 0) }}</span></td>
                <td class="label-cell">المتر المربع</td>
                <td><span class="val-box">{{ number_format($calculations['square_meter'] ?? 0, 2) }}</span></td>
            </tr>
            <tr>
                <td class="label-cell">عدد التكت في الباكو :-</td>
                <td><span class="val-box">{{ (int) ($workOrder->pieces_per_stack ?? 0) }}</span></td>
                <td class="label-cell">عدد البكر</td>
                <td><span class="val-box">{{ number_format($calculations['rolls_count'] ?? $workOrder->number_of_rolls ?? 0, 2) }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">عدد الاطقم :-</td>
                <td><span class="val-box">{{ (int) ($workOrder->number_of_rolls ?? 0) }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">عدد اللفات</td>
                <td><span class="val-box">{{ (int) ($calculations['number_of_turns'] ?? 1) }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">عدد الامتار للمقص 32</td>
                <td><span class="val-box">{{ (int) 0 }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">عدد العيون</td>
                <td><span class="val-box">{{ number_format($workOrder->rows_count ?? 0, 2) }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">مقاس الكور</td>
                <td><span class="val-box">{{ (int) ($workOrder->core_size ?? 0) }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">اجمالي عدد الامتار للطقم</td>
                <td><span class="val-box">{{ number_format($calculations['linear_meter_with_waste'] ?? 0, 2) }}</span></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="label-cell">عدد التكت بالبكرة</td>
                <td><span class="val-box">{{ (int) ($calculations['pieces_per_roll'] ?? 0) }}</span></td>
            </tr>
        </table>
    </div>
    <script>
        (function() {
            if (window.location.search.indexOf('print=1') !== -1) window.print();
        })();
    </script>
</body>
</html>
