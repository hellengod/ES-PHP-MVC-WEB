<?php

declare(strict_types=1);
use Alura\Mvc\Controller\DeleteVideoController;
use Alura\Mvc\Controller\EditVideoController;
use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Controller\NewVideoController;
use Alura\Mvc\Controller\VideoFormController;
use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Controller\LoginController;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$videoRepository = new VideoRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpmethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpmethod|$pathInfo";
if(array_key_exists($key, $routes)){
$controllerClass = $routes["$httpmethod|$pathInfo"];
$controller = new $controllerClass($videoRepository);
}else{
    $controller = new Error404Controller;
}
$controller->processaRequisicao();