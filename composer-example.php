<?php
/**
 * Приклад використання пакетів з Composer
 * 
 * Пакети:
 * 1. Monolog - для логування
 * 2. Symfony VarDumper - для красивого виведення змінних
 * 3. Carbon - для роботи з датами та часом
 */

// Підключення автозавантаження Composer
require_once __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Symfony\Component\VarDumper\VarDumper;
use Carbon\Carbon;

echo "<h1>Приклади використання Composer пакетів</h1>";

// ============================================
// 1. MONOLOG - Логування
// ============================================
echo "<h2>1. Monolog - Логування</h2>";

// Створюємо логер
$logger = new Logger('my_logger');

// Додаємо обробники (handlers)
$logger->pushHandler(new StreamHandler(__DIR__ . '/logs/app.log', Logger::DEBUG));
$logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
$logger->pushHandler(new FirePHPHandler());

// Приклади логування
$logger->info('Додаток запущено');
$logger->warning('Це попередження');
$logger->error('Це помилка');
$logger->debug('Детальна інформація для розробки');

// Логування з контекстом
$logger->info('Користувач увійшов в систему', [
    'user_id' => 123,
    'ip' => '192.168.1.1',
    'timestamp' => time()
]);

echo "<p>✅ Логи записані в файл <code>logs/app.log</code> та виведені в консоль</p>";

// ============================================
// 2. SYMFONY VAR DUMPER - Красиве виведення
// ============================================
echo "<h2>2. Symfony VarDumper - Красиве виведення змінних</h2>";

// Створюємо тестові дані
$array = [
    'name' => 'Karolinnna',
    'age' => 25,
    'skills' => ['PHP', 'JavaScript', 'HTML', 'CSS'],
    'nested' => [
        'level1' => [
            'level2' => 'Глибоко вкладена структура'
        ]
    ]
];

$object = new stdClass();
$object->id = 1;
$object->title = 'Тестовий об\'єкт';
$object->data = $array;

echo "<h3>Виведення масиву:</h3>";
dump($array);

echo "<h3>Виведення об'єкта:</h3>";
VarDumper::dump($object);

echo "<h3>Виведення з додатковим контекстом:</h3>";
dump([
    'request' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
    'timestamp' => date('Y-m-d H:i:s'),
    'data' => $array
]);

// ============================================
// 3. CARBON - Робота з датами
// ============================================
echo "<h2>3. Carbon - Робота з датами та часом</h2>";

// Поточна дата та час
$now = Carbon::now();
echo "<p><strong>Поточна дата:</strong> " . $now->format('d.m.Y H:i:s') . "</p>";

// Конкретна дата
$birthday = Carbon::create(2000, 5, 15, 14, 30, 0);
echo "<p><strong>Конкретна дата:</strong> " . $birthday->format('d.m.Y H:i') . "</p>";

// Парсинг рядка
$parsed = Carbon::parse('2024-12-25 10:00:00');
echo "<p><strong>Парсинг рядка:</strong> " . $parsed->format('d.m.Y H:i') . "</p>";

// Форматування
echo "<p><strong>Різні формати:</strong></p>";
echo "<ul>";
echo "<li>ISO: " . $now->toIso8601String() . "</li>";
echo "<li>RFC: " . $now->toRfc2822String() . "</li>";
echo "<li>Українська: " . $now->locale('uk')->isoFormat('dddd, D MMMM YYYY, HH:mm') . "</li>";
echo "</ul>";

// Математика з датами
$future = $now->copy()->addDays(30)->addHours(5);
echo "<p><strong>Через 30 днів та 5 годин:</strong> " . $future->format('d.m.Y H:i') . "</p>";

$past = $now->copy()->subMonths(2)->subWeeks(1);
echo "<p><strong>2 місяці та 1 тиждень тому:</strong> " . $past->format('d.m.Y') . "</p>";

// Різниця між датами
$diff = $now->diffInDays($birthday);
echo "<p><strong>Днів з дня народження:</strong> " . number_format($diff, 0, ',', ' ') . " днів</p>";

$diffHuman = $now->diffForHumans($birthday);
echo "<p><strong>Відносно поточної дати:</strong> " . $diffHuman . "</p>";

// Перевірки
echo "<p><strong>Перевірки:</strong></p>";
echo "<ul>";
echo "<li>Чи сьогодні понеділок? " . ($now->isMonday() ? 'Так' : 'Ні') . "</li>";
echo "<li>Чи це вихідний? " . ($now->isWeekend() ? 'Так' : 'Ні') . "</li>";
echo "<li>Чи це в минулому? " . ($past->isPast() ? 'Так' : 'Ні') . "</li>";
echo "<li>Чи це в майбутньому? " . ($future->isFuture() ? 'Так' : 'Ні') . "</li>";
echo "</ul>";

// ============================================
// Комбінований приклад
// ============================================
echo "<h2>4. Комбінований приклад</h2>";

$logger->info('Початок обробки даних', ['timestamp' => $now->toIso8601String()]);

$userData = [
    'name' => 'Karolinnna',
    'created_at' => Carbon::now()->subYears(2)->toDateTimeString(),
    'last_login' => Carbon::now()->subHours(3)->toDateTimeString(),
    'account_age' => Carbon::now()->subYears(2)->diffForHumans(),
    'next_birthday' => Carbon::create(null, 5, 15)->isPast() 
        ? Carbon::create(null, 5, 15)->addYear()->format('d.m.Y')
        : Carbon::create(null, 5, 15)->format('d.m.Y')
];

echo "<h3>Дані користувача:</h3>";
dump($userData);

$logger->info('Дані користувача оброблено', [
    'user' => $userData['name'],
    'account_age' => $userData['account_age']
]);

echo "<p>✅ Всі пакети успішно використані!</p>";
echo "<p>📝 Перевірте файл <code>logs/app.log</code> для перегляду логів</p>";

