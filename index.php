<?php

use Dotenv\Dotenv;
use App\Core\Router;

define('START_TIME', microtime(true));

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if ($_ENV['APP_DEBUG'] ?? false) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$router = new Router();

require __DIR__ . '/src/routes/web.php';
require __DIR__ . '/src/routes/api.php';

$router->dispatch();