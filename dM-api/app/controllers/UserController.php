<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';

class UserController extends Controller
{
    public function index()
    {
        $users = User::getAll();
        $this->respond($users, 200);
    }
    public function getOne()
    {
        $cpf = $_GET['cpf'];
        if ($cpf) {
            $user = User::getOne($cpf);
            $this->respond($user, 200);
        } else {
            $this->respond(['error' => 'CPF não encontrado'], 404);
        }
    }
    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $cpf = $data['cpf'];
        $nome = $data['nome'];
        $email = $data['email'];
        $telefone = $data['telefone'];
        $senha = $data['senha'];
        $sexo = $data['sexo'];
        $tipo = $data['tipo'];
        $valorServico = $data['Guia']['valorServico'];
        $tempoAtuacao = $data['Guia']['tempoAtuacao'];

        // Chamar o método do Model para cadastrar o usuário
        $resultado = User::store($cpf, $nome, $email, $telefone, $senha, $sexo, $tipo, $valorServico, $tempoAtuacao);

        // Retornar a resposta
        echo json_encode($resultado);
    }
}
