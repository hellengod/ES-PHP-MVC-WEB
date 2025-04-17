<?php

use Alura\Mvc\Repository\VideoRepository;
use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $dbPath = __DIR__ . '/../banco.sqlite';
        return new PDO("sqlite:$dbPath");
    },
]);

$container = $builder->build();


return $container;