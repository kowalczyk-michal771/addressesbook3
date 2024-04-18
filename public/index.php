<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Infrastructure\SQLiteContactRepository;
use Src\Controller\ContactController;

$db = new PDO('sqlite:' . dirname(__DIR__) . '/db/database.sqlite');
$repository = new SQLiteContactRepository($db);
$contactController = new ContactController($repository);

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Simple routing
switch ($path) {
    case '/':
        if ($method == 'POST') {
            $contactController->index($_POST);
        } else {
            $contactController->index();
        }
        break;
    case '/add':
        if ($method == 'POST') {
            $contactController->add($_POST);
        } else {
            $contactController->showAddForm();
        }
        break;
    case '/delete':
        if ($method == 'POST') {
            $contactController->delete($_POST['id']);
        }
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page not found.";
        break;
}