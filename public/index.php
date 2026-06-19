<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

session_start();

require __DIR__ . '/../app/Core/helper.php';
require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Core/DuplicateRecordException.php';
require __DIR__ . '/../app/Repositories/BookRepository.php';
require __DIR__ . '/../app/Repositories/OrderRepository.php';
require __DIR__ . '/../app/Controllers/HomeController.php';
require __DIR__ . '/../app/Controllers/HealthController.php';
require __DIR__ . '/../app/Controllers/BookController.php';
require __DIR__ . '/../app/Controllers/OrderController.php';

$router = new Router();

// Home & Health
$router->get('/', [HomeController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);

// Book routes
$router->get('/books', ['BookController', 'index']);
$router->get('/books/create', ['BookController', 'create']);
$router->post('/books/store', ['BookController', 'store']);
$router->get('/books/edit', ['BookController', 'edit']);
$router->post('/books/update', ['BookController', 'update']);
$router->post('/books/delete', ['BookController', 'delete']);

// Order routes
$router->get('/orders', ['OrderController', 'index']);
$router->get('/orders/create', ['OrderController', 'create']);
$router->post('/orders/store', ['OrderController', 'store']);
$router->get('/orders/edit', ['OrderController', 'edit']);
$router->post('/orders/update', ['OrderController', 'update']);
$router->post('/orders/delete', ['OrderController', 'delete']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);