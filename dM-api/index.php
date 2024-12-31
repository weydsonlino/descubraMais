<?php
session_start();
require_once 'core/Router.php';

// Inicializa as rotas
$router = new Router();

// Inclui as rotas definidas
require_once 'routes/api.php';

// Processa a requisição
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

echo json_encode([
    'status' => 'success',
    'message' => 'API is working! hable',
    'session' => $_SESSION['user_id']
]);
?>
