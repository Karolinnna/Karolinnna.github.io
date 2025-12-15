<?php

/**
 * Клас Viewer для рендерингу шаблонів
 *
 * Відповідає за завантаження та рендеринг Latte шаблонів
 * з переданими даними.
 *
 * @package     kn24_php
 * @subpackage  Classes
 * @author      Karol
 * @version     1.0.0
 */
namespace Classes;

/**
 * Клас Viewer
 *
 * Надає статичні методи для рендерингу шаблонів
 */
class Viewer
{
    /**
     * Шлях до директорії з шаблонами
     */
    private static string $templateDir = __DIR__ . '/../templates/';

    /**
     * Рендерить шаблон з переданими даними
     *
     * @param string $templateName Ім'я шаблону (без розширення .latte)
     * @param array $data Масив даних для передачі в шаблон
     * @return void
     */
    public static function show(string $templateName, array $data = []): void
    {
        $templateFile = self::$templateDir . $templateName . '.latte';

        if (!file_exists($templateFile)) {
            die("Шаблон {$templateName}.latte не знайдено!");
        }

        // Завантажуємо вміст шаблону
        $templateContent = file_get_contents($templateFile);

        // Простий рендерер для заміни змінних
        $renderedContent = self::renderTemplate($templateContent, $data);

        // Виводимо результат
        echo $renderedContent;
    }

    /**
     * Простий рендерер шаблону
     *
     * Замінює {$variable} на значення з масиву даних
     * Підтримує базові конструкції Latte: {foreach}
     *
     * @param string $template Вміст шаблону
     * @param array $data Масив даних
     * @return string Рендерений HTML
     */
    private static function renderTemplate(string $template, array $data): string
    {
        // Спочатку обробляємо foreach цикли
        $template = self::processForeach($template, $data);

        // Потім замінюємо прості змінні
        foreach ($data as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                $template = str_replace('{$' . $key . '}', htmlspecialchars($value), $template);
            } elseif (is_array($value)) {
                // Для масивів - залишаємо як є, вони вже оброблені в processForeach
            }
        }

        return $template;
    }

    /**
     * Обробляє foreach цикли в шаблоні
     *
     * @param string $template Вміст шаблону
     * @param array $data Масив даних
     * @return string Шаблон з обробленими циклами
     */
    private static function processForeach(string $template, array $data): string
    {
        // Регулярний вираз для пошуку foreach циклів
        $pattern = '/\{foreach\s+\$([a-zA-Z_][a-zA-Z0-9_]*)\s+as\s+\$([a-zA-Z_][a-zA-Z0-9_]*)\}(.*?)\{\/foreach\}/s';

        $template = preg_replace_callback($pattern, function($matches) use ($data) {
            $arrayName = $matches[1];
            $itemName = $matches[2];
            $loopContent = $matches[3];

            if (!isset($data[$arrayName]) || !is_array($data[$arrayName])) {
                return ''; // Якщо масив не знайдено, повертаємо порожній рядок
            }

            $result = '';
            foreach ($data[$arrayName] as $item) {
                $itemContent = str_replace('{$' . $itemName . '}', htmlspecialchars($item), $loopContent);
                $result .= $itemContent;
            }

            return $result;
        }, $template);

        return $template;
    }
}
