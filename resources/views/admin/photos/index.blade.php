@extends('admin.layouts.app')

@section('title', 'Фотографии')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Фотографии</h1>
        <a href="{{ route('admin.photos.create') }}" class="admin-btn admin-btn--primary">+ Загрузить фото</a>
    </div>

    @if($photos->isEmpty())
        <div class="admin-empty">
            <p>Фотографий пока нет</p>
        </div>
    @else
        <div class="admin-photo-grid">
            @foreach($photos as $photo)
                <div class="admin-photo-card">
                    <div class="admin-photo-card__image">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                    </div>
                    <div class="admin-photo-card__content">
                        <h3 class="admin-photo-card__title">{{ $photo->title ?: 'Без названия' }}</h3>
                        @if($photo->description)
                            <p class="admin-photo-card__description">{{ Str::limit($photo->description, 80) }}</p>
                        @endif
                        <div class="admin-photo-card__meta">
                            @if($photo->published)
                                <span class="admin-badge admin-badge--success">Опубликовано</span>
                            @else
                                <span class="admin-badge admin-badge--draft">Скрыто</span>
                            @endif
                            <span class="admin-photo-card__date">{{ $photo->created_at->format('d.m.Y') }}</span>
                        </div>
                        <div class="admin-photo-card__actions">
                            <a href="{{ route('admin.photos.edit', $photo) }}" class="admin-btn admin-btn--small admin-btn--edit">Редактировать</a>
                            <form action="{{ route('admin.photos.destroy', $photo) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn--small admin-btn--delete" onclick="return confirm('Удалить фото?')">Удалить</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="admin-pagination">
            {{ $photos->links() }}
        </div>
    @endif
</div>
@endsection
