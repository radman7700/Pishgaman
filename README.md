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

###Publish
php artisan vendor:publish --tag=public

{
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "watch": "vite build --watch"
    },
    "devDependencies": {
        "axios": "^1.1.2",
        "laravel-vite-plugin": "^0.8.0",
        "vite": "^4.0.0"
    },
    "dependencies": {
        "@blackywkl/vuewordcloud": "^1.1.4",
        "@vitejs/plugin-vue": "^4.4.0",
        "@vue/server-renderer": "^3.3.7",
        "chart.js": "^4.4.0",
        "jalali-moment": "^3.3.11",
        "sweetalert2": "^11.6.13",
        "vue": "^3.3.7",
        "vue-chartjs": "^5.2.0",
        "vue-loader": "^17.2.2",
        "vue-router": "^4.2.5"
    }
}

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'packages/pishgaman/CyberspaceMonitoring/src/resources/vue/MonitoringApp.js',
                'packages/pishgaman/pishgaman/src/resources/vue/Auth/app.js',
                'packages/pishgaman/pishgaman/src/resources/vue/test/app.js',
                'packages/pishgaman/pishgaman/src/resources/vue/AccessLevel/app.js',
                'packages/pishgaman/pishgaman/src/resources/vue/Users/app.js',
                'packages/pishgaman/pishgaman/src/resources/vue/History/app.js',
                'packages/pishgaman/GymManagement/src/resources/vue/ClubManagement/superadmin/superAdmin.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});


{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.1",
        "guzzlehttp/guzzle": "^7.2",
        "laravel/framework": "^10.10",
        "laravel/sanctum": "^3.2",
        "laravel/tinker": "^2.8",
        "lithiumdev/laravel-tagcloud": "^1.1",
        "spatie/laravel-tags": "4.5"
    },
    "require-dev": {
        "fakerphp/faker": "^1.9.1",
        "laravel/pint": "^1.0",
        "laravel/sail": "^1.18",
        "mockery/mockery": "^1.4.4",
        "nunomaduro/collision": "^7.0",
        "phpunit/phpunit": "^10.1",
        "spatie/laravel-ignition": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "Pishgaman\\GymManagement\\": "Packages/Pishgaman/GymManagement/src",
            "Pishgaman\\CyberspaceMonitoring\\": "Packages/Pishgaman/CyberspaceMonitoring/src",
            "Pishgaman\\Pishgaman\\": "Packages/Pishgaman/Pishgaman/src",
            "Pishgaman\\Pishgaman\\Database\\Seeders\\": "Packages/Pishgaman/Pishgaman/src/Database/Seeders/" 
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}


        Pishgaman\Pishgaman\pishgamanServiceProvider::class,
        Pishgaman\Pishgaman\Providers\TemplateServiceProvider::class,
        // Pishgaman\GymManagement\GymManagementServiceProvider::class,
        Pishgaman\GymManagement\GymManagementServiceProvider::class,
        Pishgaman\CyberspaceMonitoring\CyberspaceMonitoringServiceProvider::class,
        Pishgaman\CyberspaceMonitoring\Providers\StatisticsProvider::class,
        LithiumDev\TagCloud\ServiceProvider::class,

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:VAql3TgZIlodwq/bY7XPHmTsXq8GKkLEVp3vx0WsVcI=
APP_DEBUG=true
APP_URL=http://localhost/example-app/public/

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=cookie
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
