<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Модель Playlist - відповідає за роботу з плейлистами
 */
class Playlist extends BaseModel
{
    public static function create($name, $userId, $description = null)
    {
        try {
            $sql = "INSERT INTO Playlist (name, user_id, description, created_at) 
                    VALUES (:name, :user_id, :description, datetime('now'))";
            $pdo = self::getConnection();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':user_id' => $userId,
                ':description' => $description
            ]);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Помилка створення плейлиста: " . $e->getMessage());
            return false;
        }
    }

    public static function findById($id)
    {
        $sql = "SELECT p.*, u.login as owner_login 
                FROM Playlist p 
                LEFT JOIN User u ON p.user_id = u.id 
                WHERE p.id = :id";
        $stmt = self::executeQuery($sql, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByUserId($userId)
    {
        $sql = "SELECT * FROM Playlist WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = self::executeQuery($sql, [':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        $sql = "SELECT p.*, u.login as owner_login 
                FROM Playlist p 
                LEFT JOIN User u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        $stmt = self::executeQuery($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $name, $description = null)
    {
        try {
            $sql = "UPDATE Playlist SET name = :name, description = :description WHERE id = :id";
            self::executeQuery($sql, [
                ':name' => $name,
                ':description' => $description,
                ':id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка оновлення плейлиста: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id)
    {
        try {
            $sql = "DELETE FROM PlaylistTrack WHERE playlist_id = :playlist_id";
            self::executeQuery($sql, [':playlist_id' => $id]);
            $sql = "DELETE FROM Playlist WHERE id = :id";
            self::executeQuery($sql, [':id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка видалення плейлиста: " . $e->getMessage());
            return false;
        }
    }

    public static function addTrack($playlistId, $trackId)
    {
        try {
            $sql = "INSERT INTO PlaylistTrack (playlist_id, track_id, added_at) 
                    VALUES (:playlist_id, :track_id, datetime('now'))";
            self::executeQuery($sql, [
                ':playlist_id' => $playlistId,
                ':track_id' => $trackId
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка додавання треку: " . $e->getMessage());
            return false;
        }
    }

    public static function getTracks($playlistId)
    {
        $sql = "SELECT t.*, a.name as artist_name 
                FROM Track t
                INNER JOIN PlaylistTrack pt ON t.id = pt.track_id
                LEFT JOIN Artist a ON t.artist_id = a.id
                WHERE pt.playlist_id = :playlist_id
                ORDER BY pt.added_at ASC";
        $stmt = self::executeQuery($sql, [':playlist_id' => $playlistId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
