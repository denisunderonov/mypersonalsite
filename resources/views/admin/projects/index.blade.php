@extends('admin.layouts.app')

@section('title', 'Проекты')

@section('content')
<div class="admin-content">
    <div class="admin-content__header">
        <h1 class="admin-content__title">Проекты</h1>
        <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn--primary">+ Создать проект</a>
    </div>

    @if($projects->isEmpty())
        <div class="admin-empty">
            <p>Проектов пока нет</p>
        </div>
    @else
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->title }}</td>
                            <td>
                                <span class="admin-badge admin-badge--{{ $project->category }}">
                                    {{ ucfirst($project->category) }}
                                </span>
                            </td>
                            <td>
                                @if($project->published)
                                    <span class="admin-badge admin-badge--success">Опубликовано</span>
                                @else
                                    <span class="admin-badge admin-badge--draft">Черновик</span>
                                @endif
                            </td>
                            <td>{{ $project->created_at->format('d.m.Y') }}</td>
                            <td class="admin-table__actions">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--small admin-btn--edit">Редактировать</a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn admin-btn--small admin-btn--delete" onclick="return confirm('Удалить проект?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $projects->links() }}
        </div>
    @endif
</div>
@endsection
