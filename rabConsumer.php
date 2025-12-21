<?php
require_once 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

echo "RabbitMQ Consumer started...\n";

try {
    // Подключение
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    
    // Объявляем очередь (такая же как у producer)
    $queueName = 'task_queue';
    $channel->queue_declare($queueName, false, true, false, false);
    
    echo " [*] Ожидание сообщений из '$queueName'. Для выхода Ctrl+C\n";
    
    // Функция-обработчик сообщений
    $callback = function ($msg) {
        $logMessage = " [x] Получено: " . $msg->body . "\n";
        echo $logMessage;
        
        // Пишем в лог-файл
        file_put_contents('rabbitmq.log', date('Y-m-d H:i:s') . $logMessage, FILE_APPEND);
        
        // Имитация обработки
        sleep(rand(1, 3));
        
        // Подтверждаем обработку
        $msg->ack();
    };
    
    // Настраиваем consumer
    $channel->basic_qos(null, 1, null); // По одному сообщению за раз
    $channel->basic_consume($queueName, '', false, false, false, false, $callback);
    
    // Бесконечный цикл ожидания
    while ($channel->is_consuming()) {
        $channel->wait();
    }
    
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}