# Dockerfile для Laravel на Render
FROM php:8.2-cli

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Установка PHP расширений
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копирование файлов проекта
COPY . .

# Установка зависимостей
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci --include=dev

# Сборка фронтенда
RUN npm run build

# Права доступа для storage и cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose порт (Render использует переменную $PORT)
EXPOSE 10000

# Команда запуска (Render передаёт $PORT через переменную окружения)
# Если в Render в Environment добавлена RUN_MIGRATE_FRESH=1 — один раз выполнится migrate:fresh (сброс таблиц).
# После успешного деплоя удали RUN_MIGRATE_FRESH из Environment.
CMD if [ "$RUN_MIGRATE_FRESH" = "1" ]; then php artisan migrate:fresh --force; else php artisan migrate --force; fi && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
