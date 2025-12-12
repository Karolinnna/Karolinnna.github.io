<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Модель Artist - відповідає за роботу з артистами
 */
class Artist extends BaseModel
{
    public static function create($name, $genre = null, $bio = null)
    {
        try {
            $sql = "INSERT INTO Artist (name, genre, bio) 
                    VALUES (:name, :genre, :bio)";
            $pdo = self::getConnection();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':genre' => $genre,
                ':bio' => $bio
            ]);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Помилка створення артиста: " . $e->getMessage());
            return false;
        }
    }

    public static function findById($id)
    {
        $sql = "SELECT * FROM Artist WHERE id = :id";
        $stmt = self::executeQuery($sql, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        $sql = "SELECT * FROM Artist ORDER BY name";
        $stmt = self::executeQuery($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPopular($limit = 10)
    {
        $sql = "SELECT a.*, COUNT(t.id) as track_count 
                FROM Artist a 
                LEFT JOIN Track t ON a.id = t.artist_id 
                GROUP BY a.id 
                ORDER BY track_count DESC, a.name 
                LIMIT :limit";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $name, $genre = null, $bio = null)
    {
        try {
            $sql = "UPDATE Artist SET name = :name, genre = :genre, bio = :bio WHERE id = :id";
            self::executeQuery($sql, [
                ':name' => $name,
                ':genre' => $genre,
                ':bio' => $bio,
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка оновлення артиста: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id)
    {
        try {
            $sql = "DELETE FROM Track WHERE artist_id = :artist_id";
            self::executeQuery($sql, [':artist_id' => $id]);
            $sql = "DELETE FROM Artist WHERE id = :id";
            self::executeQuery($sql, [':id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка видалення артиста: " . $e->getMessage());
            return false;
        }
    }
}

