<?php
// Временный файл для запуска миграций на Reg.ru
// Загрузи этот файл в корень сайта (public_html), открой через браузер, затем удали!

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Миграции
    Artisan::call('migrate', ['--force' => true]);
    echo "✅ Миграции выполнены<br>";
    
    // Сидер (создание админа)
    Artisan::call('db:seed', ['--class' => 'AdminUserSeeder', '--force' => true]);
    echo "✅ Админ создан<br>";
    
    echo "<br>🎉 Готово! Теперь удали этот файл (migrate-on-server.php) через FTP!";
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage();
}
