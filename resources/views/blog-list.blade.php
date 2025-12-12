@extends('layouts.app')

@section('title', 'Блог - denisunderonov')

@section('content')
    <div class="blog-list">
        <h1 class="blog-list__main-title">Блог</h1>

        <nav class="blog-nav">
            <a href="#it" class="blog-nav__link {{ request()->get('category') == 'it' ? 'blog-nav__link--active' : '' }}" data-category="it">
                IT
            </a>
            <a href="#design" class="blog-nav__link {{ request()->get('category') == 'design' ? 'blog-nav__link--active' : '' }}" data-category="design">
                Дизайн
            </a>
            <a href="#music" class="blog-nav__link {{ request()->get('category') == 'music' ? 'blog-nav__link--active' : '' }}" data-category="music">
                Музыка
            </a>
            <a href="#art" class="blog-nav__link {{ request()->get('category') == 'art' ? 'blog-nav__link--active' : '' }}" data-category="art">
                Искусство
            </a>
        </nav>

        {{-- IT статьи --}}
        <div class="blog-articles" id="it" data-category="it" style="display: none;">
            <ul class="blog-articles__list">
                <li class="blog-articles__item">
                    <a href="/blog/first-post" class="blog-articles__link">Моя первая статья</a>
                </li>
                <li class="blog-articles__item">
                    <a href="/blog/laravel-tips" class="blog-articles__link">Laravel: Советы и трюки</a>
                </li>
                <li class="blog-articles__item">
                    <a href="/blog/docker-basics" class="blog-articles__link">Docker для начинающих</a>
                </li>
            </ul>
        </div>

        {{-- Дизайн статьи --}}
        <div class="blog-articles" id="design" data-category="design" style="display: none;">
            <ul class="blog-articles__list">
                <li class="blog-articles__item">
                    <a href="/blog/minimalism" class="blog-articles__link">Минимализм в веб-дизайне</a>
                </li>
                <li class="blog-articles__item">
                    <a href="/blog/color-theory" class="blog-articles__link">Теория цвета для веб-дизайнеров</a>
                </li>
            </ul>
        </div>

        {{-- Музыка статьи --}}
        <div class="blog-articles" id="music" data-category="music" style="display: none;">
            <ul class="blog-articles__list">
                <li class="blog-articles__item">
                    <a href="/blog/music-inspiration" class="blog-articles__link">Музыка как источник вдохновения</a>
                </li>
                <li class="blog-articles__item">
                    <a href="/blog/playlist-coding" class="blog-articles__link">Идеальный плейлист для кодинга</a>
                </li>
            </ul>
        </div>

        {{-- Искусство статьи --}}
        <div class="blog-articles" id="art" data-category="art" style="display: none;">
            <ul class="blog-articles__list">
                <li class="blog-articles__item">
                    <a href="/blog/digital-art" class="blog-articles__link">Цифровое искусство и технологии</a>
                </li>
                <li class="blog-articles__item">
                    <a href="/blog/art-inspiration" class="blog-articles__link">Где искать вдохновение художнику</a>
                </li>
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.blog-nav__link');
            const articleSections = document.querySelectorAll('.blog-articles');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const category = this.getAttribute('data-category');
                    
                    // Убрать активный класс со всех ссылок
                    navLinks.forEach(l => l.classList.remove('blog-nav__link--active'));
                    
                    // Скрыть все секции
                    articleSections.forEach(section => {
                        section.style.display = 'none';
                    });
                    
                    // Показать выбранную секцию
                    const targetSection = document.getElementById(category);
                    if (targetSection) {
                        if (this.classList.contains('blog-nav__link--active')) {
                            // Если уже активна - скрываем
                            this.classList.remove('blog-nav__link--active');
                            targetSection.style.display = 'none';
                        } else {
                            // Активируем
                            this.classList.add('blog-nav__link--active');
                            targetSection.style.display = 'block';
                        }
                    }
                });
            });
        });
    </script>
@endsection
