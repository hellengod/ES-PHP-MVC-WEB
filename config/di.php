<?php

use Alura\Mvc\Repository\VideoRepository;
use DI\ContainerBuilder;
use League\Plates\Engine;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    PDO::class => function (): PDO {
        $dbPath = __DIR__ . '/../banco.sqlite';
        return new PDO("sqlite:$dbPath");
    },
    Engine::class => function(){
        $templatesPath = __DIR__ . '/../View';
        return new Engine($templatesPath);
    }
]);

$container = $builder->build();


return $container;