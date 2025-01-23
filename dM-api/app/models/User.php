<?php

require_once 'core/Model.php';

class User extends Model
{
    protected static $table = 'DM_USUARIO';
    public static function getAll()
    {
        $db = self::getDb();
        $result = $db->query("SELECT * FROM " . self::$table);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOne($cpf)
    {
        $db = self::getDb();
        $result = $db->query("SELECT * FROM " . self::$table . " WHERE USU_CPF = '" . $cpf . "'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public static function store($cpf, $nome, $email, $telefone, $senha, $sexo, $tipo, $valorServico, $tempoAtuacao)
    {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

        try {
            $db = self::getDb();
            // Iniciar transação
            $db->beginTransaction();
            //Inserir primeiro o usuario na tabela DM_USUARIO
            $query = "INSERT INTO DM_USUARIO (USU_CPF, USU_NOME, USU_EMAIL, USU_TELEFONE, USU_SENHA, USU_SEXO, USU_TIPO) 
                      VALUES (:cpf, :nome, :email, :telefone, :senha, :sexo, :tipo)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':cpf' => $cpf,
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone,
                ':senha' => $senha_hash,
                ':sexo' => $sexo,
                ':tipo' => $tipo
            ]);
            //Inserir o usuario na tabela correspondente ao tipo
            if ($tipo === 'VIAJANTE') {
                $query = "INSERT INTO DM_VIAJANTE (DM_USU_CPF) VALUES (:cpf)";
                $stmt = $db->prepare($query);
                $stmt->execute([':cpf' => $cpf]);
            } elseif ($tipo === 'GUIA') {
                $query = "INSERT INTO DM_GUIA (DM_USU_CPF, GUI_TEMPO_ATUACAO, GUI_VALOR_SERVICO) 
                          VALUES (:cpf, :tempoAtuacao, :valorServico)";
                $stmt = $db->prepare($query);
                $stmt->execute([
                    ':cpf' => $cpf,
                    ':tempoAtuacao' => $tempoAtuacao,
                    ':valorServico' => $valorServico
                ]);
            } else {
                throw new Exception('Tipo de usuário inválido');
            }

            //A transação somente será efetivada se chegar até aqui sem erros
            $db->commit();

            //retornando o usuario cadastrado
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
            // Reverter transação em caso de erro
            $db->rollBack();
            return ['erro' => 'Erro ao cadastrar usuário: ' . $e->getMessage()];
        }
    }

    public static function getUserByEmail($email)
    {
        //precisa de melhorias
        $db = self::getDb();
        $result = $db->query("SELECT * FROM " . self::$table . " WHERE USU_EMAIL = '" . $email . "'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}

?>