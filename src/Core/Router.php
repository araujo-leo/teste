<?php

namespace App\Core;
use App\Controller\ErrorController;

class Router
{
    private array $routes = [];

    public function get(string $path, array $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, array $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function put(string $path, array $callback): void
    {
        $this->routes['PUT'][$path] = $callback;
    }

    public function delete(string $path, array $callback): void
    {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        try {
            if (isset($this->routes[$method])) {
                foreach ($this->routes[$method] as $route => $callback) {

                    $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
                    $pattern = "#^" . $pattern . "$#";

                    if (preg_match($pattern, $uri, $matches)) {
                        array_shift($matches);

                        if ($callback instanceof \Closure) {
                            echo call_user_func_array($callback, $matches);
                            return;
                        }

                        if (is_array($callback)) {
                            [$controllerClass, $action] = $callback;

                            if (class_exists($controllerClass)) {
                                $controller = new $controllerClass();

                                if (method_exists($controller, $action)) {
                                    echo $controller->$action(...$matches);
                                    return;
                                }
                            }
                        }
                    }
                }
            }

            $errorController = new ErrorController();
            echo $errorController->notFound();

        } catch (\Throwable $e) {
            $errorController = new ErrorController();
            echo $errorController->internalServerError($e);
        }
    }
}