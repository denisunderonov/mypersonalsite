@extends('layouts.app')

@section('title', 'Блог - denisunderonov')

@section('content')
    <div class="blog">
        <article class="blog__article">
            <header class="blog__header">
                <h1 class="blog__title">Моя первая статья</h1>
                <div class="blog__meta">
                    <time class="blog__date" datetime="2025-12-12">12 декабря 2025</time>
                    <span class="blog__reading-time">5 мин чтения</span>
                </div>
            </header>

            <div class="blog__content">
                <p>Это тестовая статья для моего блога. Здесь я буду делиться своими мыслями, проектами и идеями.</p>
                
                <h2>Заголовок второго уровня</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                
                <h3>Заголовок третьего уровня</h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                
                <blockquote class="blog__quote">
                    "Это цитата для примера. Она выглядит особенным образом и привлекает внимание читателя."
                </blockquote>
                
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                
                <h2>Список</h2>
                <ul class="blog__list">
                    <li>Первый пункт списка</li>
                    <li>Второй пункт списка</li>
                    <li>Третий пункт списка</li>
                </ul>
                
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
            </div>

            <footer class="blog__footer">
                <div class="blog__tags">
                    <span class="blog__tag">веб-разработка</span>
                    <span class="blog__tag">laravel</span>
                    <span class="blog__tag">дизайн</span>
                </div>
            </footer>
        </article>
    </div>
@endsection
