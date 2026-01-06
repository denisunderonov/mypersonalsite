<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * Отображение галереи фотографий
     */
    public function index()
    {
        // Получаем только опубликованные фотографии
        $photos = Photo::where('published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('photos', compact('photos'));
    }
}
