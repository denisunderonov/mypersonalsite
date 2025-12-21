@extends('admin.layouts.app')

@section('title', 'Загрузить фотографию')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Загрузить фотографию</h1>
        <a href="{{ route('admin.photos.index') }}" class="admin-btn admin-btn--secondary">← Назад</a>
    </div>

    <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf

        <div class="admin-form__group">
            <label for="image" class="admin-form__label">Изображение *</label>
            <input 
                type="file" 
                id="image" 
                name="image" 
                class="admin-form__file @error('image') admin-form__input--error @enderror" 
                accept="image/*"
                required
            >
            @error('image')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
            <p class="admin-form__hint">Максимальный размер: 10 МБ</p>
        </div>

        <div class="admin-form__group">
            <label for="title" class="admin-form__label">Название (необязательно)</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="admin-form__input @error('title') admin-form__input--error @enderror" 
                value="{{ old('title') }}"
            >
            @error('title')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="description" class="admin-form__label">Описание (необязательно)</label>
            <textarea 
                id="description" 
                name="description" 
                class="admin-form__textarea @error('description') admin-form__input--error @enderror" 
                rows="4"
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group admin-form__group--checkbox">
            <label class="admin-form__checkbox-label">
                <input 
                    type="checkbox" 
                    name="published" 
                    value="1" 
                    class="admin-form__checkbox" 
                    {{ old('published', true) ? 'checked' : '' }}
                >
                <span>Опубликовать</span>
            </label>
        </div>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary">Загрузить фото</button>
            <a href="{{ route('admin.photos.index') }}" class="admin-btn admin-btn--secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection
