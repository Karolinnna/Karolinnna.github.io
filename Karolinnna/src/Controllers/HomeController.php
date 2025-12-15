<?php
/**
 * Файл контролера HomeController
 *
 * Контролер для головної сторінки сайту.
 * Відповідає за відображення головної сторінки з музикою та плейлістами.
 *
 * @package     Karolinnna.github.io
 * @subpackage  Controllers
 * @author      Karol
 * @version     1.0.0
 */
namespace Classes;

/**
 * Клас HomeController
 *
 * Обробляє логіку для головної сторінки.
 * Повертає дані для відображення музичного контенту.
 */
class HomeController
{
    /**
     * Метод index
     *
     * Основний метод контролера, який викликається для головної сторінки.
     * Повертає дані про користувача та основний контент сторінки.
     *
     * @return array Масив даних для передачі в шаблон
     */
    public function index(): array
    {
        // Дані про користувача
        $userGreeting = isset($_SESSION['login'])
            ? "Привіт, " . $_SESSION['login']
            : "Привіт, КОРИСТУВАЧ НЕ АВТОРИЗОВАНИЙ";

        // Основні дані для головної сторінки
        return [
            'title' => 'ГОЛОВНА',
            'userGreeting' => $userGreeting,
            'isLoggedIn' => isset($_SESSION['login']),
            'userInitial' => isset($_SESSION['login']) ? $_SESSION['login'][0] : ''
        ];
    }
}
