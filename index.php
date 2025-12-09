<?php
// ------------------------------------------------------------
// index.php — простий роутер з авторизацією та редиректами
// ------------------------------------------------------------

require_once 'dbCreateTable.php';

session_start(); // запуск сесії

$basePath = "/Karolinnna.github.io"; // твоя папка у htdocs

// ------------------------------------------------------------
// Обробка виходу з облікового запису (?logout=1)
// ------------------------------------------------------------
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie('login', '', time() - 3600, '/');

    // Редирект на сторінку логіну з урахуванням папки
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

                // Редирект на головну з урахуванням папки
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
// 4) Таблиця маршрутів
// ------------------------------------------------------------
$routes = [
    "/"          => ["title" => "ГОЛОВНА",      "file" => "home.php"],
    "/login"     => ["title" => "АВТОРИЗАЦІЯ",  "file" => "login.php"],
    "/registration" => ["title" => "РЕЄСТРАЦІЯ", "file" => "registration.php"],
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

    $title = $routes[$path]['title'] ?? 'Сторінка';
    $file  = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . $routes[$path]['file'];

    if (is_file($file)) {
        $currentPath = $path;
        $GLOBALS['currentPath'] = $path;
        include $file;
        exit;
    } else {
        http_response_code(500);
        $file500 = __DIR__ . DIRECTORY_SEPARATOR . 'Pages' . DIRECTORY_SEPARATOR . '500.php';
        include $file500;
        exit;
    }
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
