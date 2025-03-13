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
        // Remove query params da URL (deixa apenas o caminho)
        $pathOnly = parse_url($requestUri, PHP_URL_PATH);

        // Recupera os query parameters (como ?id=1)
        $queryParams = [];
        parse_str(parse_url($requestUri, PHP_URL_QUERY), $queryParams);

        foreach ($this->routes as $route) {
            // Cria um padrão regex para a rota
            $pattern = "@^" . $route['path'] . "$@";

            // Verifica se o método HTTP e a rota correspondem
            if ($route['method'] === $requestMethod && preg_match($pattern, $pathOnly, $matches)) {
                // Captura apenas os parâmetros nomeados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Se o parâmetro id não for encontrado na URL (como parte da rota), tenta pegar do query string
                if (empty($params['id']) && isset($queryParams['id'])) {
                    $params['id'] = $queryParams['id'];
                }

                // Inclui os query parameters como parte dos parâmetros
                $params = array_merge($params, $queryParams); // Mescla query params com parâmetros de rota

                // Carrega o controlador e chama o método, passando os parâmetros
                list($controller, $method) = explode('@', $route['action']);
                require_once "app/controllers/$controller.php";
                $controllerInstance = new $controller();
                return call_user_func_array([$controllerInstance, $method], [$params]); // Passando os parâmetros para o controlador
            }
        }

        // Caso nenhuma rota seja encontrada
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }
}
