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
    public static function update($cpf, $nome, $email, $telefone, $senha, $sexo, $tipo, $valorServico, $tempoAtuacao)
    {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        try {
            $db = self::getDb();
            $db->beginTransaction();
            $query = "UPDATE " . self::$table . " SET USU_NOME = :nome, USU_EMAIL = :email, USU_TELEFONE = :telefone, USU_SENHA = :senha, USU_SEXO = :sexo, USU_TIPO = :tipo where USU_CPF = :cpf";
            $stmt = $db->prepare($query);
            $stmt->execute([
                "cpf" => $cpf,
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone,
                ':senha' => $senha_hash,
                ':sexo' => $sexo,
                ':tipo' => $tipo
            ]);

            if ($tipo === 'VIAJANTE') {
                //nÃO TEM O QUE ATUALIZAR AINDA
            } elseif ($tipo === 'GUIA') {
                $query = "UPDATE DM_GUIA SET GUI_TEMPO_ATUACAO = :tempoAtuacao, GUI_VALOR_SERVICO = :valorServico WHERE DM_USU_CPF = :cpf";
                $stmt = $db->prepare($query);
                $stmt->execute([
                    ':cpf' => $cpf,
                    ':tempoAtuacao' => $tempoAtuacao,
                    ':valorServico' => $valorServico
                ]);
            } else {
                throw new Exception('Tipo de usuário inválido');
            }

            $db->commit();
            return [
                'message' => 'Usuário atualizado com sucesso',
            ];

        } catch (Exception $e) {
            $db->rollBack();
            return [
                "erro" => "Erro ao atualizar usuário: " . $e->getMessage()
            ];
        }
    }

    public static function delete($cpf, $tipo)
    {
        try {
            $db = self::getDb();
            $db->beginTransaction();

            if ($tipo === "VIAJANTE") {
                $query = "DELETE FROM DM_VIAJANTE WHERE DM_USU_CPF = :cpf";
                $stmt = $db->prepare($query);
                $stmt->execute([':cpf' => $cpf]);
            } elseif ($tipo === "GUIA") {
                $query = "DELETE FROM DM_GUIA WHERE DM_USU_CPF = :cpf";
                $stmt = $db->prepare($query);
                $stmt->execute([':cpf' => $cpf]);
            } else {
                throw new Exception(message: 'O Tipo de usuário inválido' . $tipo);
            }

            $query = "DELETE FROM " . self::$table . " WHERE USU_CPF = :cpf";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":cpf" => $cpf
            ]);

            $db->commit();

            return [
                "message" => "Usuário deletado com sucesso"
            ];

        } catch (Exception $e) {
            $db->rollBack();
            return [
                "erro" => "Erro ao deletar usuario" . $e->getMessage()
            ];
        }
    }
}

?>