<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->paginate(20);
        return view('admin.photos.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.photos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'required|image|max:10240',
            'published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('photos', 'public');
        }

        Photo::create($validated);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Фотография успешно загружена');
    }

    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|max:10240',
            'published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
            $validated['image'] = $request->file('image')->store('photos', 'public');
        }

        $photo->update($validated);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Фотография успешно обновлена');
    }

    public function destroy(Photo $photo)
    {
        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }
        
        $photo->delete();

        return redirect()->route('admin.photos.index')
            ->with('success', 'Фотография успешно удалена');
    }
}
