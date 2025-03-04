<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class Controller
{
    protected static $secret_key = 'Sdw1s';
    protected function getRequestBody()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    protected function respond($data, $statusCode)
    {
        http_response_code($statusCode);
        echo json_encode($data);
    }
    public static function checkSession()
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        if (!$authHeader) {
            return ["error" => "Token não fornecido"];
        }

        $token = str_replace("Bearer ", "", $authHeader);

        try {
            $decoded = JWT::decode($token, new Key(self::$secret_key, 'HS256'));
            return ["message" => "Acesso autorizado", "user" => $decoded->data];
        } catch (Exception $e) {
            http_response_code(401);
            return ["message" => "Token inválido", "error" => $e->getMessage()];
        }
    }
}
?>