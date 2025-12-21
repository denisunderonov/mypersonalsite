@extends('admin.layouts.app')

@section('title', 'Создать проект')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Создать проект</h1>
        <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--secondary">← Назад</a>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
        @csrf

        <div class="admin-form__group">
            <label for="title" class="admin-form__label">Название *</label>
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
                <option value="big" {{ old('category') == 'big' ? 'selected' : '' }}>Большой проект</option>
                <option value="educational" {{ old('category') == 'educational' ? 'selected' : '' }}>Учебный</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Другое</option>
            </select>
            @error('category')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="description" class="admin-form__label">Описание *</label>
            <textarea 
                id="description" 
                name="description" 
                class="admin-form__textarea @error('description') admin-form__input--error @enderror" 
                rows="8" 
                required
            >{{ old('description') }}</textarea>
            @error('description')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="tags" class="admin-form__label">Теги (через запятую)</label>
            <input 
                type="text" 
                id="tags" 
                name="tags" 
                class="admin-form__input @error('tags') admin-form__input--error @enderror" 
                value="{{ old('tags') }}"
                placeholder="Laravel, Vue.js, Docker"
            >
            @error('tags')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="site_url" class="admin-form__label">Ссылка на сайт</label>
            <input 
                type="url" 
                id="site_url" 
                name="site_url" 
                class="admin-form__input @error('site_url') admin-form__input--error @enderror" 
                value="{{ old('site_url') }}"
                placeholder="https://example.com"
            >
            @error('site_url')
                <span class="admin-form__error">{{ $message }}</span>
            @enderror
        </div>

        <div class="admin-form__group">
            <label for="github_url" class="admin-form__label">Ссылка на GitHub</label>
            <input 
                type="url" 
                id="github_url" 
                name="github_url" 
                class="admin-form__input @error('github_url') admin-form__input--error @enderror" 
                value="{{ old('github_url') }}"
                placeholder="https://github.com/username/repo"
            >
            @error('github_url')
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
            <button type="submit" class="admin-btn admin-btn--primary">Создать проект</button>
            <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection
