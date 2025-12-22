# نظام Typography للوحة التحكم - LabelTech

نظام Typography متكامل مع دعم RTL وأحجام خطوط قابلة للتعديل لسهولة القراءة للمستخدمين ذوي ضعف البصر.

## المميزات

- ✅ خط IBM Plex Sans Arabic كخط أساسي
- ✅ أحجام خطوط كبيرة (20px افتراضي)
- ✅ نظام toggle لحجم الخط (3 أحجام)
- ✅ دعم RTL كامل
- ✅ CSS Variables للتوسع السهل
- ✅ حفظ التفضيلات في localStorage

## الملفات

1. **`css/typography-system.css`** - ملف CSS الرئيسي للنظام
2. **`js/font-size-toggle.js`** - JavaScript للتحكم في حجم الخط
3. **`demo/typography-demo.html`** - صفحة تجريبية لعرض النظام

## الاستخدام

### 1. إضافة الملفات إلى Layout

تم إضافة الملفات تلقائياً في `resources/views/layouts/app.blade.php`:

```html
<!-- Typography System CSS -->
<link rel="stylesheet" href="{{ asset('css/typography-system.css') }}">

<!-- Font Size Toggle Script -->
<script src="{{ asset('js/font-size-toggle.js') }}" defer></script>
```

### 2. أحجام الخطوط

النظام يوفر 3 أحجام:

- **عادي (fs-normal)**: 18px
- **كبير (fs-large)**: 20px (افتراضي)
- **كبير جداً (fs-xlarge)**: 22px

### 3. استخدام CSS Variables

يمكنك استخدام المتغيرات في CSS الخاص بك:

```css
.my-element {
    font-size: var(--fs-base);
    font-family: var(--font-primary);
    color: var(--color-text);
    line-height: var(--lh-base);
}
```

### 4. Toggle Button

يتم إنشاء أزرار التحكم تلقائياً في أسفل يسار الصفحة. يمكن للمستخدمين:
- تغيير حجم الخط بسهولة
- حفظ التفضيلات تلقائياً
- استعادة التفضيلات عند إعادة تحميل الصفحة

## المتغيرات المتاحة

### Font Sizes
- `--fs-base`: حجم الخط الأساسي
- `--fs-h1`, `--fs-h2`, `--fs-h3`, `--fs-h4`: أحجام العناوين
- `--fs-sidebar`: حجم خط القائمة الجانبية
- `--fs-button`: حجم خط الأزرار
- `--fs-label`: حجم خط التسميات
- `--fs-input`: حجم خط الحقول
- `--fs-table-header`: حجم خط رأس الجدول
- `--fs-table-row`: حجم خط صفوف الجدول

### Colors
- `--color-text`: لون النص الأساسي (#222)
- `--color-text-light`: لون النص الفاتح (#555)
- `--color-bg`: لون الخلفية (#FFFFFF)
- `--color-bg-alt`: لون خلفية بديل (#F7F7F7)

### Line Heights
- `--lh-base`: ارتفاع السطر الأساسي (1.7)
- `--lh-heading`: ارتفاع سطر العناوين (1.4)
- `--lh-table`: ارتفاع سطر الجداول (1.7)

## الصفحة التجريبية

يمكنك عرض الصفحة التجريبية من:
```
http://your-domain.com/demo/typography-demo.html
```

## التوافق

- ✅ جميع المتصفحات الحديثة
- ✅ دعم RTL كامل
- ✅ Responsive Design
- ✅ Accessibility (WCAG 2.1 AA)

## التخصيص

يمكنك تخصيص النظام عن طريق تعديل المتغيرات في `typography-system.css`:

```css
:root {
    --fs-base: 20px; /* تغيير الحجم الافتراضي */
    --color-text: #222222; /* تغيير لون النص */
    /* ... */
}
```

## الدعم

للمساعدة أو الاستفسارات، يرجى التواصل مع فريق التطوير.

