<?php

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $action)
    {
        // Armazena as rotas, convertendo {param} em um padrão de regex
        $path = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $path);
        $this->routes[] = compact('method', 'path', 'action');
    }

    public function dispatch($requestMethod, $requestUri)
    {
        foreach ($this->routes as $route) {
            // Constrói um padrão regex para a rota
            $pattern = "@^" . $route['path'] . "$@";

            if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                // Remove os índices numéricos capturados pela regex
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Carrega o controlador e chama o método, passando os parâmetros
                list($controller, $method) = explode('@', $route['action']);
                require_once "app/controllers/$controller.php";
                $controllerInstance = new $controller();
                return call_user_func_array([$controllerInstance, $method], $params);
            }
        }

        // Caso nenhuma rota seja encontrada
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }
}
