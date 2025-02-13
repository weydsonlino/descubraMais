<?php
require "core/Model.php";

class RoteiroTuristico extends Model
{
    private static $table_name = "DM_ROTEIRO_TURISTICO";

    public static function index()
    {
        try {
            $db = self::getDb();
            $query = "SELECT * FROM " . self::$table_name . "";
            $stmt = $db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "message" => "Roteiros turísticos buscados com sucesso",
                "data" => $result
            ];

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar roteiros turísticos",
                "error" => $e->getMessage()
            ];
        }
    }
    public static function getOne($id)
    {
        try {
            $db = self::getDb();
            $query = "SELECT * FROM " . self::$table_name . " WHERE RTT_ID = :id";
            $stmt = $db->prepare($query);
            $stmt->execute(["id" => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return [
                    "message" => "Roteiro turístico não existe",
                ];
            }
            return [
                "message" => "Roteiro turístico buscado com sucesso",
                "data" => $result
            ];
        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar o Roteiro",
                "error" => $e->getMessage()
            ];
        }
    }
    public static function store($nome, $visibilidade, $informacoes, $cpf, $pontosTuristicos)
    {
        try {
            $db = self::getDb();
            $db->beginTransaction();
            $query = "INSERT INTO " . self::$table_name . " (RTT_NOME, RTT_VISIBILIDADE, RTT_DESCRICAO, DM_USU_CPF) VALUES (:nome, :visibilidade, :informacoes, :cpf)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":nome" => $nome,
                ":visibilidade" => $visibilidade,
                ":informacoes" => $informacoes,
                ":cpf" => $cpf
            ]);
            $roteiro = $db->lastInsertId();
            $query = "INSERT INTO DM_RTT_PTT (DM_RTT_ID, DM_PTT_ID, DM_RTT_PTT_ORDEM) VALUES (:roteiro, :ponto, :ordem)";
            $stmt = $db->prepare($query);
            foreach ($pontosTuristicos as $ponto) {
                $stmt->execute([
                    ":roteiro" => $roteiro,
                    ":ponto" => (int) $ponto["id"],  // Garantindo que seja um número inteiro
                    ":ordem" => (int) $ponto["ordem"]
                ]);
            }

            $db->commit();

            return [
                "success" => "Roteiro criado com sucesso"
            ];

        } catch (Exception $e) {
            $db->rollBack();
            return [
                "error" => $e->getMessage()
            ];
        }
    }
    public static function update($id, $nome, $visibilidade, $informacoes, $cpf, $pontosTuristicos)
    {
        try {
            $db = self::getDb();
            $db->beginTransaction();
            $query = "UPDATE " . self::$table_name . " SET RTT_NOME = :nome, 
              RTT_VISIBILIDADE = :visibilidade, 
              RTT_DESCRICAO = :informacoes, 
              DM_USU_CPF = :cpf
                WHERE RTT_ID = :id";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":id" => $id,
                ":nome" => $nome,
                ":visibilidade" => $visibilidade,
                ":informacoes" => $informacoes,
                ":cpf" => $cpf
            ]);
            $query = "UPDATE DM_RTT_PTT SET DM_PTT_ID = :ponto, DM_RTT_PTT_ORDEM = :ordem WHERE DM_RTT_ID = :id";
            $stmt = $db->prepare($query);
            foreach ($pontosTuristicos as $ponto) {
                $stmt->execute([
                    ":ponto" => (int) $ponto["id"],  // Garantindo que seja um número inteiro
                    ":ordem" => (int) $ponto["ordem"],
                    ":id" => $id
                ]);
            }

            $db->commit();

            return [
                "success" => "Roteiro atualiado com sucesso"
            ];

        } catch (Exception $e) {
            $db->rollBack();
            return [
                "error" => $e->getMessage()
            ];
        }
    }

    public static function delete($id): array
    {
        try {
            $db = self::getDb();
            $query = "DELETE FROM " . self::$table_name . " WHERE RTT_ID = :id";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":id" => $id
            ]);
            return [
                "message" => "Roteiro deletado com sucesso"
            ];
        } catch (Exception $e) { {
                return [
                    "mesage" => "error ao buscar o Roteiro",
                    "error" => $e->getMessage()
                ];
            }
            ;
        }

    }
}

?>