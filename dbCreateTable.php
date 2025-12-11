<?php

class Database
{
    private static $pdo;

    // Підключення до SQLite
    public static function connect()
    {
        self::$pdo = new PDO('sqlite:mydatabase.db');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Перевірка користувача (авторизація) - використовує параметризовані запити
    public static function checkUser($login, $password)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM User WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Перевіряємо пароль через password_verify (bcrypt)
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Створення нового користувача (ігноруємо помилки UNIQUE) - використовує параметризовані запити та bcrypt
    public static function createUser($login, $password)
    {
        try {
            // Хешуємо пароль через bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            $stmt = self::$pdo->prepare("INSERT INTO User (login, password) VALUES (:login, :password)");
            $stmt->execute([
                ':login' => $login,
                ':password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            // Ігноруємо помилку, якщо такий логін вже існує
        }
    }

    // Створення таблиці User
    public static function createTable()
    {
        self::$pdo->exec("
            CREATE TABLE IF NOT EXISTS User (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                login TEXT NOT NULL UNIQUE,
                password TEXT
            );
        ");
    }
}

try {
    // Підключення
    Database::connect();

    // Створюємо таблицю
    Database::createTable();

    $newUser = ['karol', '12345'];

    // Додаємо користувача (пароль буде захешований через bcrypt)
    Database::createUser($newUser[0], $newUser[1]);

    // Перевіряємо користувача (використовує password_verify для перевірки bcrypt хешу)
    $user = Database::checkUser($newUser[0], $newUser[1]);

    if ($user) {
        echo "Користувач авторизований!";
    } else {
        echo "Невірний логін або пароль!";
    }

} catch (PDOException $e) {
    echo "Помилка: " . $e->getMessage();
}
