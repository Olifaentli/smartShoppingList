<?php


require_once __DIR__ . '/vendor/autoload.php';
session_start();

use App\Repo\UserRepo;
use App\Utils\Config;
use App\Utils\Container;

$container = new Container();
$controllerName = $_GET['controller'] ?? Config::DEFAULT_CONTROLLER;
$controller = $container->getController($controllerName);
$action = $_GET['action'] ?? Config::DEFAULT_ACTION_REGISTER;
$authRequired = !in_array($controllerName, Config::PUBLIC_CONTROLLERS);


if ($authRequired) {
    $userRepo = $container->getRepo('user');
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        header('Location: index.php?controller=login&action=template');
        exit;
    }
    $user = $userRepo->getUserById($userId);
    if (!$user) {
        session_unset();
        session_destroy();
        header('Location: index.php?controller=login&action=template');
        exit;
    }
}

if (
    ($controllerName === 'login' || $controllerName === 'register') &&
    $action != 'logout' &&
    ($authRequired === false) &&
    isset($_SESSION['user_id'])
) {
    header('Location: index.php?controller=list&action=template');
    exit;
}


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

    if ($controllerName === 'login' && ($_GET['action'] ?? '') === 'logout') {
        $controller->logout();
        exit;
    }

    $controller->template();

} elseif ($method === 'POST') {
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
