<?php
// ------------------------------------------------------------
// index.php — простий роутер з авторизацією та редиректами
// ------------------------------------------------------------

// Автозавантаження Composer (якщо встановлено)
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

require_once 'dbCreateTable.php';

session_start(); // запуск сесії

$basePath = "/Karolinnna.github.io";

// ------------------------------------------------------------
// Обробка виходу з облікового запису (?logout=1)
// ------------------------------------------------------------
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie('login', '', time() - 3600, '/');

    header("Location: {$basePath}/login");
    exit;
}

// ------------------------------------------------------------
// 2) Перевірка: чи користувач уже авторизований
// ------------------------------------------------------------
$isAuthenticated = false;
if (isset($_SESSION['login']) || isset($_COOKIE['login'])) {
    $isAuthenticated = true;
}

// ------------------------------------------------------------
// 5) Отримуємо шлях (URI)
// ------------------------------------------------------------
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Прибираємо префікс папки, якщо сайт у піддиректорії
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}

if ($path === false) {
    $path = '/';
}

// Нормалізація
$path = rtrim($path, '/');
if ($path === '') {
    $path = '/';
}

// ------------------------------------------------------------
// 3) Обробка POST-запиту — спроба авторизації
// ------------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["login"], $_POST["password"])) {
        $login = trim($_POST["login"]);
        $password = trim($_POST["password"]);

        try {
            // Підключення до бази даних SQLite
            $myPDO = new PDO('sqlite:mydatabase.db');
            $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Підготовлений запит
            $sql = "SELECT id FROM User WHERE login = :login AND password = :password";
            $stmt = $myPDO->prepare($sql);

            // Виконання з параметрами
            $stmt->execute([
                ':login' => $login,
                ':password' => $password
            ]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['login'] = $login;
                setcookie('login', $login, time() + 10000, '/');

                header("Location: {$basePath}/");
                exit;
            } else {
                echo "користувач не існує";
            }

        } catch (PDOException $e) {
            echo "Помилка: " . $e->getMessage();
        }
    }
}

// ------------------------------------------------------------
// 4) Таблиця маршрутів (всі через контролери)
// ------------------------------------------------------------
$routes = [
    "/"          => [
        "controller" => "HomeController",
        "method" => "index",
        "template" => "home.php"
    ],
    "/login"     => [
        "controller" => "LoginController",
        "method" => "index",
        "template" => "login.php"
    ],
    "/aboutme"   => [
        "controller" => "AboutMeController",
        "method" => "index",
        "template" => "aboutme.php"
    ],
];

// ------------------------------------------------------------
// 6) Якщо користувач авторизований — не пускаємо на /login
// ------------------------------------------------------------
if ($isAuthenticated && in_array($path, ['/login'])) {
    header("Location: {$basePath}/");
    exit;
}

// ------------------------------------------------------------
// 7) Пошук маршруту і підключення відповідного файлу
// ------------------------------------------------------------
if (array_key_exists($path, $routes)) {

    $routeConfig = $routes[$path];

    // Всі маршрути тепер обробляються через контролери
    $controllerName = $routeConfig['controller'];
    $methodName = $routeConfig['method'] ?? 'index';
    $templateFile = $routeConfig['template'] ?? strtolower($controllerName) . '.php';

    $controllerFile = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $controllerName . '.php';
    $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . $templateFile;

    // Перевірка існування файлів контролера та шаблону
    if (!is_file($controllerFile)) {
        http_response_code(500);
        $file500 = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . '500.php';
        include $file500;
        exit;
    }

    if (!is_file($templatePath)) {
        http_response_code(500);
        $file500 = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . '500.php';
        include $file500;
        exit;
    }

    // Завантаження та виконання контролера
    require_once $controllerFile;
    $controllerClass = '\\Classes\\' . $controllerName;

    if (!class_exists($controllerClass)) {
        http_response_code(500);
        $file500 = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . '500.php';
        include $file500;
        exit;
    }

    $controller = new $controllerClass();

    if (!method_exists($controller, $methodName)) {
        http_response_code(500);
        $file500 = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . '500.php';
        include $file500;
        exit;
    }

    // Виклик методу контролера та отримання даних
    $data = $controller->$methodName();

    // Передача даних в глобальну область видимості
    if (is_array($data)) {
        extract($data);
    }

    // Підключення шаблону
    $currentPath = $path;
    $GLOBALS['currentPath'] = $path;
    include $templatePath;
    exit;
}

// ------------------------------------------------------------
// 8) Якщо маршруту не існує — показуємо сторінку 404
// ------------------------------------------------------------
http_response_code(404);
$title = "Сторінка не знайдена";

$file404 = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . '404.php';

if (is_file($file404)) {
    include $file404;
    exit;
} else {
    echo "<h1>404</h1><p>Сторінку не знайдено.</p>";
    exit;
}
