# API Документація - Loopi Music Platform

## Огляд

Цей документ містить опис всіх API ендпоінтів та routes веб-сайту Loopi - платформи для музики, плейлистів та артистів.

**Базовий URL:** `http://localhost/Karolinnna.github.io`

---

## Таблиця Routes (Маршрути)

| Route | Метод | Опис | Авторизація | Файл |
|-------|-------|------|-------------|------|
| `/` | GET | Головна сторінка з музичними рекомендаціями | Не обов'язкова | `Pages/home.php` |
| `/login` | GET | Сторінка авторизації | Не обов'язкова | `Pages/login.php` |
| `/login` | POST | Авторизація користувача | Не обов'язкова | `index.php` |
| `?logout=1` | GET | Вихід з облікового запису | Обов'язкова | `index.php` |
| `/*` (інші) | GET | Сторінка 404 (не знайдено) | - | `Pages/404.php` |

---

## Детальний опис Routes

### 1. Головна сторінка

**URL:** `/`  
**Метод:** `GET`  
**Опис:** Відображає головну сторінку з трендовими піснями, популярними артистами та чартами. Показує привітання для авторизованих користувачів.

**Параметри:** Немає

**Відповідь:** HTML сторінка (`Pages/home.php`)

**Особливості:**
- Якщо користувач авторизований, відображається його логін
- Якщо користувач не авторизований, показується кнопка "Log in"
- Автоматичний редирект на `/` якщо авторизований користувач намагається зайти на `/login`

---

### 2. Сторінка авторизації

**URL:** `/login`  
**Метод:** `GET`  
**Опис:** Відображає форму для входу в систему.

**Параметри:** Немає

**Відповідь:** HTML сторінка (`Pages/login.php`)

**Особливості:**
- Якщо користувач вже авторизований, автоматично перенаправляється на `/`
- Містить форму з полями `login` та `password`

---

## API Ендпоінти

### Таблиця API Ендпоінтів

| Метод | Ендпоінт | Опис | Параметри | Відповідь | Статус |
|-------|----------|------|-----------|-----------|--------|
| POST | `/login` або `/` | Авторизація користувача | `login`, `password` | Редирект або повідомлення про помилку | 200/302 |
| GET | `?logout=1` | Вихід з облікового запису | `logout=1` | Редирект на `/login` | 302 |

---

## Детальний опис API Ендпоінтів

### 1. Авторизація користувача

**URL:** `/login` або `/`  
**Метод:** `POST`  
**Опис:** Перевіряє логін та пароль користувача в базі даних SQLite та створює сесію при успішній авторизації.

**Параметри запиту (POST):**
- `login` (string, required) - Логін користувача (3-20 символів, тільки латинські літери, цифри, `_`, `-`)
- `password` (string, required) - Пароль користувача (мінімум 8 символів, має містити великі та малі літери, цифри та спеціальні символи)

**Валідація на клієнті:**
- Логін: `/^[a-zA-Z0-9_\-]{3,20}$/`
- Пароль: `/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/`

**Приклад запиту:**
```http
POST /login HTTP/1.1
Content-Type: application/x-www-form-urlencoded

login=user&password=123456
```

**Успішна відповідь:**
- HTTP 302 (Redirect)
- Встановлює `$_SESSION['login']` та cookie `login`
- Редирект на `/`

**Помилка:**
- HTTP 200
- Повідомлення: "користувач не існує"

**Коди статусів:**
- `200` - Помилка авторизації (неправильний логін/пароль)
- `302` - Успішна авторизація (редирект)
- `500` - Помилка сервера (помилка бази даних)

**Приклад використання (HTML форма):**
```html
<form method="POST" action="/login">
    <input type="text" name="login" id="login" required />
    <input type="password" name="password" id="password" required />
    <input type="submit" value="Log in">
</form>
```

---

### 2. Вихід з облікового запису

**URL:** `?logout=1`  
**Метод:** `GET`  
**Опис:** Завершує сесію користувача, видаляє cookie та перенаправляє на сторінку логіну.

**Параметри запиту:**
- `logout` (integer, required) - Має бути рівним `1`

**Приклад запиту:**
```http
GET /?logout=1 HTTP/1.1
```

**Відповідь:**
- HTTP 302 (Redirect)
- Видаляє `$_SESSION['login']`
- Видаляє cookie `login`
- Редирект на `/login`

**Коди статусів:**
- `302` - Успішний вихід (редирект)

**Приклад використання:**
```html
<a href="?logout=1">Log out</a>
```

---

## База даних

### Структура таблиці User

**Таблиця:** `User`  
**База даних:** SQLite (`mydatabase.db`)

| Поле | Тип | Опис |
|------|-----|------|
| `id` | INTEGER PRIMARY KEY AUTOINCREMENT | Унікальний ідентифікатор |
| `login` | TEXT NOT NULL UNIQUE | Логін користувача (унікальний) |
| `password` | TEXT | Пароль користувача |

