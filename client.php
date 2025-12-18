<?php 
declare(strict_types=1);

use React\Http\Browser;
use React\EventLoop\Loop;


require 'vendor/autoload.php';

$browser = new Browser();

echo "Начинаем асинхронный HTTP запрос...\n";

// Делаем асинхронный GET-запрос
$browser->get('https://jsonplaceholder.typicode.com/posts/1')
    ->then(function (Psr\Http\Message\ResponseInterface $response) {
        $body = (string) $response->getBody(); // Преобразуем StreamInterface в string
        $data = json_decode($body, true);
        echo "Запрос выполнен успешно!\n";
        echo "ID: " . $data['id'] . "\n";
        echo "Заголовок: " . $data['title'] . "\n";
        echo "Текст: " . substr($data['body'], 0, 50) . "...\n";
    })
    ->otherwise(function (Exception $e) {
        echo " Ошибка при выполнении запроса: " . $e->getMessage() . "\n";
    });

echo "Запрос отправлен, ждем ответа...\n";
echo "Это сообщение выводится ДО получения ответа!\n";

// Нужно запустить event loop для выполнения асинхронных операций
Loop::get()->run();