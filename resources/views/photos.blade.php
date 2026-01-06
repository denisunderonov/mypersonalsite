@extends('layouts.app')

@section('title', 'Фотографии - denisunderonov')

@section('content')
    <div class="photos">
        <h1 class="photos__title">Фотографии</h1>

        @if($photos->isEmpty())
            <div class="photos__empty">
                <p>Фотографий пока нет</p>
            </div>
        @else
            <div class="photos__grid">
                @foreach($photos as $photo)
                    <div class="photo-item" data-photo-id="{{ $photo->id }}">
                        <img 
                            src="{{ asset('storage/' . $photo->image) }}" 
                            alt="{{ $photo->title ?? 'Фото' }}"
                            class="photo-item__image"
                            loading="lazy"
                        >
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Модальное окно --}}
    <div class="photo-modal" id="photoModal">
        <div class="photo-modal__overlay"></div>
        <div class="photo-modal__content">
            <button class="photo-modal__close" aria-label="Закрыть">&times;</button>
            <img src="" alt="" class="photo-modal__image">
            <div class="photo-modal__caption"></div>
        </div>
    </div>

    {{-- JSON данные для JavaScript --}}
    <script id="photos-data" type="application/json">
        {!! json_encode($photos->map(function($photo) {
            return [
                'id' => $photo->id,
                'image' => asset('storage/' . $photo->image),
                'title' => $photo->title,
                'description' => $photo->description,
            ];
        })->values()) !!}
    </script>
@endsection
