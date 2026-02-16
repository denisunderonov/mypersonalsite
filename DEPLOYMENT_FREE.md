# Деплой по шагам (бесплатно: Neon + Render)

Делай всё по порядку. Сначала база, потом сайт.

---

## БЛОК 1: База данных (Neon)

### Шаг 1 — Открыть Neon

1. Открой в браузере: **https://neon.tech**
2. Нажми **Sign up** (или **Log in**, если уже есть аккаунт).
3. Войди через **GitHub** — так проще.

### Шаг 2 — Создать проект

1. На главной нажми кнопку **New Project**.
2. В поле **Project name** введи: `mypersonalsite` (или любое имя).
3. **Region** оставь как есть (например, US East).
4. Нажми **Create Project**.

### Шаг 3 — Скопировать строку подключения

1. После создания откроется дашборд проекта.
2. Вверху справа нажми кнопку **Connect**.
3. В выпадающем списке выбери **Connection string** (или **Laravel**, если есть).
4. Скопируй строку — она выглядит так:
   ```text
   postgresql://neondb_owner:xxxxx@ep-xxx-xxx.region.aws.neon.tech/neondb?sslmode=require
   ```
5. Сохрани её в блокнот — понадобится на Render.  
   **Важно:** не публикуй эту строку нигде, в ней пароль.

На этом с Neon всё. База создана, строка подключения есть.

---

## БЛОК 2: Сайт на Render

### Шаг 4 — Открыть Render

1. Открой: **https://render.com**
2. Нажми **Get Started** (или **Log in**).
3. Войди через **GitHub**.

### Шаг 5 — Создать Web Service

1. В личном кабинете Render нажми **New +** (или **Create new**).
2. В списке выбери **Web Service**.
3. Если Render спросит доступ к репозиториям — разреши доступ к GitHub и выбери репозиторий **mypersonalsite**.
4. В списке репозиториев нажми на **mypersonalsite** (или подключи репо по инструкции на экране).
5. Нажми **Connect** рядом с репозиторием.

### Шаг 6 — Заполнить настройки сервиса

На странице создания сервиса заполни так:

| Поле | Что сделать |
|------|-------------|
| **Name** | Введи: `mypersonalsite` (или другое имя — из него будет URL). |
| **Region** | Выбери, например, **Frankfurt (EU Central)**. |
| **Branch** | Должно быть **main**. |
| **Root Directory** | Оставь пустым. |
| **Language** | В выпадающем списке выбери **Docker** (не Node). От этого поля зависит, что будет собираться: при Docker сборка идёт по Dockerfile. |
| **Build Command** | Если поле **обязательное** и не исчезает при выборе Docker — вставь одну из строк: `true` или `echo "Docker"`. При Language = Docker Render всё равно собирает образ из Dockerfile, это значение не используется. |
| **Start Command** | Оставь пустым (запуск задаётся в Dockerfile). |

**Важно:** В Render тип окружения задаётся полем **Language** (не Runtime). Обязательно выбери **Docker**, иначе будет среда Node и команда `composer` не найдётся.

Остальное пока не трогай.

### Шаг 7 — Добавить переменные окружения

1. Прокрути страницу вниз до блока **Environment** (или **Environment Variables**).
2. Нажми **Add Environment Variable** (или **+ Add**).
3. Добавь переменные **по одной** (Key и Value):

| Key | Value |
|-----|--------|
| `APP_NAME` | `Denis Underonov` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Сгенерируй локально: в терминале в папке проекта выполни `php artisan key:generate --show` и вставь вывод (начинается с `base64:...`). |
| `APP_URL` | Пока напиши: `https://mypersonalsite.onrender.com` (если Name был другой — подставь его вместо mypersonalsite). |
| `APP_LOCALE` | `ru` |
| `APP_FALLBACK_LOCALE` | `ru` |
| `LOG_LEVEL` | `error` |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | Вставь **целиком** строку подключения из Neon (из шага 3). |
| `SESSION_DRIVER` | `database` |
| `SESSION_SECURE_COOKIE` | `true` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |

4. Проверь, что **DB_URL** — именно та длинная строка из Neon, с `postgresql://...` и `?sslmode=require` в конце.

### Шаг 8 — Запустить деплой

1. Внизу страницы нажми **Create Web Service**.
2. Render начнёт сборку и деплой (5–10 минут).
3. Вверху появится ссылка вида `https://mypersonalsite.onrender.com` — это твой сайт. Пока идёт деплой, она может открываться с ошибкой — подожди до зелёного статуса **Live**.

