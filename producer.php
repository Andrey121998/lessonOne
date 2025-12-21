<?php
require 'vendor/autoload.php';

use Predis\Client;

echo "Redis Producer started...\n";

// Подключение к Redis
$redis = new Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);

// Имя очереди
$queueName = 'manual_queue';

// Отправляем 5 сообщений
for ($i = 1; $i <= 5; $i++) {
    $message = [
        'id' => $i,
        'text' => "Сообщение #$i",
        'time' => date('H:i:s')
    ];
    
    $redis->rpush($queueName, json_encode($message));
    echo "Отправлено: {$message['text']}\n";
    sleep(1);
}

echo "Все сообщения отправлены в очередь '$queueName'\n";