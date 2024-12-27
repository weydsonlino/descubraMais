<?php

require_once 'core/Model.php';

class User extends Model
{
    protected static $table = 'DM_USUARIO';
    public static function getAll()
    {
        $db = self::getDb();
        $result = $db->query("SELECT * FROM " . self::$table);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getOne($cpf)
    {
        $db = self::getDb();
        $result = $db->query("SELECT * FROM " . self::$table . " WHERE USU_CPF = '" . $cpf . "'");
        return $result->fetch_assoc();
    }
    public static function store($cpf, $nome, $email, $telefone, $senha, $sexo, $tipo, $valorServico, $tempoAtuacao)
    {
        // Conectar ao banco
        $db = self::getDb();

        if ($db->connect_error) {
            return ['erro' => 'Erro de conexão: ' . $db->connect_error];
        }
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        // Iniciar transação para garantir que ambas as inserções (Usuario e Viajante/Guia) sejam feitas
        $db->begin_transaction();

        try {
            // Inserir usuário
            $query = $db->prepare("INSERT INTO DM_USUARIO (USU_CPF, USU_NOME, USU_EMAIL, USU_TELEFONE, USU_SENHA, USU_SEXO, USU_TIPO) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $query->bind_param('sssssss', $cpf, $nome, $email, $telefone, $senha_hash, $sexo, $tipo);
            $query->execute();

            // Inserir na tabela de Viajante ou Guia dependendo do tipo
            if ($tipo === 'VIAJANTE') {
                $query = $db->prepare("INSERT INTO DM_VIAJANTE (DM_USU_CPF) VALUES (?)");
                $query->bind_param('s', $cpf);
                $query->execute();
            } elseif ($tipo === 'GUIA') {
                $query = $db->prepare("INSERT INTO DM_GUIA (DM_USU_CPF, GUI_TEMPO_ATUACAO, GUI_VALOR_SERVICO) VALUES (?, ?, ?)");
                $query->bind_param('sss', $cpf, $tempoAtuacao, $valorServico);
                $query->execute();
            } else {
                throw new Exception('Tipo de usuário inválido');
            }

            // Confirmar as transações
            $db->commit();
            return [
                'sucesso' => true,
                'usuario' => [
                    'cpf' => $cpf,
                    'nome' => $nome,
                    'email' => $email,
                    'telefone' => $telefone,
                    'sexo' => $sexo,
                    'tipo' => $tipo
                ],
                'mensagem' => 'Usuário cadastrado com sucesso!'
            ];

        } catch (Exception $e) {
            $db->rollback();
            return ['erro' => 'Erro ao cadastrar usuario: ' . $e->getMessage()];
        } finally {
            // Fechar a conexão
            $db->close();
        }
    }
    public static function getUserByEmail($email)
    {
        $db = self::getDb();
        $result = $db->query("SELECT * FROM " . self::$table . " WHERE USU_EMAIL = '" . $email . "'");
        return $result->fetch_assoc();
    }
}

?>