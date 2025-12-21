@extends('admin.layouts.app')

@section('title', 'Редактировать фотографию')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Редактировать фотографию</h1>
        <a href="{{ route('admin.photos.index') }}" class="admin-btn admin-btn--secondary">← Назад</a>
    </div>

    <form action="{{ route('admin.photos.update', $photo) }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf
        @method('PUT')

        @if($photo->image)
            <div class="admin-form__group">
                <label class="admin-form__label">Текущее изображение</label>
                <div class="admin-image-preview admin-image-preview--large">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}">
                </div>
            </div>
        @endif

        <div class="admin-form__group">
            <label for="image" class="admin-form__label">Заменить изображение</label>
            <input 
                type="file" 
                id="image" 
                name="image" 
                class="admin-form__file @error('image') admin-form__input--error @enderror" 
                accept="image/*"
            >
            @error('image')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
            <p class="admin-form__hint">Максимальный размер: 10 МБ</p>
        </div>

        <div class="admin-form__group">
            <label for="title" class="admin-form__label">Название</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="admin-form__input @error('title') admin-form__input--error @enderror" 
                value="{{ old('title', $photo->title) }}"
            >
            @error('title')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="description" class="admin-form__label">Описание</label>
            <textarea 
                id="description" 
                name="description" 
                class="admin-form__textarea @error('description') admin-form__input--error @enderror" 
                rows="4"
            >{{ old('description', $photo->description) }}</textarea>
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
                    {{ old('published', $photo->published) ? 'checked' : '' }}
                >
                <span>Опубликовать</span>
            </label>
        </div>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--primary">Сохранить изменения</button>
            <a href="{{ route('admin.photos.index') }}" class="admin-btn admin-btn--secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection
