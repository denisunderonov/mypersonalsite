@extends('layouts.app')

@section('title', 'Блог - denisunderonov')

@section('content')
    <div id="blog-anchor"></div>
    <div class="blog-list">
        <h1 class="blog-list__main-title">Блог</h1>

        <nav class="blog-nav">
            <button type="button" class="blog-nav__link" data-category="it">IT</button>
            <button type="button" class="blog-nav__link" data-category="design">Дизайн</button>
            <button type="button" class="blog-nav__link" data-category="music">Музыка</button>
            <button type="button" class="blog-nav__link" data-category="art">Искусство</button>
            <button type="button" class="blog-nav__link" data-category="photo">Фотографии</button>
        </nav>
        {{-- Фотографии статьи --}}
        <div class="blog-articles" id="photo" data-category="photo" style="display: none;"></div>

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
        // Collapsible category lists — preserves existing styles
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.blog-nav__link');
            const sections = document.querySelectorAll('.blog-articles');

            function hideAll() {
                sections.forEach(s => s.style.display = 'none');
                buttons.forEach(b => b.classList.remove('blog-nav__link--active'));
            }

            // start collapsed
            hideAll();

            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const cat = this.dataset.category;
                    const target = document.querySelector('.blog-articles[data-category="' + cat + '"]');
                    if (!target) return;

                    const visible = target.style.display !== 'none' && target.style.display !== '';

                    hideAll();

                    if (!visible) {
                        target.style.display = 'block';
                        this.classList.add('blog-nav__link--active');
                        // ensure focus stays visible
                        this.focus();
                    }
                });
            });
        });
    </script>

@endsection
