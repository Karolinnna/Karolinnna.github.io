<?php
/**
 * AboutMeController
 *
 * Контролер підготовлює дані для сторінки /aboutme і підключає шаблон Pages/aboutme.php.
 *
 * Використовується простий підхід: якщо користувач авторизований (session або cookie 'login'),
 * контролер спробує підвантажити додаткові поля з mydatabase.db (таблиця User).
 *
 * Докблоки оформлені відповідно до phpDocumentor / phpDoc: https://docs.phpdoc.org/
 *
 * @package App\Controllers
 */
class AboutMeController
{
    /**
     * Показує сторінку About Me.
     *
     * Логіка:
     *  - перевіряє авторизацію;
     *  - якщо авторизований — читає name, bio, skills з таблиці User (якщо є);
     *  - формує змінні $name, $bio, $skills, $isAuthenticated і підключає шаблон.
     *
     * @return void Підключає шаблон Pages/aboutme.php
     */
    public function index(): void
    {
        // Не запускаємо повторно сесію, якщо вона вже запущена.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $isAuthenticated = isset($_SESSION['login']) || isset($_COOKIE['login']);

        // Значення за замовчуванням
        $name = "Ім'я Прізвище";
        $bio = "Короткий опис: студент/розробник, цікавлюся PHP та веб-розробкою.";
        $skills = ['PHP', 'SQLite', 'HTML', 'CSS', 'JavaScript'];

        if ($isAuthenticated) {
            $login = $_SESSION['login'] ?? $_COOKIE['login'] ?? null;
            if ($login) {
                try {
                    // Відносний шлях до БД — у корені проєкту
                    $dbPath = __DIR__ . '/../mydatabase.db';
                    $pdo = new PDO('sqlite:' . $dbPath);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Пошук користувача; очікувані поля: name, bio, skills (skills як "a,b,c")
                    $sql = "SELECT name, bio, skills FROM User WHERE login = :login LIMIT 1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':login' => $login]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row) {
                        if (!empty($row['name'])) $name = $row['name'];
                        if (!empty($row['bio'])) $bio = $row['bio'];
                        if (!empty($row['skills'])) {
                            // Розбираємо рядок навичок у масив
                            $skills = array_map('trim', explode(',', $row['skills']));
                        }
                    }
                } catch (PDOException $e) {
                    // Лог помилки — не показуємо користувачу повний текст помилки в UI
                    error_log('AboutMeController DB error: ' . $e->getMessage());
                }
            }
        }

        // Змінні, які очікує шаблон
        $isAuthenticated = (bool)$isAuthenticated;
        // Підключаємо шаблон (шлях до Pages)
        require __DIR__ . '/../Pages/aboutme.php';
    }
}
