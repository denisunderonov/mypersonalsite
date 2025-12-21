@extends('layouts.app')

@section('title', 'Проекты - denisunderonov')

@section('content')
    <div id="projects-anchor"></div>
    <div class="projects">
        <h1 class="projects__main-title">Мои Проекты</h1>

        {{-- Большие проекты --}}
        @if(isset($projects['big']) && $projects['big']->isNotEmpty())
            <section class="projects__section">
                <h2 class="projects__section-title">Большие проекты</h2>
                
                <div class="projects__grid">
                    @foreach($projects['big'] as $project)
                        <article class="project-card">
                            <h3 class="project-card__title">{{ $project->title }}</h3>
                            
                            <p class="project-card__description">
                                {{ $project->description }}
                            </p>
                            
                            @if($project->tags && count($project->tags) > 0)
                                <div class="project-card__tags">
                                    @foreach($project->tags as $tag)
                                        <span class="project-card__tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="project-card__links">
                                @if($project->site_url)
                                    <a href="{{ $project->site_url }}" target="_blank" class="project-card__link">
                                        Посмотреть сайт
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="project-card__link">
                                        GitHub
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Учебные проекты --}}
        @if(isset($projects['educational']) && $projects['educational']->isNotEmpty())
            <section class="projects__section">
                <h2 class="projects__section-title">Учебные проекты</h2>
                
                <div class="projects__grid">
                    @foreach($projects['educational'] as $project)
                        <article class="project-card project-card--small">
                            <h3 class="project-card__title">{{ $project->title }}</h3>
                            
                            <p class="project-card__description">
                                {{ $project->description }}
                            </p>
                            
                            @if($project->tags && count($project->tags) > 0)
                                <div class="project-card__tags">
                                    @foreach($project->tags as $tag)
                                        <span class="project-card__tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="project-card__links">
                                @if($project->site_url)
                                    <a href="{{ $project->site_url }}" target="_blank" class="project-card__link">
                                        Демо
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="project-card__link">
                                        GitHub
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Другие проекты --}}
        @if(isset($projects['other']) && $projects['other']->isNotEmpty())
            <section class="projects__section">
                <h2 class="projects__section-title">Другие проекты</h2>
                
                <div class="projects__grid">
                    @foreach($projects['other'] as $project)
                        <article class="project-card project-card--small">
                            <h3 class="project-card__title">{{ $project->title }}</h3>
                            
                            <p class="project-card__description">
                                {{ $project->description }}
                            </p>
                            
                            @if($project->tags && count($project->tags) > 0)
                                <div class="project-card__tags">
                                    @foreach($project->tags as $tag)
                                        <span class="project-card__tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="project-card__links">
                                @if($project->site_url)
                                    <a href="{{ $project->site_url }}" target="_blank" class="project-card__link">
                                        Посмотреть
                                    </a>
                                @endif
                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" class="project-card__link">
                                        GitHub
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if(!isset($projects['big']) && !isset($projects['educational']) && !isset($projects['other']))
            <p style="color: #aaa; text-align: center; padding: 3rem;">Проектов пока нет</p>
        @endif
    </div>
@endsection
