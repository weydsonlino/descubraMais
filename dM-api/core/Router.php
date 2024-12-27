<?php

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $action)
    {
        $this->routes[] = compact('method', 'path', 'action');
    }

    public function dispatch($requestMethod, $requestUri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                list($controller, $method) = explode('@', $route['action']);
                require_once "app/controllers/$controller.php";
                $controllerInstance = new $controller();
                $controllerInstance->$method();
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }
}
?>