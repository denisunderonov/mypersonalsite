<?php

// Подключаем нужные классы для работы с миграциями
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Создаём анонимный класс миграции - так делается в Laravel 8+
return new class extends Migration
{
    /**
     * Запускаем миграцию - создаём таблицу для статей блога
     */
    public function up(): void
    {
        // Создаём новую таблицу articles в базе данных
        Schema::create('articles', function (Blueprint $table) {
            // Автоинкрементный ID - первичный ключ
            $table->id();
            
            // Заголовок статьи - обязательное поле
            $table->string('title');
            
            // Slug для URL (например: moya-pervaya-statya) - должен быть уникальным
            $table->string('slug')->unique();
            
            // Содержимое статьи - текстовое поле без ограничений по длине
            $table->text('content');
            
            // Категория статьи: it, design, music, art - для фильтрации на сайте
            $table->string('category');
            
            // Путь к изображению статьи - может быть пустым (необязательное поле)
            $table->string('image')->nullable();
            
            // Опубликована ли статья - по умолчанию true (сразу публикуем)
            $table->boolean('published')->default(true);
            
            // Автоматически создаёт поля created_at и updated_at для отслеживания времени
            $table->timestamps();
        });
    }

    /**
     * Откатываем миграцию - удаляем таблицу статей
     * Нужно на случай если что-то пойдёт не так или захотим переделать структуру
     */
    public function down(): void
    {
        // Удаляем таблицу articles если она существует
        Schema::dropIfExists('articles');
    }
};
