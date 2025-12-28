@extends('admin.layouts.app')

@section('title', 'Дашборд')

@section('content')
<div class="admin-dashboard">
    <h1 class="admin-dashboard__title">Админ-панель</h1>
    
    <div class="admin-stats">
        <div class="admin-stat-card admin-stat-card--blue">
            <div class="admin-stat-card__icon">📝</div>
            <div class="admin-stat-card__content">
                <div class="admin-stat-card__number">{{ $stats['articles'] }}</div>
                <div class="admin-stat-card__label">Статей</div>
            </div>
            <a href="{{ route('admin.articles.index') }}" class="admin-stat-card__link">Управление</a>
        </div>

        <div class="admin-stat-card admin-stat-card--yellow">
            <div class="admin-stat-card__icon">🚀</div>
            <div class="admin-stat-card__content">
                <div class="admin-stat-card__number">{{ $stats['projects'] }}</div>
                <div class="admin-stat-card__label">Проектов</div>
            </div>
            <a href="{{ route('admin.projects.index') }}" class="admin-stat-card__link">Управление</a>
        </div>

        <div class="admin-stat-card admin-stat-card--cyan">
            <div class="admin-stat-card__icon">📷</div>
            <div class="admin-stat-card__content">
                <div class="admin-stat-card__number">{{ $stats['photos'] }}</div>
                <div class="admin-stat-card__label">Фотографий</div>
            </div>
            <a href="{{ route('admin.photos.index') }}" class="admin-stat-card__link">Управление</a>
        </div>

        <div class="admin-stat-card admin-stat-card--purple">
            <div class="admin-stat-card__icon">👥</div>
            <div class="admin-stat-card__content">
                <div class="admin-stat-card__number">{{ $stats['visitors'] }}</div>
                <div class="admin-stat-card__label">Уникальных посетителей</div>
                <div class="admin-stat-card__sublabel">{{ $stats['visitors_month'] }} за месяц</div>
            </div>
        </div>
    </div>

    <div class="admin-quick-links">
        <h2 class="admin-quick-links__title">Быстрые действия</h2>
        <div class="admin-quick-links__grid">
            <a href="{{ route('admin.articles.create') }}" class="admin-quick-link">+ Создать статью</a>
            <a href="{{ route('admin.projects.create') }}" class="admin-quick-link">+ Создать проект</a>
            <a href="{{ route('admin.photos.create') }}" class="admin-quick-link">+ Загрузить фото</a>
        </div>
    </div>
</div>
@endsection
