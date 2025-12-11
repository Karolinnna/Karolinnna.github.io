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

    // Перевірка користувача (авторизація)
    public static function checkUser($login, $password)
    {
        $stmt = self::$pdo->query("SELECT * FROM User WHERE login = '$login' AND password = '$password'");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Створення нового користувача (ігноруємо помилки UNIQUE)
    public static function createUser($login, $password)
    {
        try {
            self::$pdo->exec("INSERT INTO User (login, password) VALUES ('$login', '$password')");
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

    // Додаємо користувача
    Database::createUser($newUser[0], $newUser[1]);

    // Перевіряємо користувача
    $user = Database::checkUser($newUser[0], $newUser[1]);

    if ($user) {
        echo "Користувач авторизований!";
    } else {
        echo "Невірний логін або пароль!";
    }

} catch (PDOException $e) {
    echo "Помилка: " . $e->getMessage();
}
