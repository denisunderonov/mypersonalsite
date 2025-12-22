<?php

namespace App\Models;

// Импортируем нужные классы
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Модель для работы с проектами портфолио
 * Связана с таблицей projects в базе данных
 */
class Project extends Model
{
    /**
     * Массово заполняемые поля - можем безопасно передавать через форму
     * Защита от случайного изменения системных полей
     */
    protected $fillable = [
        'title',        // Название проекта
        'slug',         // URL-slug для адреса страницы
        'description',  // Подробное описание проекта
        'category',     // Категория: big, educational, other
        'tags',         // Массив технологий (Laravel, Vue и т.д.)
        'image',        // Путь к превью-изображению
        'site_url',     // Ссылка на живой сайт проекта
        'github_url',   // Ссылка на репозиторий
        'published',    // Показывать ли проект на сайте
    ];

    /**
     * Автоматическое преобразование типов полей при чтении/записи
     */
    protected $casts = [
        'tags' => 'array',        // JSON в базе → массив в PHP (и обратно)
        'published' => 'boolean',  // 0/1 в базе → true/false в PHP
    ];

    /**
     * Настраиваем поведение модели при создании записи
     */
    protected static function boot()
    {
        // Обязательно вызываем метод родителя
        parent::boot();
        
        // Слушаем событие создания нового проекта
        static::creating(function ($project) {
            // Если slug не задан - делаем из названия
            // "Мой проект" → "moy-proekt"
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Accessor для получения полного URL картинки
     * Можно обращаться как $project->image_url
     */
    public function getImageUrlAttribute()
    {
        // Если картинка есть - возвращаем полный путь, если нет - null
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