### Тестові користувачі

При створенні бази даних автоматично додаються наступні користувачі:
- `user` / `123456`
- `Karol` / `123456`
- `Den` / `123456`
- `Mike` / `123456`
- `Lina` / `123456`

---

## Аутентифікація та Сесії

### Механізм авторизації

1. **Сесії PHP:** Використовується `$_SESSION['login']` для зберігання логіну
2. **Cookies:** Встановлюється cookie `login` з терміном дії 10000 секунд
3. **Перевірка:** Система перевіряє наявність `$_SESSION['login']` або `$_COOKIE['login']`

### Захищені routes

- `/login` - автоматично перенаправляє авторизованих користувачів на `/`

---

## Конфігурація

### Базовий шлях

```php
$basePath = "/Karolinnna.github.io";
```

**Примітка:** Змініть цей шлях відповідно до вашої конфігурації сервера.

### .htaccess

Використовується mod_rewrite для перенаправлення всіх запитів на `index.php`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

---

## Приклади використання

### JavaScript (Fetch API)

```javascript
// Авторизація
const formData = new FormData();
formData.append('login', 'user');
formData.append('password', '123456');

fetch('/login', {
    method: 'POST',
    body: formData
})
.then(response => {
    if (response.redirected) {
        window.location.href = response.url;
    }
})
.catch(error => console.error('Error:', error));

// Вихід
window.location.href = '/?logout=1';
```

### cURL

```bash
# Авторизація
curl -X POST http://localhost/Karolinnna.github.io/login \
  -d "login=user&password=123456" \
  -c cookies.txt \
  -L

# Вихід
curl -X GET "http://localhost/Karolinnna.github.io/?logout=1" \
  -b cookies.txt \
  -L
```

---

## Обробка помилок

### Сторінки помилок

| Код | Опис | Файл |
|-----|------|------|
| 404 | Сторінка не знайдена | `Pages/404.php` |
| 500 | Помилка сервера | `Pages/500.php` |

### Повідомлення про помилки

- **Авторизація:** "користувач не існує" (якщо логін/пароль невірні)
- **База даних:** Повідомлення про помилку PDO виводиться безпосередньо

---

## Посилання на документацію

### Внутрішня документація

| Ресурс | Посилання | Опис |
|--------|-----------|------|
| Головна сторінка | [http://localhost/Karolinnna.github.io/](http://localhost/Karolinnna.github.io/) | Головна сторінка сайту |
| Сторінка авторизації | [http://localhost/Karolinnna.github.io/login](http://localhost/Karolinnna.github.io/login) | Форма входу |
| GitHub Repository | [https://github.com/Karolinnna/Karolinnna.github.io](https://github.com/Karolinnna/Karolinnna.github.io) | Репозиторій проєкту |

### Зовнішні ресурси

| Ресурс | Посилання | Опис |
|--------|-----------|------|
| PHP Documentation | [https://www.php.net/docs.php](https://www.php.net/docs.php) | Офіційна документація PHP |
| PDO Documentation | [https://www.php.net/manual/en/book.pdo.php](https://www.php.net/manual/en/book.pdo.php) | Документація PDO |
| SQLite Documentation | [https://www.sqlite.org/docs.html](https://www.sqlite.org/docs.html) | Документація SQLite |
| Apache mod_rewrite | [https://httpd.apache.org/docs/current/mod/mod_rewrite.html](https://httpd.apache.org/docs/current/mod/mod_rewrite.html) | Документація mod_rewrite |

---

## Структура проєкту

```
Karolinnna.github.io/
├── index.php              # Головний роутер
├── dbCreateTable.php      # Ініціалізація бази даних
├── .htaccess             # Конфігурація Apache
├── mydatabase.db         # База даних SQLite
├── Pages/
│   ├── home.php          # Головна сторінка
│   ├── login.php         # Сторінка авторизації
│   ├── 404.php           # Сторінка 404
│   └── 500.php           # Сторінка 500
├── Scripts/
│   └── script.js         # JavaScript для валідації форм
├── Styles/
│   ├── style.css         # Основні стилі
│   └── normalize.css     # Нормалізація стилів
├── Photo/                # Зображення
└── Fonts/                # Шрифти
```

---

## Технології

- **Backend:** PHP 7.4+
- **База даних:** SQLite 3
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Сервер:** Apache (XAMPP)
- **Роутинг:** Custom PHP Router

---

## Версіонування

**Поточна версія:** 1.0.0

---

## Підтримка

Для питань та підтримки звертайтесь до:
- **GitHub Issues:** [https://github.com/Karolinnna/Karolinnna.github.io/issues](https://github.com/Karolinnna/Karolinnna.github.io/issues)
- **Автор:** Karol

---

*Останнє оновлення: 2025-01-27*
