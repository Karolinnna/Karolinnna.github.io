<?php
require_once __DIR__ . '/vendor/autoload.php';
//whoops
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// Створюємо Whoops
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();


echo $undefined_variable;
//monolog
// Підключаємо автозавантаження Composer


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

// Створюємо логер з ім’ям "my_app"
$log = new Logger('my_app');

// Додаємо хендлер, який пише всі Warning та Error у файл "app.log" у тій же папці
$log->pushHandler(new StreamHandler(__DIR__ . '/app.log', Level::Warning));

// Записуємо тестові повідомлення
$log->warning('Це тестове попередження');
$log->error('Це тестова помилка');

// Виводимо повідомлення на екран, щоб точно бачити, що скрипт працює
//echo "Тестові логи записані в app.log\n";

//vardumper
$data = [
[
    'title' => 'bla',
    'e' => 'blablabla'
],
[
    'title' => 'blu',
    'e' => 'blublublu'
],
[
    'title' => 'AAAAAAAAAA',
    'e' => 'aaaaaaa'
]
];
echo "dump:";
dump($data);
echo "final\n";
echo 'dd:';
dd($data);
echo "final";

