<?php

require_once __DIR__ . '/BaseModel.php';

/**
 * Модель Track - відповідає за роботу з треками
 */
class Track extends BaseModel
{
    public static function create($name, $artistId, $duration = null, $album = null)
    {
        try {
            $sql = "INSERT INTO Track (name, artist_id, duration, album) 
                    VALUES (:name, :artist_id, :duration, :album)";
            $pdo = self::getConnection();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':artist_id' => $artistId,
                ':duration' => $duration,
                ':album' => $album
            ]);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Помилка створення треку: " . $e->getMessage());
            return false;
        }
    }

    public static function findById($id)
    {
        $sql = "SELECT t.*, a.name as artist_name 
                FROM Track t 
                LEFT JOIN Artist a ON t.artist_id = a.id 
                WHERE t.id = :id";
        $stmt = self::executeQuery($sql, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        $sql = "SELECT t.*, a.name as artist_name 
                FROM Track t 
                LEFT JOIN Artist a ON t.artist_id = a.id 
                ORDER BY t.name";
        $stmt = self::executeQuery($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByArtistId($artistId)
    {
        $sql = "SELECT * FROM Track WHERE artist_id = :artist_id ORDER BY name";
        $stmt = self::executeQuery($sql, [':artist_id' => $artistId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTrending($limit = 10)
    {
        $sql = "SELECT t.*, a.name as artist_name 
                FROM Track t 
                LEFT JOIN Artist a ON t.artist_id = a.id 
                ORDER BY t.id DESC 
                LIMIT :limit";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        try {
            $sql = "DELETE FROM PlaylistTrack WHERE track_id = :track_id";
            self::executeQuery($sql, [':track_id' => $id]);
            $sql = "DELETE FROM Track WHERE id = :id";
            self::executeQuery($sql, [':id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Помилка видалення треку: " . $e->getMessage());
            return false;
        }
    }
}

