<?php
require_once 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

echo "RabbitMQ Producer started...\n";

try {
    // Подключение к RabbitMQ
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    
    // Объявляем очередь (создаём если нет)
    $queueName = 'task_queue';
    $channel->queue_declare($queueName, false, true, false, false);
    
    // Отправляем 3 сообщения
    for ($i = 1; $i <= 3; $i++) {
        $messageText = "Задача #$i от " . date('H:i:s');
        $message = new AMQPMessage(
            $messageText,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );
        
        $channel->basic_publish($message, '', $queueName);
        echo " [x] Отправлено: '$messageText'\n";
        
        sleep(1);
    }
    
    // Закрываем соединение
    $channel->close();
    $connection->close();
    
    echo "Все сообщения отправлены в очередь '$queueName'\n";
    
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
    echo "Убедись что RabbitMQ запущен (localhost:5672)\n";
}