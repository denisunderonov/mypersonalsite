<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/creative', function () {
    return view('creative');
});

Route::get('/blog', function () {
    return view('blog-list');
});

Route::get('/blog/{slug}', function () {
    return view('blog');
});

Route::get('/projects', function () {
    return view('projects');
});
