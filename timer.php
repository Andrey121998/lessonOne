<?php

use React\EventLoop\Loop;

require 'vendor/autoload.php';

echo " Асинхронный таймер запущен\n";
echo "Каждые 5 секунд будет выводиться сообщение\n";
echo "Программа остановится через 25 секунд\n\n";

$loop = Loop::get();
$counter = 0;

// Основной таймер из задания - каждые 5 секунд
$loop->addPeriodicTimer(5, function () use (&$counter) {
    $counter++;
    echo "[" . date('H:i:s') . "] Сообщение #{$counter}: Таймер сработал (каждые 5 секунд)\n";
});

// Автоматическая остановка через 25 секунд
$loop->addTimer(25, function () use ($loop) {
    echo "\n Программа завершена через 25 секунд\n";
    $loop->stop();
});

echo "Таймер работает...\n";

$loop->run();

echo " Задание выполнено!\n";