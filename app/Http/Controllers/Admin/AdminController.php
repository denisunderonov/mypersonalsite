<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Project;
use App\Models\Photo;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'articles' => Article::count(),
            'projects' => Project::count(),
            'photos' => Photo::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
