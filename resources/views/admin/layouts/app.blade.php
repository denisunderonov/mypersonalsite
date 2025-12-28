<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Админ-панель') - denisunderonov</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oi&family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <header class="admin-header">
        <div class="admin-header__container">
            <a href="/admin/dashboard" class="admin-header__logo">denisunderonov</a>
            <nav class="admin-header__nav">
                <a href="/admin/dashboard" class="admin-header__link">Дашборд</a>
                <a href="{{ route('admin.articles.index') }}" class="admin-header__link">Статьи</a>
                <a href="{{ route('admin.projects.index') }}" class="admin-header__link">Проекты</a>
                <a href="{{ route('admin.photos.index') }}" class="admin-header__link">Фото</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="admin-header__link admin-header__link--logout">Выход</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="admin-main">
        @if(session('success'))
            <div class="admin-alert admin-alert--success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="admin-alert admin-alert--error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
