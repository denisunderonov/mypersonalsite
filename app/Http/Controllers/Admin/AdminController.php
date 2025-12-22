<?php

// Пространство имен для всех админских контроллеров
// Все что в папке Admin - это защищенная часть сайта
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article; // Модель статей блога
use App\Models\Project; // Модель проектов портфолио
use App\Models\Photo; // Модель фотографий из галереи

// Главный контроллер админ-панели
// Тут только дашборд - главная страница админки со статистикой
class AdminController extends Controller
{
    // Метод главной страницы админки
    // Показывает админу сколько у него статей, проектов и фоток
    public function dashboard()
    {
        // Собираем статистику - считаем количество записей в каждой таблице
        // Article::count() - это быстрый запрос SELECT COUNT(*) FROM articles
        // Не загружает сами записи, только считает их количество
        $stats = [
            'articles' => Article::count(), // Сколько всего статей в блоге
            'projects' => Project::count(), // Сколько проектов в портфолио
            'photos' => Photo::count(), // Сколько фотографий в галерее
        ];
        
        // Возвращаем вид дашборда и передаем туда массив статистики
        // compact('stats') - это короткая запись для ['stats' => $stats]
        // В шаблоне будет доступна переменная $stats
        return view('admin.dashboard', compact('stats'));
    }
}