### Шаг 9 — Обновить APP_URL (если Render дал другой URL)

1. Если вверху у сервиса другой адрес (например `https://mypersonalsite-xxxx.onrender.com`), скопируй его.
2. В Render открой свой сервис → слева **Environment**.
3. Найди переменную **APP_URL** и измени значение на этот точный URL (с `https://`).
4. Сохрани (Save) — Render перезапустит сервис с новым APP_URL.

### Шаг 10 — Создать админа в базе

1. В Render открой свой сервис (mypersonalsite).
2. Слева нажми **Shell** (или вкладка с консолью).
3. В открывшейся консоли введи команду и нажми Enter:  
   `php artisan db:seed --class=AdminUserSeeder --force`
4. Должно появиться сообщение об успешном выполнении.

---

## Готово: проверка

1. Открой в браузере ссылку на сервис (например `https://mypersonalsite.onrender.com`).
2. Должна открыться главная страница сайта.
3. Перейди на `https://mypersonalsite.onrender.com/admin/login`.
4. Войди:
   - **Email:** `denisunderonov2@gmail.com`
   - **Пароль:** `Denimz13141314..`

Если всё открылось и вход в админку прошёл — деплой завершён.

---

## Краткий чек-лист

- [ ] Neon: зарегистрировался, создал проект, скопировал Connection string.
- [ ] Render: создал Web Service от репозитория mypersonalsite.
- [ ] Render: указал Start Command и все переменные (особенно APP_KEY и DB_URL).
- [ ] Render: нажал Create Web Service, дождался зелёного Live.
- [ ] Render: в Shell выполнил `php artisan db:seed --class=AdminUserSeeder --force`.
- [ ] Открыл сайт и `/admin/login`, проверил вход.

---

## Если что-то пошло не так

- **Ошибка про APP_KEY** — добавь в Environment переменную `APP_KEY` (команда: `php artisan key:generate --show`).
- **Ошибка подключения к БД** — проверь `DB_URL`: скопировал ли всю строку из Neon, есть ли в конце `?sslmode=require`.
- **500 на сайте** — открой в Render вкладку **Logs** и посмотри текст ошибки внизу лога.
- **Не грузятся стили** — убедись, что `APP_URL` в Environment точно совпадает с URL сайта в браузере (с `https://`).

### Ошибка миграций: «current transaction is aborted» / «users_email_unique»

Так бывает, если миграции когда-то частично выполнились и база в Neon осталась в некорректном состоянии. Нужно один раз сбросить схему и заново применить миграции.

**Вариант 1 — сброс в Neon (рекомендуется):**

1. Зайди в [Neon Console](https://console.neon.tech), открой свой проект.
2. Слева выбери **SQL Editor**.
3. Выполни по очереди:
   ```sql
   DROP SCHEMA public CASCADE;
   CREATE SCHEMA public;
   GRANT ALL ON SCHEMA public TO neondb_owner;
   GRANT ALL ON SCHEMA public TO public;
   ```
   (если у тебя другой владелец БД — замени `neondb_owner` на него или выполни только первые две строки).
4. Сохрани изменения, затем в Render нажми **Manual Deploy** → **Deploy latest commit**. Миграции выполнятся заново на чистой схеме.

**Вариант 2 — через Render Shell:**

1. В Render открой сервис → **Shell**.
2. Выполни: `php artisan migrate:fresh --force` (удалит все таблицы и заново применит миграции).
3. Затем снова создай админа: `php artisan db:seed --class=AdminUserSeeder --force`.
4. Обнови страницу сайта.

**Вариант 3 — сброс через переменную окружения (без правки Neon):**

1. В Render открой сервис → **Environment** → **Add Environment Variable**.
2. Добавь переменную: ключ `RUN_MIGRATE_FRESH`, значение `1`. Сохрани (Render перезапустит деплой).
3. Дождись успешного деплоя — миграции выполнятся заново (таблицы будут пересозданы).
4. В **Shell** выполни: `php artisan db:seed --class=AdminUserSeeder --force`
5. В **Environment** удали переменную `RUN_MIGRATE_FRESH` и сохрани, чтобы следующие деплои не сбрасывали базу.

Дальше при каждом `git push` в ветку `main` Render будет автоматически пересобирать и деплоить проект.
