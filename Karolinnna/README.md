# Karolinnna.github.io

## 🚀 Технології

* **PHP 8+** - основний мова програмування
* **Latte** - сучасний шаблонізатор для PHP
* **MVC Architecture** - контролери, моделі, представлення
* **PSR-4 Autoloading** - стандарти автозавантаження

## 📁 Структура проекту

```
Karolinnna.github.io/
├── 📁 public/                    # Публічні файли (якщо будуть)
├── 📁 src/                      # Вихідний код
│   ├── 📁 Classes/              # PHP класи (PSR-4)
│   │   └── 📄 Viewer.php        # Рендеринг шаблонів Latte
│   ├── 📁 Controllers/          # Контролери MVC
│   │   ├── 📄 HomeController.php     # Головна сторінка
│   │   ├── 📄 LoginController.php    # Авторизація
│   │   └── 📄 AboutMeController.php  # Сторінка "Про мене"
│   └── 📁 templates/            # Latte шаблони
│       └── 📄 aboutme.latte     # Шаблон "Про мене"
├── 📁 Pages/                    # PHP шаблони сторінок
│   ├── 📄 home.php              # Головна сторінка
│   ├── 📄 login.php             # Форма авторизації
│   ├── 📄 aboutme.php           # Сторінка "Про мене"
│   ├── 📄 404.php               # Сторінка 404
│   └── 📄 500.php               # Сторінка помилок
├── 📁 Styles/                   # CSS стилі
├── 📁 Scripts/                  # JavaScript файли
├── 📁 Photo/                    # Зображення
├── 📄 index.php                 # Точка входу, маршрутизація
├── 📄 composer.json             # Конфігурація Composer
├── 📄 dbCreateTable.php         # Налаштування бази даних
└── 📄 README.md                 # Цей файл
```

## 🎯 Архітектура MVC

### Model-View-Controller

* **Model** - логіка даних (поки що в контролерах)
* **View** - PHP та Latte шаблони
* **Controller** - класи в `src/Controllers/`

### Структура контролера

```php
<?php
namespace Classes;

class ExampleController
{
    public function index(): array
    {
        // Логіка контролера
        return [
            'title' => 'Назва сторінки',
            'data' => $someData
        ];
    }
}
```

## 🔧 Маршрутизація

Всі маршрути налаштовані в `index.php`:

```php
$routes = [
    "/" => [
        "controller" => "HomeController",
        "method" => "index",
        "template" => "home.php"
    ],
    "/aboutme" => [
        "controller" => "AboutMeController",
        "method" => "index",
        "template" => "aboutme.php"
    ],
];
```

## 🚀 Встановлення

1. **PHP 8.0+** обов'язковий
2. **Composer** для автозавантаження (опціонально)
3. Запуск через веб-сервер або `php -S localhost:8000`

## 📱 Функціональність

* **Головна сторінка** з музичним контентом
* **Авторизація** користувачів
* **Сторінка "Про мене"** з інформацією про розробника
* **Адаптивний дизайн** для всіх пристроїв

Тестові облікові записи будуть додані пізніше.

## 🔐 Безпека

* Сесійна авторизація
* Захист від XSS через htmlspecialchars()
* Валідація вхідних даних

---

Розроблено з ❤️ для демонстрації MVC архітектури на PHP.
