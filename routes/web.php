<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProjectsController;

Route::get('/', function () {
    return view('home');
});

Route::get('/creative', function () {
    return view('creative');
});

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/{slug}', [BlogController::class, 'show']);

Route::get('/projects', [ProjectsController::class, 'index']);

// Admin Authentication Routes
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Admin Panel Routes (Protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Articles CRUD
    Route::resource('articles', ArticleController::class)->except(['show']);
    
    // Projects CRUD
    Route::resource('projects', ProjectController::class)->except(['show']);
    
    // Photos CRUD
    Route::resource('photos', PhotoController::class)->except(['show']);
});
