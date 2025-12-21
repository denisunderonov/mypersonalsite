<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::where('published', true)
            ->latest()
            ->get()
            ->groupBy('category');

        return view('projects', compact('projects'));
    }
}
