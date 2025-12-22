<?php

// Пространство имен для админских контроллеров
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article; // Модель статей блога
use Illuminate\Http\Request; // Для работы с запросами
use Illuminate\Support\Facades\Storage; // Для работы с файлами (загрузка/удаление картинок)
use Illuminate\Support\Str; // Для генерации slug из заголовка

// CRUD-контроллер для управления статьями блога
// Create (создание), Read (просмотр), Update (редактирование), Delete (удаление)
class ArticleController extends Controller
{
    // Метод для отображения списка всех статей
    // Открывается по адресу /admin/articles
    public function index()
    {
        // Получаем все статьи из базы
        // latest() - сортирует по дате создания (новые сверху)
        // paginate(20) - разбивает на страницы по 20 статей
        // Это чтобы не грузить сразу все 1000 статей если их много
        $articles = Article::latest()->paginate(20);
        
        // Возвращаем view со списком статей в виде таблицы
        return view('admin.articles.index', compact('articles'));
    }

    // Метод показывает форму создания новой статьи
    // Просто отдает пустую форму с полями
    public function create()
    {
        return view('admin.articles.create');
    }

    // Метод сохраняет новую статью в базу
    // Сюда приходит POST-запрос с формы создания
    public function store(Request $request)
    {
        // Валидируем данные формы
        // title - обязательное поле, максимум 255 символов
        // slug - опциональный, должен быть уникальным (если админ сам его указал)
        // content - обязательное поле с текстом статьи
        // category - обязательно, только одно из 4 значений (it, design, music, art)
        // image - опциональная картинка, максимум 5МБ (5120 килобайт)
        // published - галочка опубликовано/не опубликовано (булево значение)
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:articles,slug',
            'content' => 'required',
            'category' => 'required|in:it,design,music,art',
            'image' => 'nullable|image|max:5120',
            'published' => 'boolean',
        ]);

        // Если slug не указан вручную - генерируем его из заголовка
        // Например "Моя статья" превратится в "moya-statya"
        // Это нужно для красивых URL типа /blog/moya-statya
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Если админ загрузил картинку
        if ($request->hasFile('image')) {
            // Сохраняем файл в папку storage/app/public/articles
            // store() возвращает путь к файлу типа "articles/abc123.jpg"
            // Этот путь мы сохраним в базе
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        // Создаем новую запись в таблице articles
        // Laravel сам подставит validated данные в нужные колонки
        Article::create($validated);

        // Редиректим админа обратно на список статей
        // with('success', ...) - это flash-сообщение на одно показание
        // В шаблоне можно вывести зеленое уведомление "Статья создана"
        return redirect()->route('admin.articles.index')
            ->with('success', 'Статья успешно создана');
    }

    // Метод показывает форму редактирования существующей статьи
    // Laravel автоматически найдет статью по ID из URL
    // Например /admin/articles/5/edit найдет статью с id=5
    public function edit(Article $article)
    {
        // Отдаем форму редактирования с заполненными данными статьи
        return view('admin.articles.edit', compact('article'));
    }

    // Метод обновляет статью в базе
    // Сюда приходит PUT/PATCH запрос с формы редактирования
    public function update(Request $request, Article $article)
    {
        // Валидация похожа на store(), но с одним отличием:
        // В правиле unique для slug добавляем исключение для текущей статьи
        // Это позволяет оставить тот же slug при редактировании
        // Иначе бы Laravel ругался "такой slug уже есть" (хотя это наша же статья)
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:articles,slug,' . $article->id,
            'content' => 'required',
            'category' => 'required|in:it,design,music,art',
            'image' => 'nullable|image|max:5120',
            'published' => 'boolean',
        ]);

        // Если slug пустой - генерируем из заголовка
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Если загружена новая картинка
        if ($request->hasFile('image')) {
            // Сначала удаляем старую картинку если она была
            // Иначе захламим диск старыми файлами
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            
            // Сохраняем новую картинку
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        // Обновляем статью в базе
        // update() изменит только те поля, которые есть в $validated
        $article->update($validated);

        // Возвращаем на список статей с сообщением об успехе
        return redirect()->route('admin.articles.index')
            ->with('success', 'Статья успешно обновлена');
    }

    // Метод удаляет статью из базы
    // Вызывается при нажатии кнопки "Удалить" в админке
    public function destroy(Article $article)
    {
        // Если у статьи была картинка - удаляем файл с диска
        // Важно чистить файлы, иначе они останутся мусором
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        
        // Удаляем саму запись из таблицы articles
        $article->delete();

        // Редирект на список статей с сообщением
        return redirect()->route('admin.articles.index')
            ->with('success', 'Статья успешно удалена');
    }
}
