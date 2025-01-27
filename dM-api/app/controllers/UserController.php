<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';
require_once 'app/validation/Validation.php';

require 'vendor/autoload.php';

use Respect\Validation\Validator as v;

class UserController extends Controller
{
    public function index()
    {
        $users = User::getAll();
        $this->respond($users, 200);
    }
    public function getOne($cpf)
    {
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
        // Regras de validação
        if ($data['tipo'] == 'GUIA') {
            $validationRules = [
                'cpf' => v::cpf()->NotEmpty()->setName('CPF'),
                'nome' => v::stringType()->notEmpty()->setName('Nome'),
                'email' => v::email()->setName('Email'),
                'telefone' => v::stringType()->notEmpty()->setName('Telefone'),
                'senha' => v::stringType()->notEmpty()->setName('Senha')->length(8, 20),
                'sexo' => v::stringType()->notEmpty()->setName('Sexo')->length(1, 1),
                'tipo' => v::stringType()->notEmpty()->setName('Tipo'),
                'guia' => v::arrayType()->notEmpty()->setName('Guia')->key('valorServico', v::floatType()->notEmpty()->setName('Valor do Serviço'))->key('tempoAtuacao', v::intType()->notEmpty()->setName('Tempo de Atuação')),
            ];
        } else {
            $validationRules = [
                'cpf' => v::cpf()->NotEmpty()->setName('CPF'),
                'nome' => v::stringType()->notEmpty()->setName('Nome'),
                'email' => v::email()->setName('Email'),
                'telefone' => v::stringType()->notEmpty()->setName('Telefone'),
                'senha' => v::stringType()->notEmpty()->setName('Senha')->length(8, 20),
                'sexo' => v::stringType()->notEmpty()->setName('Sexo')->length(1, 1),
                'tipo' => v::stringType()->notEmpty()->setName('Tipo'),
            ];
        }
        Validation::validation($data, $validationRules);

        $cpf = $data['cpf'];
        $nome = $data['nome'];
        $email = $data['email'];
        $telefone = $data['telefone'];
        $senha = $data['senha'];
        $sexo = $data['sexo'];
        $tipo = $data['tipo'];
        $valorServico = $data['guia']['valorServico'];
        $tempoAtuacao = $data['guia']['tempoAtuacao'];

        // Chamar o método do Model para cadastrar o usuário
        $user = User::store($cpf, $nome, $email, $telefone, $senha, $sexo, $tipo, $valorServico, $tempoAtuacao);

        // Retornar a resposta
        echo json_encode($user);
    }
    public function update()
    {
        $data = self::getRequestBody();

        $data = json_decode(file_get_contents('php://input'), true);
        // Regras de validação
        if ($data['tipo'] == 'GUIA') {
            $validationRules = [
                'cpf' => v::cpf()->NotEmpty()->setName('CPF'),
                'nome' => v::stringType()->notEmpty()->setName('Nome'),
                'email' => v::email()->setName('Email'),
                'telefone' => v::stringType()->notEmpty()->setName('Telefone'),
                'senha' => v::stringType()->notEmpty()->setName('Senha')->length(8, 20),
                'sexo' => v::stringType()->notEmpty()->setName('Sexo')->length(1, 1),
                'tipo' => v::stringType()->notEmpty()->setName('Tipo'),
                'guia' => v::arrayType()->notEmpty()->setName('Guia')->key('valorServico', v::floatType()->notEmpty()->setName('Valor do Serviço'))->key('tempoAtuacao', v::intType()->notEmpty()->setName('Tempo de Atuação')),
            ];
        } else {
            $validationRules = [
                'cpf' => v::cpf()->NotEmpty()->setName('CPF'),
                'nome' => v::stringType()->notEmpty()->setName('Nome'),
                'email' => v::email()->setName('Email'),
                'telefone' => v::stringType()->notEmpty()->setName('Telefone'),
                'senha' => v::stringType()->notEmpty()->setName('Senha')->length(8, 20),
                'sexo' => v::stringType()->notEmpty()->setName('Sexo')->length(1, 1),
                'tipo' => v::stringType()->notEmpty()->setName('Tipo'),
            ];
        }
        Validation::validation($data, $validationRules);
        $cpf = $data['cpf'];
        $nome = $data['nome'];
        $email = $data['email'];
        $telefone = $data['telefone'];
        $senha = $data['senha'];
        $sexo = $data['sexo'];
        $tipo = $data['tipo'];
        $valorServico = $data['guia']['valorServico'];
        $tempoAtuacao = $data['guia']['tempoAtuacao'];

        $user = User::update($cpf, $nome, $email, $telefone, $senha, $sexo, $tipo, $valorServico, $tempoAtuacao);

        if (isset($user['erro'])) {
            $this->respond(['error' => $user], 400);
        } else {
            $this->respond([
                'message' => "Sucesso ao atualizar usuario",
                'data' => $user
            ], 400);
        }
    }
    public function delete()
    {
        $data = self::getRequestBody();
        $tipo = $data['tipo'];
        $cpf = $data['cpf'];
        $user = User::delete($cpf, $tipo);
        $this->respond(
            [
                'message' => 'Usuário deletado com sucesso',
                'data' => $user
            ],
            200
        );
    }
}
