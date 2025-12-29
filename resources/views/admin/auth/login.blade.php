<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель - denisunderonov</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oi&family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    @if(file_exists(public_path('build/manifest.json')))
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            $cssFile = $manifest['resources/scss/app.scss']['file'] ?? null;
            $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
        @endphp
        @if($cssFile)
            <link rel="stylesheet" href="{{ secure_asset('build/' . $cssFile) }}">
        @endif
        @if($jsFile)
            <script type="module" src="{{ secure_asset('build/' . $jsFile) }}"></script>
        @endif
    @else
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-box">
            <h1 class="login-box__title">Вход в админ-панель</h1>
            
            @if($errors->any())
                <div class="login-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="login-form">
                @csrf
                
                <div class="login-form__group">
                    <label for="email" class="login-form__label">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="login-form__input" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        placeholder="denisunderonov@admin.com"
                    >
                </div>

                <div class="login-form__group">
                    <label for="password" class="login-form__label">Пароль</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="login-form__input" 
                        required
                        placeholder="••••••••••••"
                    >
                </div>

                <div class="login-form__group login-form__group--checkbox">
                    <label class="login-form__checkbox-label">
                        <input type="checkbox" name="remember" value="1" class="login-form__checkbox">
                        <span>Запомнить меня</span>
                    </label>
                </div>

                <button type="submit" class="login-form__submit">Войти</button>
            </form>
        </div>
    </div>
</body>
</html>
