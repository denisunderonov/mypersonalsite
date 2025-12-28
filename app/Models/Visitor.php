<?php

// Пространство имен для моделей
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Модель для работы с таблицей visitors
// Используется для отслеживания уникальных посетителей сайта
class Visitor extends Model
{
    // Имя таблицы в базе данных
    // По умолчанию Laravel ищет таблицу 'visitors' (множественное число от Visitor)
    protected $table = 'visitors';
    
    // Поля которые можно массово заполнять через create() или fill()
    // Это безопасный список полей для работы с формами
    protected $fillable = [
        'ip_address',   // IP-адрес посетителя
        'user_agent',   // Информация о браузере
        'last_visit',   // Дата последнего визита
    ];
    
    // Приведение типов для полей
    // last_visit будет автоматически конвертироваться в объект Carbon (для работы с датами)
    protected $casts = [
        'last_visit' => 'datetime',
    ];
    
    /**
     * Записывает визит посетителя или обновляет время последнего визита
     * 
     * Если посетитель с таким IP и User Agent уже есть - обновляем last_visit
     * Если новый - создаем новую запись
     * 
     * @param string $ip IP-адрес посетителя
     * @param string $userAgent User Agent браузера
     * @return void
     */
    public static function recordVisit(string $ip, string $userAgent): void
    {
        // updateOrCreate() - умный метод Laravel
        // Первый параметр - условие поиска (по каким полям ищем существующую запись)
        // Второй параметр - данные для обновления/создания
        static::updateOrCreate(
            [
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ],
            [
                'last_visit' => now(), // now() возвращает текущую дату/время
            ]
        );
    }
    
    /**
     * Возвращает количество уникальных посетителей
     * 
     * @return int Количество уникальных IP + User Agent комбинаций
     */
    public static function uniqueCount(): int
    {
        // Просто считаем все записи в таблице
        // Так как у нас unique constraint на ip_address + user_agent
        // То каждая запись = уникальный посетитель
        return static::count();
    }
    
    /**
     * Возвращает количество посетителей за последние N дней
     * 
     * @param int $days Количество дней (по умолчанию 30)
     * @return int Количество уникальных посетителей за период
     */
    public static function countRecentVisitors(int $days = 30): int
    {
        // Считаем только тех посетителей, которые заходили за последние $days дней
        // where('last_visit', '>=', now()->subDays($days)) фильтрует по дате
        return static::where('last_visit', '>=', now()->subDays($days))->count();
    }
}
