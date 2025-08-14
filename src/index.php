<?php


require_once __DIR__ . '/vendor/autoload.php';

use App\Utils\Config;
use App\Utils\Container;

$container = new Container();
$controllerName = $_GET['controller'] ?? Config::DEFAULT_CONTROLLER;
$controller = $container->getController($controllerName);

if (!$controller) {
    http_response_code(404);
    exit('Controller not found');
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (!method_exists($controller, 'template')) {
        http_response_code(404);
        exit('Template method not found');
    }
    $controller->template();

} elseif ($method === 'POST') {
    $action = $_GET['action'] ?? Config::DEFAULT_ACTION_REGISTER;
    if (!method_exists($controller, $action)) {
        http_response_code(404);
        exit('Action not found');
    }
    $controller->$action();

} else {
    http_response_code(405);
    header('Allow: GET, POST');
    echo "HTTP method $method not supported.";
}
