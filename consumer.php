<?php
require 'vendor/autoload.php';

use Predis\Client;

echo "Redis Consumer started...\n";

// Подключение к Redis
$redis = new Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379,
]);

// Имя очереди
$queueName = 'manual_queue';

// Файл для логов
$logFile = 'redis_manual.log';

echo "Ожидание сообщений из очереди '$queueName'...\n";
echo "Для выхода нажми Ctrl+C\n";

// Бесконечный цикл обработки
while (true) {
    // Блокирующее чтение (ждём 5 секунд)
    $result = $redis->blpop([$queueName], 5);
    
    if ($result) {
        $message = json_decode($result[1], true);
        
        // Логируем
        $logMessage = date('Y-m-d H:i:s') . " - Получено: {$message['text']} (ID: {$message['id']})\n";
        file_put_contents($logFile, $logMessage, FILE_APPEND);
        
        echo $logMessage;
        
        // Имитация обработки
        sleep(rand(1, 3));
    } else {
        echo date('H:i:s') . " - Сообщений нет, ожидание...\n";
    }
}