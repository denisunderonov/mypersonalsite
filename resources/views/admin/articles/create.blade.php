@extends('admin.layouts.app')

@section('title', 'Создать статью')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Создать статью</h1>
        <a href="{{ route('admin.articles.index') }}" class="admin-btn admin-btn--secondary">← Назад</a>
    </div>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf

        <div class="admin-form__group">
            <label for="title" class="admin-form__label">Заголовок *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="admin-form__input @error('title') admin-form__input--error @enderror" 
                value="{{ old('title') }}" 
                required
            >
            @error('title')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="slug" class="admin-form__label">Slug (оставьте пустым для автогенерации)</label>
            <input 
                type="text" 
                id="slug" 
                name="slug" 
                class="admin-form__input @error('slug') admin-form__input--error @enderror" 
                value="{{ old('slug') }}"
            >
            @error('slug')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="category" class="admin-form__label">Категория *</label>
            <select 
                id="category" 
                name="category" 
                class="admin-form__select @error('category') admin-form__input--error @enderror" 
                required
            >
                <option value="">Выберите категорию</option>
                <option value="it" {{ old('category') == 'it' ? 'selected' : '' }}>IT</option>
                <option value="design" {{ old('category') == 'design' ? 'selected' : '' }}>Дизайн</option>
                <option value="music" {{ old('category') == 'music' ? 'selected' : '' }}>Музыка</option>
                <option value="art" {{ old('category') == 'art' ? 'selected' : '' }}>Искусство</option>
            </select>
            @error('category')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="content" class="admin-form__label">Содержание *</label>
            <textarea 
                id="content" 
                name="content" 
                class="admin-form__textarea @error('content') admin-form__input--error @enderror" 
                rows="15" 
                required
            >{{ old('content') }}</textarea>
            @error('content')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="image" class="admin-form__label">Изображение</label>
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
            <button type="submit" class="admin-btn admin-btn--primary">Создать статью</button>
            <a href="{{ route('admin.articles.index') }}" class="admin-btn admin-btn--secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection
