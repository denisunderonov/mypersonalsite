<?php

namespace App\Models;

// Подключаем базовую модель Eloquent
use Illuminate\Database\Eloquent\Model;

/**
 * Модель для работы с фотогалереей
 * Работает с таблицей photos
 */
class Photo extends Model
{
    /**
     * Поля, которые можно заполнять массово через формы
     * Остальные поля будут защищены от случайного изменения
     */
    protected $fillable = [
        'title',        // Название фотографии (необязательно)
        'image',        // Путь к файлу изображения (обязательно)
        'description',  // Описание к фото (необязательно)
        'published',    // Показывать ли фото в галерее
    ];

    /**
     * Преобразование типов данных
     * published автоматически будет boolean вместо 0/1
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * Accessor - генерирует полный URL для изображения
     * Обращаемся через $photo->image_url
     * Возвращает что-то вроде: http://site.com/storage/photos/image.jpg
     */
    public function getImageUrlAttribute()
    {
        // Если изображение задано - делаем полный путь, иначе null
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
