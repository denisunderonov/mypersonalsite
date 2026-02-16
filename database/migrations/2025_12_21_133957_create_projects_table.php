<?php

// Импортируем необходимые классы для миграции
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Анонимный класс миграции - современный подход Laravel
return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Применяем миграцию - создаём таблицу для хранения проектов
     */
    public function up(): void
    {
        Schema::dropIfExists('projects');
        Schema::create('projects', function (Blueprint $table) {
            // ID проекта - автоинкрементный первичный ключ
            $table->id();
            
            // Название проекта - обязательное поле
            $table->string('title');
            
            // URL-friendly версия названия - должна быть уникальной
            $table->string('slug')->unique();
            
            // Подробное описание проекта - текст без ограничений
            $table->text('description');
            
            // Категория: big (большие проекты), educational (учебные), other (прочие)
            $table->string('category');
            
            // Массив тегов в формате JSON (например: ["Laravel", "Vue.js", "Docker"])
            // Можно оставить пустым - необязательное поле
            $table->json('tags')->nullable();
            
            // Путь к картинке превью проекта - может отсутствовать
            $table->string('image')->nullable();
            
            // Ссылка на рабочий сайт проекта - опционально
            $table->string('site_url')->nullable();
            
            // Ссылка на репозиторий GitHub - опционально
            $table->string('github_url')->nullable();
            
            // Флаг публикации - по умолчанию проект опубликован
            $table->boolean('published')->default(true);
            
            // Временные метки создания и обновления записи
            $table->timestamps();
        });
    }

    /**
     * Откатываем миграцию - удаляем таблицу проектов
     */
    public function down(): void
    {
        // Удаляем таблицу если она существует
        Schema::dropIfExists('projects');
    }
};

