<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'denisunderonov')</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oi&family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    @if(file_exists(public_path('build/manifest.json')))
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            $cssFile = $manifest['resources/scss/app.scss']['file'] ?? null;
            $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
            $baseUrl = config('app.env') === 'production' ? secure_asset('build/') : asset('build/');
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
<body>
    <x-header />
    
    <main class="main" id="main-content">
        <x-nav />
        <div id="blog-anchor"></div>
        <div id="projects-anchor"></div>
        <div id="content">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav__link')
            navLinks.forEach(link => {
                if (!link.hasAttribute('target')) {
                    link.addEventListener('click', function(e) {
                        // определяем якорь по ссылке
                        let anchor = null;
                        if (link.getAttribute('href') === '/blog') anchor = document.getElementById('blog-anchor');
                        if (link.getAttribute('href') === '/projects') anchor = document.getElementById('projects-anchor');
                        if (anchor) {
                            setTimeout(() => {
                                anchor.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }, 100);
                        } else {
                            setTimeout(() => {
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            }, 100);
                        }
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
