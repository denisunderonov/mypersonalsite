@extends('layouts.app')

@section('title', 'Проекты - denisunderonov')

@section('content')
    <div id="projects-anchor"></div>
    <div class="projects">
        <h1 class="projects__main-title">Мои Проекты</h1>

        {{-- Большие проекты --}}
        <section class="projects__section">
            <h2 class="projects__section-title">Большие проекты</h2>
            
            <div class="projects__grid">
                <article class="project-card">
                    <h3 class="project-card__title">Персональный сайт-портфолио</h3>
                    
                    <p class="project-card__description">
                        Современный веб-сайт с блогом и портфолио, построенный на Laravel и PostgreSQL. 
                        Включает адаптивный дизайн, динамическую навигацию и систему управления контентом.
                    </p>
                    
                    <div class="project-card__tags">
                        <span class="project-card__tag">Laravel</span>
                        <span class="project-card__tag">PostgreSQL</span>
                        <span class="project-card__tag">SCSS</span>
                        <span class="project-card__tag">Docker</span>
                    </div>
                    
                    <div class="project-card__links">
                        <a href="https://denisunderonov.webp" target="_blank" class="project-card__link">
                            Посмотреть сайт
                        </a>
                        <a href="https://github.com/denisunderonov" target="_blank" class="project-card__link">
                            GitHub
                        </a>
                    </div>
                </article>

                <article class="project-card">
                    <h3 class="project-card__title">E-commerce платформа</h3>
                    
                    <p class="project-card__description">
                        Полнофункциональный интернет-магазин с корзиной, системой оплаты и админ-панелью. 
                        Реализована интеграция с платёжными системами и управление заказами.
                    </p>
                    
                    <div class="project-card__tags">
                        <span class="project-card__tag">Laravel</span>
                        <span class="project-card__tag">Vue.js</span>
                        <span class="project-card__tag">Stripe</span>
                    </div>
                    
                    <div class="project-card__links">
                        <a href="#" target="_blank" class="project-card__link">
                            Посмотреть сайт
                        </a>
                        <a href="https://github.com" target="_blank" class="project-card__link">
                            GitHub
                        </a>
                    </div>
                </article>
            </div>
        </section>

        {{-- Учебные проекты --}}
        <section class="projects__section">
            <h2 class="projects__section-title">Учебные проекты</h2>
            
            <div class="projects__grid">
                <article class="project-card project-card--small">
                    <h3 class="project-card__title">Todo приложение</h3>
                    
                    <p class="project-card__description">
                        Простое приложение для управления задачами с возможностью добавления, редактирования и удаления задач.
                    </p>
                    
                    <div class="project-card__tags">
                        <span class="project-card__tag">React</span>
                        <span class="project-card__tag">Node.js</span>
                    </div>
                    
                    <div class="project-card__links">
                        <a href="#" target="_blank" class="project-card__link">
                            GitHub
                        </a>
                    </div>
                </article>

                <article class="project-card project-card--small">
                    <h3 class="project-card__title">Погодное приложение</h3>
                    
                    <p class="project-card__description">
                        Веб-приложение для отображения погоды с использованием API. Показывает текущую погоду и прогноз.
                    </p>
                    
                    <div class="project-card__tags">
                        <span class="project-card__tag">JavaScript</span>
                        <span class="project-card__tag">API</span>
                    </div>
                    
                    <div class="project-card__links">
                        <a href="#" target="_blank" class="project-card__link">
                            Демо
                        </a>
                        <a href="#" target="_blank" class="project-card__link">
                            GitHub
                        </a>
                    </div>
                </article>

                <article class="project-card project-card--small">
                    <h3 class="project-card__title">Калькулятор</h3>
                    
                    <p class="project-card__description">
                        Интерактивный калькулятор с современным интерфейсом и поддержкой различных операций.
                    </p>
                    
                    <div class="project-card__tags">
                        <span class="project-card__tag">HTML</span>
                        <span class="project-card__tag">CSS</span>
                        <span class="project-card__tag">JS</span>
                    </div>
                    
                    <div class="project-card__links">
                        <a href="#" target="_blank" class="project-card__link">
                            GitHub
                        </a>
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
