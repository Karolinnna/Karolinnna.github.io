# Моделі додатку

## Структура моделей

### BaseModel
Базовий клас для всіх моделей, містить:
- Підключення до БД
- Метод `executeQuery()` для виконання параметризованих запитів

### User
Модель для роботи з користувачами:
- `create($login, $password)` - створення користувача
- `authenticate($login, $password)` - авторизація
- `findById($id)` - пошук за ID
- `findByLogin($login)` - пошук за логіном
- `getAll()` - отримання всіх користувачів
- `updatePassword($id, $newPassword)` - оновлення пароля
- `delete($id)` - видалення користувача
- `exists($login)` - перевірка існування

### Playlist
Модель для роботи з плейлистами:
- `create($name, $userId, $description)` - створення плейлиста
- `findById($id)` - пошук за ID
- `getByUserId($userId)` - плейлисти користувача
- `getAll()` - всі плейлисти
- `update($id, $name, $description)` - оновлення
- `delete($id)` - видалення
- `addTrack($playlistId, $trackId)` - додавання треку
- `getTracks($playlistId)` - отримання треків плейлиста

### Track
Модель для роботи з треками:
- `create($name, $artistId, $duration, $album)` - створення треку
- `findById($id)` - пошук за ID
- `getAll()` - всі треки
- `getByArtistId($artistId)` - треки артиста
- `getTrending($limit)` - трендові треки
- `delete($id)` - видалення треку

### Artist
Модель для роботи з артистами:
- `create($name, $genre, $bio)` - створення артиста
- `findById($id)` - пошук за ID
- `getAll()` - всі артисти
- `getPopular($limit)` - популярні артисти
- `update($id, $name, $genre, $bio)` - оновлення
- `delete($id)` - видалення артиста

## Приклади використання

### Створення користувача
```php
require_once 'Models/User.php';

$result = User::create('john_doe', 'password123');
if ($result) {
    echo "Користувач створено!";
}
```

### Авторизація
```php
require_once 'Models/User.php';

$user = User::authenticate('john_doe', 'password123');
if ($user) {
    $_SESSION['user_id'] = $user['id'];
    echo "Авторизація успішна!";
}
```

### Створення плейлиста
```php
require_once 'Models/Playlist.php';

$playlistId = Playlist::create('My Favorites', $_SESSION['user_id'], 'Мій улюблений плейлист');
if ($playlistId) {
    echo "Плейлист створено з ID: $playlistId";
}
```

### Додавання треку до плейлиста
```php
require_once 'Models/Playlist.php';
require_once 'Models/Track.php';
require_once 'Models/Artist.php';

// Спочатку створюємо артиста
$artistId = Artist::create('Lady Gaga', 'Pop', 'Американська співачка');

// Потім створюємо трек
$trackId = Track::create('Poker Face', $artistId, 237, 'The Fame');

// Додаємо трек до плейлиста
Playlist::addTrack($playlistId, $trackId);
```

### Отримання трендових треків
```php
require_once 'Models/Track.php';

$trendingTracks = Track::getTrending(10);
foreach ($trendingTracks as $track) {
    echo $track['name'] . ' - ' . $track['artist_name'] . "\n";
}
```

### Отримання плейлистів користувача з треками
```php
require_once 'Models/Playlist.php';

$playlists = Playlist::getByUserId($_SESSION['user_id']);
foreach ($playlists as $playlist) {
    echo "Плейлист: " . $playlist['name'] . "\n";
    $tracks = Playlist::getTracks($playlist['id']);
    foreach ($tracks as $track) {
        echo "  - " . $track['name'] . " (" . $track['artist_name'] . ")\n";
    }
}
```

