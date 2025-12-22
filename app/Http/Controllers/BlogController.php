<?php

// Обычное пространство имен контроллеров (не Admin)
// Это публичная часть сайта - то что видят обычные посетители
namespace App\Http\Controllers;

use App\Models\Article; // Модель статей блога
use App\Models\Photo; // Модель фотографий

// Контроллер для публичной части блога
// Тут два метода - список статей и просмотр одной статьи
class BlogController extends Controller
{
    // Метод показывает главную страницу блога
    // Тут список статей по категориям + фотогалерея
    public function index()
    {
        // Берем только опубликованные статьи
        // where('published', true) фильтрует черновики
        // latest() сортирует по дате создания (новые сверху)
        // get() получает все записи из базы
        // groupBy('category') группирует статьи по категориям (it, design, music, art)
        // В результате получаем массив вида: ['it' => [статьи], 'design' => [статьи], ...]
        $articles = Article::where('published', true)
            ->latest()
            ->get()
            ->groupBy('category');
        
        // Берем опубликованные фотографии для галереи
        // Тут просто список всех фото без группировки
        $photos = Photo::where('published', true)
            ->latest()
            ->get();

        // Возвращаем view blog-list.blade.php с данными
        // В шаблоне будут доступны $articles (сгруппированные) и $photos
        return view('blog-list', compact('articles', 'photos'));
    }

    // Метод показывает одну статью по её slug
    // Например URL /blog/moya-pervaya-statya вызовет этот метод с $slug = 'moya-pervaya-statya'
    public function show($slug)
    {
        // Ищем статью по slug
        // where('published', true) - показываем только опубликованные
        // firstOrFail() - либо находит запись, либо выдает 404 ошибку
        // Если статья не найдена или не опубликована - посетитель увидит страницу 404
        $article = Article::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        // Возвращаем view blog.blade.php с данными одной статьи
        // В шаблоне будет доступна переменная $article
        return view('blog', compact('article'));
    }
}
