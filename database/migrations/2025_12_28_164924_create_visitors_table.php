<?php

// Импортируем необходимые классы для миграции
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Миграция для создания таблицы посетителей
// Тут мы храним информацию о уникальных визитах на сайт
return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Запускает миграцию - создает таблицу visitors
     * 
     * Таблица хранит уникальных посетителей по комбинации IP + User Agent
     * Это позволяет отличать разных пользователей и считать реальную посещаемость
     */
    public function up(): void
    {
        Schema::dropIfExists('visitors');
        Schema::create('visitors', function (Blueprint $table) {
            // Автоинкрементный ID каждого визита
            $table->id();
            
            // IP-адрес посетителя (IPv4 или IPv6)
            // Это основной идентификатор посетителя
            // Максимум 45 символов для поддержки IPv6
            $table->string('ip_address', 45);
            
            // User Agent - информация о браузере и ОС посетителя
            // Помогает различать посетителей с одного IP (например, офис)
            // text потому что User Agent может быть длинным
            $table->text('user_agent');
            
            // Дата и время последнего визита этого посетителя
            // Обновляется при каждом заходе для подсчета активности
            $table->timestamp('last_visit')->useCurrent();
            
            // Стандартные временные метки (created_at, updated_at)
            $table->timestamps();
            
            // Уникальный индекс по комбинации IP + User Agent
            // Это гарантирует что один посетитель считается только один раз
            // Если приходит запрос с такой же комбинацией - обновляем last_visit
            $table->unique(['ip_address', 'user_agent'], 'visitor_unique');
        });
    }

    /**
     * Откатывает миграцию - удаляет таблицу visitors
     */
    public function down(): void
    {
        // Удаляем таблицу при откате миграции
        Schema::dropIfExists('visitors');
    }
};
