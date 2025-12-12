<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Модель User - відповідає за роботу з користувачами
 * Реалізує CRUD операції для користувачів
 */
class User extends BaseModel
{
    /**
     * Створення нового користувача
     * @param string $login Логін користувача
     * @param string $password Пароль користувача
     * @return bool Успішність операції
     */
    public static function create($login, $password)
    {
        try {
            // Хешуємо пароль через bcrypt
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            $sql = "INSERT INTO User (login, password) VALUES (:login, :password)";
            self::executeQuery($sql, [
                ':login' => $login,
                ':password' => $hashedPassword
            ]);
            return true;
        } catch (PDOException $e) {
            // Логінування помилки (в продакшені краще використовувати логер)
            error_log("Помилка створення користувача: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Перевірка авторизації користувача
     * @param string $login Логін користувача
     * @param string $password Пароль користувача
     * @return array|false Дані користувача або false
     */
    public static function authenticate($login, $password)
    {
        $sql = "SELECT * FROM User WHERE login = :login";
        $stmt = self::executeQuery($sql, [':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Перевіряємо пароль через password_verify (bcrypt)
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    /**
     * Отримання користувача за ID
     * @param int $id ID користувача
     * @return array|false Дані користувача або false
     */
    public static function findById($id)
    {
        $sql = "SELECT id, login FROM User WHERE id = :id";
        $stmt = self::executeQuery($sql, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Отримання користувача за логіном
     * @param string $login Логін користувача
     * @return array|false Дані користувача або false
     */
    public static function findByLogin($login)
    {
        $sql = "SELECT id, login FROM User WHERE login = :login";
        $stmt = self::executeQuery($sql, [':login' => $login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Отримання всіх користувачів
     * @return array Масив користувачів
     */
    public static function getAll()
    {
        $sql = "SELECT id, login FROM User ORDER BY id";
        $stmt = self::executeQuery($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Оновлення пароля користувача
     * @param int $id ID користувача
     * @param string $newPassword Новий пароль
     * @return bool Успішність операції
     */
    public static function updatePassword($id, $newPassword)
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE User SET password = :password WHERE id = :id";
            self::executeQuery($sql, [
                ':password' => $hashedPassword,
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка оновлення пароля: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Видалення користувача
     * @param int $id ID користувача
     * @return bool Успішність операції
     */
    public static function delete($id)
    {
        try {
            $sql = "DELETE FROM User WHERE id = :id";
            self::executeQuery($sql, [':id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка видалення користувача: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Перевірка чи існує користувач з таким логіном
     * @param string $login Логін для перевірки
     * @return bool
     */
    public static function exists($login)
    {
        $user = self::findByLogin($login);
        return $user !== false;
    }
}

