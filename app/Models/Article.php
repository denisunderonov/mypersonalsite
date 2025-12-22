<?php

namespace App\Models;

// Подключаем базовую модель Eloquent и помощник для работы со строками
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Модель для работы со статьями блога
 * Представляет запись в таблице articles
 */
class Article extends Model
{
    /**
     * Поля, которые можно массово заполнять (для защиты от mass assignment)
     * Это те поля, которые мы можем безопасно передавать через формы
     */
    protected $fillable = [
        'title',      // Заголовок статьи
        'slug',       // URL-friendly версия заголовка
        'content',    // Текст статьи
        'category',   // Категория (it, design, music, art)
        'image',      // Путь к изображению
        'published',  // Опубликована ли статья
    ];

    /**
     * Приводим типы полей к нужным форматам
     * published хранится как boolean (true/false) вместо 0/1
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * Хук жизненного цикла модели - выполняется при загрузке класса
     * Здесь настраиваем автоматическую генерацию slug
     */
    protected static function boot()
    {
        // Вызываем родительский метод (обязательно!)
        parent::boot();
        
        // Вешаем событие на создание новой статьи
        static::creating(function ($article) {
            // Если slug не указали вручную - генерируем автоматически из заголовка
            if (empty($article->slug)) {
                // Str::slug превращает "Моя статья" в "moya-statya"
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Accessor (геттер) для получения полного URL изображения
     * Обращаемся через $article->image_url
     * Возвращает полный путь типа http://site.com/storage/articles/image.jpg
     */
    public function getImageUrlAttribute()
    {
        // Если изображение есть - возвращаем полный URL, иначе null
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
