<?php

// Пространство имен для сидеров (классов заполнения базы тестовыми данными)
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; // Базовый класс для всех сидеров

// Сидер для создания пользователя-администратора
// Запускается командой: php artisan db:seed --class=AdminUserSeeder
// Или через php artisan migrate:fresh --seed если добавлен в DatabaseSeeder
class AdminUserSeeder extends Seeder
{
    /**
     * Запускает заполнение базы данных
     * 
     * Этот метод создает одного админа с заранее заданными данными
     * Используется для первоначальной настройки системы
     */
    public function run(): void
    {
        // Создаем запись в таблице users
        // \App\Models\User - полный путь к модели (с обратным слешем)
        // create() - создает новую запись и сразу сохраняет в базу
        \App\Models\User::create([
            'name' => 'Denis Underonov', // Имя администратора
            'email' => 'denisunderonov2@gmail.com', // Email для входа в админку
            // bcrypt() хеширует пароль перед сохранением
            // Никогда не храним пароли в открытом виде!
            // При входе Laravel сравнит введенный пароль с этим хешем
            'password' => bcrypt('Denimz13141314..'), // Захешированный пароль
        ]);
        
        // После запуска этого сидера админ сможет войти в /admin/login
        // используя email: denisunderonov2@gmail.com
        // и пароль: Denimz13141314..
    }
}
