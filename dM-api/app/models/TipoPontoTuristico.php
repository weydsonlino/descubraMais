<?php
require 'core/Model.php';

class TipoPontoTuristico extends Model
{
    protected static $table = 'DM_TIPO_PONTO_TURISTICO';

    public static function getAll()
    {
        try {
            $db = self::getDb();
            $query = ("SELECT TPT_ID AS id, TPT_NOME AS nome FROM " . self::$table);
            $stmt = $db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "message" => "categorias buscadas com sucesso",
                "data" => $result,
            ];

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar categorias" . $e->getMessage()
            ];
        }
    }

    public static function getOne($id)
    {
        try {
            $db = self::getDb();
            $query = ("SELECT * FROM  " . self::$table . " WHERE TPT_ID = :id");
            $stmt = $db->prepare(($query));
            $stmt->execute([
                ":id" => $id,
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (isset($result["TPT_ID"])) {
                return [
                    "message" => "categoria buscada com sucesso",
                    "data" => $result,
                ];
            } else {
                return [
                    "message" => "categoria não encontrada",
                ];
            }
        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar categoria" . $e->getMessage()
            ];
        }
    }
    public static function create($nome): array
    {
        try {
            $db = self::getDb();
            $query = ("INSERT INTO " . self::$table . " (TPT_NOME) VALUES (:nome)");
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":nome" => $nome
            ]);

            return [
                "nome" => $nome,
                "message" => "categoria criada com sucesso"
            ];
        } catch (PDOException $e) {
            return [
                "message" => "Erro ao criar categoria" . $e->getMessage(),
                "nome" => $nome,
            ];
        }


    }
    public static function update($id, $nome): array
    {
        try {
            $db = self::getDb();
            $query = ("UPDATE " . self::$table . " SET TPT_NOME = :nome WHERE TPT_ID = :id");
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":nome" => $nome,
                ":id" => $id
            ]);

            return [
                "nome" => $nome,
                "message" => "categoria atualizada com sucesso"
            ];
        } catch (PDOException $e) {
            return [
                "message" => "Erro ao atualizar categoria" . $e->getMessage(),
                "nome" => $nome,
            ];
        }
    }
    public static function delete($id): array
    {
        try {
            $db = self::getDb();
            $query = ("DELETE FROM " . self::$table . " WHERE TPT_ID = :id");
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":id" => $id
            ]);

            return [
                "message" => "categoria deletada com sucesso"
            ];
        } catch (PDOException $e) {
            return [
                "message" => "Erro ao deletar categoria" . $e->getMessage()
            ];
        }
    }
}

?>