@extends('layouts.app')

@section('title', $article->title . ' - denisunderonov')

@section('content')
    <div class="blog">
        <article class="blog__article">
            <header class="blog__header">
                <h1 class="blog__title">{{ $article->title }}</h1>
                <div class="blog__meta">
                    <time class="blog__date" datetime="{{ $article->created_at->format('Y-m-d') }}">
                        {{ $article->created_at->format('d F Y') }}
                    </time>
                    <span class="blog__category">{{ ucfirst($article->category) }}</span>
                </div>
            </header>

            @if($article->image)
                <div class="blog__image">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                </div>
            @endif

            <div class="blog__content">
                {!! nl2br(e($article->content)) !!}
            </div>

            <footer class="blog__footer">
                <a href="/blog" class="blog__back-link">← Вернуться к блогу</a>
            </footer>
        </article>
    </div>
@endsection

