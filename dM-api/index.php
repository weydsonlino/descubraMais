<?php

$allowedOrigins = [
    "http://localhost:5173",
    "http://127.0.0.1:5173"
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
}

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

session_start();
require_once 'core/Router.php';

// Inicializa as rotas
$router = new Router();

// Inclui as rotas definidas
require_once 'routes/api.php';

// Processa a requisição
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

json_encode([
    'status' => 'success',
    'message' => 'API is working! hable',
    'session' => $_SESSION['user_id']
]);
?>