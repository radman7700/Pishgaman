# مدیریت محتوی پیشگامان

پروژه ContentX یک سیستم مدیریت محتوا (Content Management System - CMS) است که به شما امکان مدیریت و مدیریت محتوای سایت خود را می‌دهد. با استفاده از این CMS، شما می‌توانید به راحتی صفحات وب سایت خود را ایجاد، ویرایش و حذف کنید، مطالب را به دسته‌بندی‌ها تقسیم کنید و به صورت دلخواه به صفحات نمایش دهید.

## ویژگی‌ها

ایجاد و ویرایش مطالب بدون نیاز به دانش فنی عمیق
دسته‌بندی کردن محتوا بر اساس موضوعات و دسته‌های مختلف
امکان افزودن تصاویر و رسانه‌ها به محتوا
برخورداری از امنیت بالا برای حفاظت از داده‌ها
پشتیبانی از ویرایش تاریخ‌های انتشار مطالب
قابلیت انتشار و نمایش محتوا به صورت عمومی یا خصوصی

## نیازمندی‌ها

PHP >= 8.0
MySQL
Composer

## نصب و راه‌اندازی

### قالب‌های پیش فرض

use Pishgaman\Pishgaman\Database\Seeders\TemplateSeeder;

$this->call([
    TemplateSeeder::class,
]);

###Provider
Pishgaman\Pishgaman\pishgamanServiceProvider::class,
Pishgaman\Pishgaman\Providers\TemplateServiceProvider::class,
