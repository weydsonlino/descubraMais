<?php
require_once "core/Model.php";

class PontoTuristico extends Model
{
    private static $table_name = "DM_PONTO_TURISTICO";

    public static function getAll()
    {
        try {
            $db = self::getDb();
            $query = "SELECT * FROM " . self::$table_name;
            $stmt = $db->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "message" => "Pontos turísticos buscados com sucesso",
                "data" => $result
            ];

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar pontos turísticos",
                "error" => $e->getMessage()
            ];
        }
    }
    public static function store($nome, $informacoes, $id)
    {
        try {
            $db = self::getDb();
            $query = "INSERT INTO " . self::$table_name . " (PTT_NAME, PTT_INFORMACOES, DM_USU_CPF) VALUES (:nome, :informacoes, :id)";
            $stmt = $db->prepare($query);
            $stmt->execute(
                [
                    ":nome" => $nome,
                    ":informacoes" => $informacoes,
                    ":id" => $id
                ]
            );

            return [
                "message" => "Ponto turístico cadastrado com sucesso",
            ];

        } catch (Exception $e) {
            return [
                "message" => "Erro ao cadastrar ponto turístico",
                "error" => $e->getMessage()
            ];
        }
    }
    public static function getOne($id)
    {
        try {
            $db = self::getDb();
            $query = "SELECT * FROM " . self::$table_name . " WHERE PTT_ID = :id";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":id" => $id
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [
                "message" => "Ponto turístico buscado com sucesso",
                "data" => $result
            ];

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar ponto turístico",
                "error" => $e->getMessage()
            ];
        }
    }
}

?>