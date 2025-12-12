<?php

/**
 * Базовий клас для всіх моделей
 * Містить загальну логіку роботи з базою даних
 */
class BaseModel
{
    protected static $pdo;

    /**
     * Підключення до бази даних
     */
    protected static function getConnection()
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO('sqlite:mydatabase.db');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }

    /**
     * Виконання параметризованого запиту
     */
    protected static function executeQuery($sql, $params = [])
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}

