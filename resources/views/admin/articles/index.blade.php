@extends('admin.layouts.app')

@section('title', 'Статьи')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Статьи</h1>
        <a href="{{ route('admin.articles.create') }}" class="admin-btn admin-btn--primary">+ Создать статью</a>
    </div>

    @if($articles->isEmpty())
        <div class="admin-empty">
            <p>Статей пока нет</p>
        </div>
    @else
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Категория</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>
                                <span class="admin-badge admin-badge--{{ $article->category }}">
                                    {{ ucfirst($article->category) }}
                                </span>
                            </td>
                            <td>
                                @if($article->published)
                                    <span class="admin-badge admin-badge--success">Опубликовано</span>
                                @else
                                    <span class="admin-badge admin-badge--draft">Черновик</span>
                                @endif
                            </td>
                            <td>{{ $article->created_at->format('d.m.Y') }}</td>
                            <td class="admin-table__actions">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="admin-btn admin-btn--small admin-btn--edit">Редактировать</a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--small admin-btn--delete" onclick="return confirm('Удалить статью?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
