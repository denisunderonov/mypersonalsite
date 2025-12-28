<?php

// Пространство имен для middleware (промежуточного ПО)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

// Middleware для отслеживания посетителей сайта
// Запускается при каждом HTTP-запросе и записывает информацию о посетителе
class TrackVisitor
{
    /**
     * Обрабатывает входящий запрос
     * 
     * Этот метод вызывается для каждого HTTP-запроса к сайту
     * Мы записываем IP и User Agent посетителя для статистики
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем что это не запрос от бота/краулера
        // Также исключаем запросы к админке (чтобы не считать самого себя)
        // И пропускаем запросы к API и ajax
        if (
            !$request->is('admin/*') && // Не админка
            !$request->is('api/*') &&   // Не API
            !$request->ajax() &&        // Не AJAX-запрос
            $request->method() === 'GET' // Только GET-запросы (не POST/PUT/DELETE)
        ) {
            // Получаем IP-адрес посетителя
            // ip() возвращает реальный IP даже если запрос идет через прокси
            $ip = $request->ip();
            
            // Получаем User Agent (информация о браузере и ОС)
            // Например: "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36..."
            $userAgent = $request->userAgent() ?? 'Unknown';
            
            // Записываем визит в базу
            // Если посетитель уже был - обновится last_visit
            // Если новый - создастся новая запись
            Visitor::recordVisit($ip, $userAgent);
        }
        
        // Продолжаем обработку запроса
        // $next($request) передает запрос дальше по цепочке middleware
        return $next($request);
    }
}
