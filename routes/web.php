<?php

// Подключаем фасад Route для определения маршрутов
use Illuminate\Support\Facades\Route;

// Импортируем все контроллеры которые используем в роутах
use App\Http\Controllers\Auth\LoginController; // Контроллер авторизации админа
use App\Http\Controllers\Admin\AdminController; // Главный контроллер админки (дашборд)
use App\Http\Controllers\Admin\ArticleController; // CRUD статей
use App\Http\Controllers\Admin\ProjectController; // CRUD проектов
use App\Http\Controllers\Admin\PhotoController; // CRUD фотографий
use App\Http\Controllers\BlogController; // Публичный контроллер блога
use App\Http\Controllers\ProjectsController; // Публичный контроллер проектов

// ПУБЛИЧНЫЕ МАРШРУТЫ (доступны всем посетителям сайта)

// Главная страница сайта - показывает home.blade.php
// Тут просто статичная страница без данных из базы
Route::get('/', function () {
    return view('home');
});

// Страница "Creative" - тоже статичная страница
// Показывает creative.blade.php
Route::get('/creative', function () {
    return view('creative');
});

// Страница списка статей блога с категориями и фотогалереей
// Вызывает метод index() в BlogController
Route::get('/blog', [BlogController::class, 'index']);

// Страница отдельной статьи блога
// {slug} - это параметр URL, например /blog/moya-statya
// Вызывает метод show() в BlogController с параметром $slug
Route::get('/blog/{slug}', [BlogController::class, 'show']);

// Страница портфолио со всеми проектами
// Вызывает метод index() в ProjectsController
Route::get('/projects', [ProjectsController::class, 'index']);

// Страница фотографий
Route::get('/photos', [App\Http\Controllers\PhotosController::class, 'index']);

// МАРШРУТЫ АУТЕНТИФИКАЦИИ АДМИНА
// Эти роуты НЕ защищены middleware - иначе админ не сможет войти

// Показывает форму входа (GET запрос)
// name('admin.login') позволяет обращаться к этому маршруту по имени
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');

// Временный роут для создания админа (удалить после первого использования!)
Route::get('/admin/setup-user', function() {
    $user = \App\Models\User::where('email', 'denisunderonov2@gmail.com')->first();
    
    if ($user) {
        return 'Пользователь уже существует: ' . $user->email . ' (ID: ' . $user->id . ')';
    }
    
    $newUser = \App\Models\User::create([
        'name' => 'Denis Underonov',
        'email' => 'denisunderonov2@gmail.com',
        'password' => bcrypt('Denimz13141314..'),
    ]);
    
    return 'Админ создан! Email: ' . $newUser->email . ', Пароль: Denimz13141314..';
});

// Обрабатывает форму входа (POST запрос с email и паролем)
Route::post('/admin/login', [LoginController::class, 'login']);

// Выход из админки (POST запрос)
// name('admin.logout') используется в ссылке "Выйти" в админке
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// ЗАЩИЩЕННЫЕ МАРШРУТЫ АДМИН-ПАНЕЛИ
// middleware('auth') - проверяет авторизацию, если не залогинен - редирект на /admin/login
// prefix('admin') - все роуты внутри будут начинаться с /admin/...
// name('admin.') - все имена роутов внутри будут начинаться с admin....
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Главная страница админки (дашборд со статистикой)
    // URL: /admin/dashboard
    // Имя маршрута: admin.dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD маршруты для статей
    // resource() автоматически создает все REST-маршруты:
    // GET    /admin/articles          -> index()   (список статей)
    // GET    /admin/articles/create   -> create()  (форма создания)
    // POST   /admin/articles          -> store()   (сохранение новой статьи)
    // GET    /admin/articles/{id}/edit -> edit()   (форма редактирования)
    // PUT    /admin/articles/{id}     -> update()  (обновление статьи)
    // DELETE /admin/articles/{id}     -> destroy() (удаление статьи)
    // except(['show']) - исключаем маршрут просмотра (он нам не нужен в админке)
    Route::resource('articles', ArticleController::class)->except(['show']);
    
    // CRUD маршруты для проектов
    // Аналогично статьям - все стандартные REST-маршруты
    // URL начинаются с /admin/projects
    Route::resource('projects', ProjectController::class)->except(['show']);
    
    // CRUD маршруты для фотографий
    // URL начинаются с /admin/photos
    Route::resource('photos', PhotoController::class)->except(['show']);
});
