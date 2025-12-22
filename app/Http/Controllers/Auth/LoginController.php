<?php

// Объявляем пространство имен для контроллеров аутентификации
// Это помогает организовать код - все что связано с входом/выходом лежит в Auth
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Для работы с HTTP-запросами
use Illuminate\Support\Facades\Auth; // Фасад для аутентификации пользователей

// Контроллер отвечает за вход админа в систему и выход из нее
// Тут нет регистрации - админа мы создаем через сидер заранее
class LoginController extends Controller
{
    // Метод просто показывает форму входа
    // Когда админ заходит на /admin/login - он попадает сюда
    public function showLoginForm()
    {
        // Возвращаем blade-шаблон с формой (email, пароль, кнопка "Войти")
        return view('admin.auth.login');
    }

    // Основной метод логина - сюда приходит POST-запрос с формы
    // Тут проверяем правильность email/пароля и пускаем админа внутрь
    public function login(Request $request)
    {
        // Сначала валидируем данные формы
        // Email должен быть обязательным и иметь формат почты
        // Пароль тоже обязателен (без проверки длины - это уже при регистрации проверялось)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Пытаемся авторизовать пользователя
        // Auth::attempt() сравнивает пароль с хешем в базе
        // Второй параметр - это галочка "Запомнить меня" (remember me)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Если логин успешный - регенерируем ID сессии
            // Это защита от session fixation атак
            $request->session()->regenerate();
            
            // Перенаправляем на страницу, которую админ пытался открыть
            // Если он просто зашел - отправляем на дашборд
            return redirect()->intended('/admin/dashboard');
        }

        // Если логин провалился - возвращаем назад на форму
        // Добавляем ошибку под полем email
        // onlyInput('email') сохраняет введенный email, чтобы админу не вводить заново
        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
        ])->onlyInput('email');
    }

    // Метод выхода из админки
    // Тут важно правильно все почистить, чтобы админ точно вышел
    public function logout(Request $request)
    {
        // Разлогиниваем пользователя (удаляем данные об авторизации)
        Auth::logout();
        
        // Инвалидируем (уничтожаем) текущую сессию
        // Это удалит все данные сессии
        $request->session()->invalidate();
        
        // Генерируем новый CSRF-токен
        // Это защита - старый токен станет недействительным
        $request->session()->regenerateToken();
        
        // Отправляем админа обратно на страницу входа
        return redirect('/admin/login');
    }
}
