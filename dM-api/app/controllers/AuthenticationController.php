<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthenticationController extends Controller
{
    public function login()
    {
        if (isset($jwt)) {
            echo json_encode(['error' => 'Usuário já logado']);
            return;
        }
        $data = $this->getRequestBody();
        $email = $data['email'];
        $senha = $data['senha'];

        $user = User::getUserByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            $payload = [
                'iat' => time(),
                'exp' => time() + (60 * 60),
                'data' => [
                    'user_id' => $user['cpf'],
                    'user_name' => $user['nome']
                ]
            ];
            $jwt = JWT::encode($payload, self::$secret_key, 'HS256');
            $this->respond(['message' => 'usuario logado', 'token' => $jwt], 200);
        } else {
            $this->respond(['error' => 'Usuário ou senha inválidos'], 400);
        }
    }
    public function logout()
    {
        echo json_encode([
            'message' => "Usuário deslogado",
            'logged_out' => true
        ]);
    }
}
?>