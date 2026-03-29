<?php
/**
 * Файл контролера LoginController
 *
 * Контролер для сторінки авторизації.
 * Відповідає за обробку форми входу та відображення сторінки логіну.
 *
 * @package     Karolinnna.github.io
 * @subpackage  Controllers
 * @author      Karol
 * @version     1.0.0
 */
namespace Classes;

/**
 * Клас LoginController
 *
 * Обробляє логіку авторизації користувачів.
 * Повертає дані для відображення форми входу.
 */
class LoginController
{
    /**
     * Метод index
     *
     * Основний метод контролера, який викликається для сторінки входу.
     * Обробляє дані форми та повертає інформацію для шаблону.
     *
     * @return array Масив даних для передачі в шаблон
     */
    public function index(): array
    {
        // Опрацьовуємо нашу форму
        $login = '';
        $password = '';

        // Перевіряємо, що запит дійсно POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Отримуємо значення змінних
            $login = trim($_POST['login'] ?? '');
            $password = trim($_POST['password'] ?? '');
        }

        // Перевіряємо, чи є повідомлення про помилку в сесії
        $errorMessage = null;
        if (isset($_SESSION['error_message'])) {
            $errorMessage = $_SESSION['error_message'];
            unset($_SESSION['error_message']); // Видаляємо повідомлення, щоб не показувати його знову
        }

        return [
            'title' => 'АВТОРИЗАЦІЯ',
            'login' => $login,
            'password' => $password,
            'errorMessage' => $errorMessage
        ];
    }
}
