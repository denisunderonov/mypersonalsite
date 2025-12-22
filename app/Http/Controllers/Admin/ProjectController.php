<?php

// Пространство имен админских контроллеров
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project; // Модель проектов портфолио
use Illuminate\Http\Request; // Для обработки HTTP-запросов
use Illuminate\Support\Facades\Storage; // Для работы с файлами (картинки)
use Illuminate\Support\Str; // Для генерации slug

// CRUD-контроллер для управления проектами в портфолио
// Похож на ArticleController, но с дополнительными полями (теги, ссылки)
class ProjectController extends Controller
{
    // Метод для отображения списка всех проектов
    // Админ видит все проекты в виде таблицы
    public function index()
    {
        // Берем проекты из базы, сортируем по дате (новые сверху)
        // Делим на страницы по 20 проектов
        $projects = Project::latest()->paginate(20);
        
        // Отдаем view с таблицей проектов
        return view('admin.projects.index', compact('projects'));
    }

    // Метод показывает форму для создания нового проекта
    // Просто рендерит пустую форму со всеми полями
    public function create()
    {
        return view('admin.projects.create');
    }

    // Метод сохраняет новый проект в базу
    // Принимает POST-запрос с формы создания
    public function store(Request $request)
    {
        // Валидация данных формы
        // title - обязательное, максимум 255 символов
        // slug - опциональный, если указан - должен быть уникальным
        // description - обязательное описание проекта
        // category - одна из трех категорий (big, educational, other)
        // tags - строка с тегами через запятую (например "PHP, Laravel, API")
        // image - картинка проекта, максимум 5МБ
        // site_url - ссылка на сайт проекта (если есть), должна быть валидным URL
        // github_url - ссылка на GitHub репозиторий (если есть)
        // published - булево, опубликован ли проект
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:projects,slug',
            'description' => 'required',
            'category' => 'required|in:big,educational,other',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'site_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'published' => 'boolean',
        ]);

        // Если админ не указал slug вручную - генерируем из заголовка
        // "My Cool Project" -> "my-cool-project"
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Обработка тегов
        // Админ вводит "PHP, Laravel, API" - мы превращаем это в массив ["PHP", "Laravel", "API"]
        // explode(',', ...) разбивает строку по запятым
        // array_map('trim', ...) убирает пробелы с каждого тега
        // Массив сохранится в базе как JSON благодаря $casts в модели
        if (isset($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Если загружена картинка проекта
        if ($request->hasFile('image')) {
            // Сохраняем в папку storage/app/public/projects
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // Создаем новую запись в таблице projects
        Project::create($validated);

        // Возвращаем админа на список проектов с уведомлением об успехе
        return redirect()->route('admin.projects.index')
            ->with('success', 'Проект успешно создан');
    }

    // Метод показывает форму редактирования проекта
    // Laravel сам найдет проект по ID из URL
    public function edit(Project $project)
    {
        // Отдаем форму с заполненными данными проекта
        return view('admin.projects.edit', compact('project'));
    }

    // Метод обновляет проект в базе
    // Принимает PUT/PATCH запрос с формы редактирования
    public function update(Request $request, Project $project)
    {
        // Валидация похожа на store()
        // Отличие только в правиле unique для slug - исключаем текущий проект
        // Это позволяет оставить slug без изменений при редактировании
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:projects,slug,' . $project->id,
            'description' => 'required',
            'category' => 'required|in:big,educational,other',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'site_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'published' => 'boolean',
        ]);

        // Генерация slug из заголовка если не указан
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Парсим теги из строки в массив
        // "React, TypeScript, Vite" -> ["React", "TypeScript", "Vite"]
        if (isset($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Если загружена новая картинка
        if ($request->hasFile('image')) {
            // Удаляем старую картинку с диска (если была)
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            
            // Сохраняем новую картинку
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // Обновляем проект в базе
        $project->update($validated);

        // Редирект на список проектов с сообщением
        return redirect()->route('admin.projects.index')
            ->with('success', 'Проект успешно обновлен');
    }

    // Метод удаляет проект из базы
    // Вызывается при клике на кнопку "Удалить"
    public function destroy(Project $project)
    {
        // Если у проекта была картинка - удаляем файл
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        
        // Удаляем запись из таблицы projects
        $project->delete();

        // Возвращаем на список с уведомлением
        return redirect()->route('admin.projects.index')
            ->with('success', 'Проект успешно удален');
    }
}
