#!/bin/bash

# Скрипт подготовки проекта для деплоя на Reg.ru
# Использование: ./prepare-for-regru.sh

echo "🚀 Подготовка проекта для Reg.ru..."

# 1. Установить зависимости
echo "📦 Установка PHP-зависимостей..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "📦 Установка npm-зависимостей..."
npm ci

echo "🔨 Сборка фронтенда..."
npm run build

# 2. Создать .env.production если его нет
if [ ! -f .env.production ]; then
    echo "📝 Создание .env.production из .env.regru.example..."
    cp .env.regru.example .env.production
    echo "⚠️  ВАЖНО: Отредактируй .env.production и заполни все значения!"
fi

# 3. Сгенерировать APP_KEY если его нет
if ! grep -q "APP_KEY=base64:" .env.production 2>/dev/null; then
    echo "🔑 Генерация APP_KEY..."
    KEY=$(php artisan key:generate --show 2>/dev/null || echo "")
    if [ ! -z "$KEY" ]; then
        sed -i.bak "s|APP_KEY=.*|APP_KEY=$KEY|" .env.production
        echo "✅ APP_KEY сгенерирован"
    else
        echo "⚠️  Не удалось сгенерировать APP_KEY. Выполни вручную: php artisan key:generate --show"
    fi
fi

# 4. Создать список файлов для загрузки
echo "📋 Создание списка файлов для загрузки..."
cat > regru-upload-list.txt << 'EOF'
# Файлы для загрузки на Reg.ru

## В корень сайта (public_html или www):
# Загрузи ВСЁ содержимое папки public/

## В родительскую папку (или корень, если Reg.ru позволяет):
app/
bootstrap/
config/
database/
resources/
routes/
storage/
vendor/
artisan
composer.json
composer.lock
.env.production (переименуй в .env на сервере)

## НЕ загружать:
node_modules/
.git/
tests/
storage/logs/*.log
.env (локальный)
EOF

echo ""
echo "✅ Готово!"
echo ""
echo "📋 Следующие шаги:"
echo "1. Отредактируй .env.production и заполни все значения"
echo "2. Проверь список файлов в regru-upload-list.txt"
echo "3. Загрузи файлы на Reg.ru через FTP (см. DEPLOYMENT_REG_RU.md)"
echo "4. На сервере переименуй .env.production в .env"
echo "5. Выставь права на storage/ и bootstrap/cache/ (775)"
echo "6. Выполни миграции и сидер (см. DEPLOYMENT_REG_RU.md)"
