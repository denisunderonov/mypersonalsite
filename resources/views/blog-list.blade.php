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

        {{-- Фотографии --}}
        <div class="blog-articles" id="photo" data-category="photo" style="display: none;">
            @if($photos->isEmpty())
                <p style="color: #aaa; text-align: center; padding: 2rem;">Фотографий пока нет</p>
            @else
                <div class="photo-gallery">
                    @foreach($photos as $photo)
                        <div class="photo-item">
                            <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                            @if($photo->title)
                                <p class="photo-title">{{ $photo->title }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- IT статьи --}}
        <div class="blog-articles" id="it" data-category="it" style="display: none;">
            @if(isset($articles['it']) && $articles['it']->isNotEmpty())
                <ul class="blog-articles__list">
                    @foreach($articles['it'] as $article)
                        <li class="blog-articles__item">
                            <a href="/blog/{{ $article->slug }}" class="blog-articles__link">{{ $article->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: #aaa; text-align: center; padding: 2rem;">Статей пока нет</p>
            @endif
        </div>

        {{-- Дизайн статьи --}}
        <div class="blog-articles" id="design" data-category="design" style="display: none;">
            @if(isset($articles['design']) && $articles['design']->isNotEmpty())
                <ul class="blog-articles__list">
                    @foreach($articles['design'] as $article)
                        <li class="blog-articles__item">
                            <a href="/blog/{{ $article->slug }}" class="blog-articles__link">{{ $article->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: #aaa; text-align: center; padding: 2rem;">Статей пока нет</p>
            @endif
        </div>

        {{-- Музыка статьи --}}
        <div class="blog-articles" id="music" data-category="music" style="display: none;">
            @if(isset($articles['music']) && $articles['music']->isNotEmpty())
                <ul class="blog-articles__list">
                    @foreach($articles['music'] as $article)
                        <li class="blog-articles__item">
                            <a href="/blog/{{ $article->slug }}" class="blog-articles__link">{{ $article->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: #aaa; text-align: center; padding: 2rem;">Статей пока нет</p>
            @endif
        </div>

        {{-- Искусство статьи --}}
        <div class="blog-articles" id="art" data-category="art" style="display: none;">
            @if(isset($articles['art']) && $articles['art']->isNotEmpty())
                <ul class="blog-articles__list">
                    @foreach($articles['art'] as $article)
                        <li class="blog-articles__item">
                            <a href="/blog/{{ $article->slug }}" class="blog-articles__link">{{ $article->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="color: #aaa; text-align: center; padding: 2rem;">Статей пока нет</p>
            @endif
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
                        
                        // Плавная прокрутка к статьям
                        setTimeout(() => {
                            target.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'start' 
                            });
                        }, 50);
                    }
                });
            });
        });
    </script>

@endsection
