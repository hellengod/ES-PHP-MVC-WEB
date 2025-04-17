<?php

declare(strict_types=1);

use Alura\Mvc\Controller\Error404Controller;


require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/routes.php';
/** @var \Psr\Container\ContainerInterface $dependencyContainer */
$dependencyContainer = require_once __DIR__ . '/../config/di.php';
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpmethod = $_SERVER['REQUEST_METHOD'];

session_start();
session_regenerate_id();
$isLoginRoute = $pathInfo === '/login';
if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute) {
    header('Location: /login');
    return;
}

$key = "$httpmethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpmethod|$pathInfo"];
    $controller = $dependencyContainer->get($controllerClass);
} else {
    $controller = new Error404Controller;
}

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

$response = $controller->handle($request);

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $response->getBody();