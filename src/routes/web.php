<?php
use App\Core\Router;

use App\Controller\AuthController;
use App\Controller\ProductController;
use App\Controller\SupplierController;
use App\Controller\ProductSupplierController;
use App\Middleware\WebAuthMiddleware;

$router->get('/login', [AuthController::class, 'loginPage']);
$router->get('/register', [AuthController::class, 'registerPage']);

$router->get('/', [ProductController::class, 'productsPage'], [WebAuthMiddleware::class]);
$router->get('/products', [ProductController::class, 'productsPage'], [WebAuthMiddleware::class]);
$router->get('/suppliers', [SupplierController::class, 'suppliersPage'], [WebAuthMiddleware::class]);
$router->get('/links', [ProductSupplierController::class, 'linksPage'], [WebAuthMiddleware::class]);





