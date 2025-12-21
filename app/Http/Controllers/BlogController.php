<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Photo;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::where('published', true)
            ->latest()
            ->get()
            ->groupBy('category');
        
        $photos = Photo::where('published', true)
            ->latest()
            ->get();

        return view('blog-list', compact('articles', 'photos'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return view('blog', compact('article'));
    }
}
