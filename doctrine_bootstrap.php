<?php

require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/App/Entities'],
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'host' => '127.127.126.50',
    'dbname' => 'Study_db',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8',
], $config);

$entityManager = new EntityManager($connection, $config);

echo "Doctrine ORM подключен успешно!<br>". '<br>';