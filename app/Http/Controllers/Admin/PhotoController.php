<?php

// Пространство имен для админских контроллеров
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo; // Модель фотографий для галереи
use Illuminate\Http\Request; // Для работы с запросами
use Illuminate\Support\Facades\Storage; // Для загрузки и удаления файлов

// CRUD-контроллер для управления фотогалереей
// Самый простой из всех - тут только загрузка картинок с опциональным названием
class PhotoController extends Controller
{
    // Метод показывает список всех фотографий в админке
    // Фотки отображаются в виде сетки (grid)
    public function index()
    {
        // Получаем фотографии из базы, новые сверху
        // Пагинация по 20 фоток на страницу
        $photos = Photo::latest()->paginate(20);
        
        // Отдаем view с grid-сеткой фотографий
        return view('admin.photos.index', compact('photos'));
    }

    // Метод показывает форму загрузки новой фотографии
    // Форма простая - только файл, название и описание (опционально)
    public function create()
    {
        return view('admin.photos.create');
    }

    // Метод сохраняет новую фотографию в базу
    // Принимает POST-запрос с формы загрузки
    public function store(Request $request)
    {
        // Валидация данных
        // title - опциональное название фотографии, максимум 255 символов
        // description - опциональное описание фотографии (может быть длинным)
        // image - ОБЯЗАТЕЛЬНАЯ картинка, максимум 10МБ (для фото разрешаем больше чем для статей)
        // published - булево, опубликована ли фотография (показывать на сайте или нет)
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'required|image|max:10240',
            'published' => 'boolean',
        ]);

        // Проверяем что файл действительно загружен
        // Сохраняем картинку в папку storage/app/public/photos
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('photos', 'public');
        }

        // Создаем новую запись в таблице photos
        Photo::create($validated);

        // Возвращаем админа обратно к списку фотографий
        // Flash-сообщение показывает что загрузка прошла успешно
        return redirect()->route('admin.photos.index')
            ->with('success', 'Фотография успешно загружена');
    }

    // Метод показывает форму редактирования фотографии
    // Можно поменять название, описание или саму картинку
    public function edit(Photo $photo)
    {
        // Отдаем форму с текущими данными фотографии
        return view('admin.photos.edit', compact('photo'));
    }

    // Метод обновляет фотографию в базе
    // Принимает PUT/PATCH запрос с формы редактирования
    public function update(Request $request, Photo $photo)
    {
        // Валидация похожа на store()
        // Отличие - image теперь nullable (можно не загружать новую картинку)
        // Если новая картинка не загружена - старая остается
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|max:10240',
            'published' => 'boolean',
        ]);

        // Если загружена новая картинка
        if ($request->hasFile('image')) {
            // Удаляем старую картинку с диска
            // Важно не захламлять storage старыми файлами
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
            
            // Сохраняем новую картинку
            $validated['image'] = $request->file('image')->store('photos', 'public');
        }

        // Обновляем запись в базе
        $photo->update($validated);

        // Редирект на список фотографий с уведомлением
        return redirect()->route('admin.photos.index')
            ->with('success', 'Фотография успешно обновлена');
    }

    // Метод удаляет фотографию
    // Удаляет и файл с диска, и запись из базы
    public function destroy(Photo $photo)
    {
        // Удаляем файл картинки с диска
        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }
        
        // Удаляем запись из таблицы photos
        $photo->delete();

        // Возвращаем на список с сообщением об успехе
        return redirect()->route('admin.photos.index')
            ->with('success', 'Фотография успешно удалена');
    }
}
