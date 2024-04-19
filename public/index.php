<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Src\DependencyInjection\Container;
use Src\Routing\Router;
use Src\Infrastructure\SQLiteContactRepository;
use Src\Controller\ContactCommandController;
use Src\Controller\ContactQueryController;

$container = new Container();

$db = new PDO('sqlite:' . dirname(__DIR__) . '/db/database.sqlite');
$contactRepository = new SQLiteContactRepository($db);

$container->set(ContactCommandController::class, new ContactCommandController($contactRepository));
$container->set(ContactQueryController::class, new ContactQueryController($contactRepository));

$router = new Router($container);
$router->register('GET', '/', ContactQueryController::class, 'index');
$router->register('POST', '/', ContactQueryController::class, 'index');
$router->register('GET', '/add', ContactQueryController::class, 'showAddForm');
$router->register('POST', '/add', ContactCommandController::class, 'add');
$router->register('POST', '/delete', ContactCommandController::class, 'delete');

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->route($method, $path);
} catch (\Exception $e) {
    echo $e->getMessage();
}