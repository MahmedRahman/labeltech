# Docker Setup for LabelTech

## المتطلبات
- Docker
- Docker Compose

## الإعداد الأولي

### 1. إنشاء ملف .env
```bash
cp .env.example .env
```

### 2. تحديث إعدادات قاعدة البيانات في .env
```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=labeltech
DB_USERNAME=labeltech
DB_PASSWORD=root
```

### 3. بناء وتشغيل الحاويات
```bash
docker-compose up -d --build
```

### 4. تثبيت التبعيات
```bash
docker-compose exec app composer install
```

### 5. إنشاء مفتاح التطبيق
```bash
docker-compose exec app php artisan key:generate
```

### 6. تشغيل Migrations
```bash
docker-compose exec app php artisan migrate
```

### 7. تثبيت npm packages (اختياري)
```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

## الأوامر المفيدة

### تشغيل الحاويات
```bash
docker-compose up -d
```

### إيقاف الحاويات
```bash
docker-compose down
```

### عرض السجلات
```bash
docker-compose logs -f
```

### تنفيذ أوامر Artisan
```bash
docker-compose exec app php artisan [command]
```

### تنفيذ أوامر Composer
```bash
docker-compose exec app composer [command]
```

### الوصول إلى قاعدة البيانات
```bash
docker-compose exec db mysql -u labeltech -proot labeltech
```

### إعادة بناء الحاويات
```bash
docker-compose up -d --build
```

## الوصول للتطبيق
- التطبيق: http://localhost:8000
- قاعدة البيانات: localhost:3306

## ملاحظات
- جميع الملفات محفوظة في volumes، لذا لن تفقد البيانات عند إعادة تشغيل الحاويات
- قاعدة البيانات محفوظة في volume منفصل (dbdata)

