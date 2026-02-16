<?php

// Подключаем классы для работы с миграциями базы данных
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Создаём миграцию как анонимный класс
return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Запускаем миграцию - создаём таблицу для фотогалереи
     */
    public function up(): void
    {
        Schema::dropIfExists('photos');
        Schema::create('photos', function (Blueprint $table) {
            // Уникальный идентификатор фотографии
            $table->id();
            
            // Название фотографии - может быть пустым (необязательное)
            $table->string('title')->nullable();
            
            // Путь к файлу изображения в хранилище - обязательное поле
            $table->string('image');
            
            // Описание фотографии - опциональное текстовое поле
            $table->text('description')->nullable();
            
            // Опубликована ли фотография - по умолчанию да
            $table->boolean('published')->default(true);
            
            // Даты создания и обновления записи
            $table->timestamps();
        });
    }

    /**
     * Откатываем миграцию - удаляем таблицу фотографий
     */
    public function down(): void
    {
        // Удаляем таблицу photos
        Schema::dropIfExists('photos');
    }
};

