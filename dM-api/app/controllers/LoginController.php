<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';
class LoginController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['error' => 'Usuário já logado', 'session' => $_SESSION]);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $senha = $data['senha'];

        $user = User::getUserByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            session_start();
            $_SESSION['user_id'] = $user['cpf'];
            $_SESSION['user_nome'] = $user['nome'];
            echo json_encode([
                'message' => "Usuário logado",
                $_SESSION
            ]);

        } else {
            echo json_encode(['error' => 'Usuário ou senha inválidos']);
        }
    }
    public function checkSession()
    {
        header('Content-Type: application/json');
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['logged_in' => true, 'user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']]);
        } else {
            echo json_encode(['logged_in' => false]);
        }
    }
    public function logout()
    {
        session_destroy();
        echo json_encode([
            'message' => "Usuário deslogado",
            'logged_out' => true
        ]);
    }
}
?>