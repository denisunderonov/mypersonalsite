# 🚀 Быстрый старт деплоя на Railway

## Шаг 1: Запуш код на GitHub

```bash
git add .
git commit -m "Ready for Railway deployment"
git push origin main
```

## Шаг 2: Зайди на Railway

1. Открой https://railway.app
2. Нажми "Start a New Project"
3. Выбери "Deploy from GitHub repo"
4. Выбери репозиторий `mypersonalsite`

## Шаг 3: Добавь PostgreSQL

1. Нажми "+ New" в проекте
2. Выбери "Database" → "Add PostgreSQL"

## Шаг 4: Настрой переменные окружения

В разделе **Variables** сервиса добавь:

```
APP_KEY=base64:W0bxkA/MgNmLI1ZPyLMVOM8nx9/0tR6YTGotCTaMGis=
APP_ENV=production
APP_DEBUG=false
APP_LOCALE=ru
SESSION_DRIVER=database
DB_CONNECTION=pgsql
```

## Шаг 5: Сгенерируй домен

1. Settings → Domains
2. "Generate Domain"
3. Добавь переменную:
```
APP_URL=https://твой-домен.up.railway.app
```

## Шаг 6: Подожди деплоя

Railway автоматически задеплоит (3-5 минут).

## Шаг 7: Создай админа

После деплоя:
```bash
npm i -g @railway/cli
railway login
railway link
railway run php artisan db:seed --class=AdminUserSeeder
```

## ✅ Готово!

Админка: `https://твой-домен.up.railway.app/admin/login`
- Email: `denisunderonov2@gmail.com`
- Пароль: `Denimz13141314..`

---

📖 Подробная инструкция: см. `DEPLOYMENT.md`
