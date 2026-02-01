# حسابات التجربة | Test Accounts

جدول بجميع بيانات حسابات التجربة (اسم، اسم المستخدم/البريد، كلمة المرور، نوع الحساب، كود الموظف).

---

## الجدول

| الاسم | اسم المستخدم (البريد) | كلمة المرور | نوع الحساب | كود الموظف |
|-------|------------------------|-------------|------------|------------|
| Admin | admin@admin.com | admin | مدير نظام | — |
| موظف المبيعات | sales@labeltech.com | password | مبيعات | LA-TEST-001 |
| موظف التصميم | designer@labeltech.com | password | تصميم | LA-TEST-002 |
| موظف التشغيل | production@labeltech.com | password | تشغيل | LA-TEST-003 |
| موظف الحسابات | accountant@labeltech.com | password | حسابات | LA-TEST-004 |

---

## للنسخ واللصق (Copy & Paste)

**Admin**
admin@admin.com
admin

**موظف المبيعات**
sales@labeltech.com
password

**موظف التصميم**
designer@labeltech.com
password

**موظف التشغيل**
production@labeltech.com
password

**موظف الحسابات**
accountant@labeltech.com
password

---

## ملاحظات

- **Admin**: تسجيل الدخول من لوحة المدير (guard: web).
- **باقي الحسابات**: موظفون — تسجيل الدخول من صفحة الموظفين (guard: employee).
- إنشاء/تحديث الحسابات: `php artisan db:seed --class=TestAccountsSeeder`
- إنشاء حساب الحسابات فقط: `php artisan db:seed --class=AccountingTestAccountSeeder`
- قسم «حسابات التجربة» يظهر في صفحة تسجيل الدخول فقط عند التشغيل **خارج** الدومين labeltech.site (مثل localhost).
