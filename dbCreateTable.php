<?php   

try {
    // Підключення до бази даних SQLite
    $myPDO = new PDO('sqlite:mydatabase.db');
    $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Створення таблиці, якщо її немає
    $sql = "
        CREATE TABLE IF NOT EXISTS User (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            login TEXT NOT NULL UNIQUE,
            password TEXT
        );
    ";

    $myPDO->exec($sql);

    //echo "Таблиця User створена (або вже існувала)";

    // Додаємо нового користувача
    $insert = "INSERT OR IGNORE INTO User (login, password) VALUES ('user', '123456')";
    $myPDO->exec($insert);
    $insert = "INSERT OR IGNORE INTO User (login, password) VALUES ('Karol', '123456')";
    $myPDO->exec($insert);
    $insert = "INSERT OR IGNORE INTO User (login, password) VALUES ('Den', '123456')";
    $myPDO->exec($insert);
    $insert = "INSERT OR IGNORE INTO User (login, password) VALUES ('Mike', '123456')";
    $myPDO->exec($insert);
    $insert = "INSERT OR IGNORE INTO User (login, password) VALUES ('Lina', '123456')";
    $myPDO->exec($insert);

    //echo "<br>Користувач доданий (або вже існував)";

} catch (PDOException $e) {
    echo "Помилка: " . $e->getMessage();
}

