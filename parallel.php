<?php
declare(strict_types=1);

use React\Http\Browser;
use React\EventLoop\Loop;
use React\Promise;

require 'vendor/autoload.php';

echo "Запуск нескольких параллельных HTTP запросов...\n\n";

$browser = new Browser();
$loop = Loop::get();

// Массив URL для параллельных запросов
$urls = [
    'https://jsonplaceholder.typicode.com/posts/1',
    'https://jsonplaceholder.typicode.com/posts/2', 
    'https://jsonplaceholder.typicode.com/posts/3',
    'https://jsonplaceholder.typicode.com/users/1',
    'https://jsonplaceholder.typicode.com/comments/1'
];

$startTime = microtime(true);
$promises = [];

// Создаем промисы для каждого запроса
foreach ($urls as $index => $url) {
    $promise = $browser->get($url)
        ->then(
            function (Psr\Http\Message\ResponseInterface $response) use ($index, $url) {
                $body = (string) $response->getBody(); // Преобразуем StreamInterface в string
                $data = json_decode($body, true);
                
                // Определяем тип данных
                if (isset($data['title'])) {
                    $info = "Пост: " . substr($data['title'], 0, 20) . "...";
                } elseif (isset($data['name'])) {
                    $info = "Пользователь: " . $data['name'];
                } elseif (isset($data['body'])) {
                    $info = "Комментарий: " . substr($data['body'], 0, 20) . "...";
                } else {
                    $info = "Данные";
                }
                
                return [
                    'success' => true,
                    'index' => $index + 1,
                    'url' => $url,
                    'info' => $info
                ];
            },
            function (Exception $e) use ($index, $url) {
                return [
                    'success' => false,
                    'index' => $index + 1,
                    'url' => $url,
                    'error' => $e->getMessage()
                ];
            }
        );
    
    $promises[] = $promise;
}

// Ждем завершения всех промисов
Promise\all($promises)->then(function ($results) use ($startTime) {
    echo "\n========================================\n";
    echo "Результаты параллельных запросов:\n\n";
    
    $successCount = 0;
    foreach ($results as $result) {
        if ($result['success']) {
            echo "Запрос #{$result['index']}: {$result['info']}\n";
            $successCount++;
        } else {
            echo "Запрос #{$result['index']}: Ошибка - {$result['error']}\n";
        }
    }
    
    $totalTime = microtime(true) - $startTime;
    echo "\n========================================\n";
    echo "Все запросы завершены!\n";
    echo "Успешных запросов: {$successCount} из " . count($results) . "\n";
    echo "Общее время выполнения: " . round($totalTime, 2) . " секунд\n";
    echo "Запросы выполнялись параллельно!\n";
});

echo "Запросы выполняются в фоновом режиме...\n";
echo "Ожидаем результаты...\n\n";

$loop->run();