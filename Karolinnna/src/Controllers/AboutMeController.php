<?php
/**
 * Файл контролера AboutMeController
 *
 * Контролер для сторінки "Про мене". Відповідає за відображення
 * інформації про розробника, сайт та навички.
 *
 * @package     Karolinnna.github.io
 * @subpackage  Controllers
 * @author      Karol
 * @version     1.0.0
 */
namespace Classes;
use Classes\Viewer;
/**
 * Клас AboutMeController
 *
 * Обробляє логіку для сторінки "Про мене".
 * Передає дані про розробника в шаблон через клас Viewer.
 */
class AboutMeController
{
    /** @var string Ім'я розробника */
    private string $name = "Karol";
    /** @var string Професія */
    private string $profession = "Розробник веб-додатків";
    /** @var string Опис діяльності */
    private string $description = "Створюю сучасні веб-додатки";
    /** @var array Список навичок розробника */
    private array $skills = [
        'PHP',
        'HTML/CSS',
        'JavaScript',
        'MySQL/SQLite',
        'Git'
    ];
    /**
     * Метод index
     *
     * Основний метод контролера, який викликається роутером.
     * Збирає дані про розробника та повертає їх для передачі в шаблон.
     *
     * @return array Масив даних для передачі в шаблон
     */
    public function index(): array
    {
        // Збираємо всі дані для передачі в шаблон
        return [
            'title'     => 'Про мене',
            'myName'    => $this->name,
            'myProfession' => $this->profession,
            'myDescription' => $this->description,
            'skills'    => $this->skills
        ];
    }
    /**
     * Отримує ім'я розробника
     *
     * @return string Ім'я розробника
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * Отримує професію
     *
     * @return string Професія розробника
     */
    public function getProfession(): string
    {
        return $this->profession;
    }
    /**
     * Отримує опис діяльності
     *
     * @return string Опис діяльності
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    /**
     * Отримує список навичок
     *
     * @return array Масив навичок розробника
     */
    public function getSkills(): array
    {
        return $this->skills;
    }
}
