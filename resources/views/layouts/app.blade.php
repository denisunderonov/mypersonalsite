<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'denisunderonov')</title>
    <link rel="icon" type="image/png" href="data:image/png;base64,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">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oi&family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
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
            const navLinks = document.querySelectorAll('.nav__link');
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
