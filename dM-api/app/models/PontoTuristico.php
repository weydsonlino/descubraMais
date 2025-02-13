<?php
require_once "core/Model.php";

class PontoTuristico extends Model
{
    private static $table_name = "DM_PONTO_TURISTICO";

    public static function getAll()
    {
        try {
            $db = self::getDb();
            $query = "SELECT 
                PTT.PTT_ID AS id,
                PTT.PTT_NOME AS nome,
                PTT.PTT_INFORMACOES AS informacoes,
                PTT.DM_USU_CPF AS usuario,
                END.END_PAIS AS pais,
                END.END_CIDADE AS cidade,
                END.END_ESTADO AS estado,
                END.END_RUA AS rua,
                TPT.TPT_NOME AS tipo
                 FROM " . self::$table_name . " AS PTT
                 INNER JOIN DM_ENDERECO AS END
                 ON PTT.PTT_ID = END.DM_PTT_ID
                 INNER JOIN DM_PTT_TPT AS PTT_TPT
                 ON PTT.PTT_ID = PTT_TPT.DM_PTT_ID
                 INNER JOIN DM_TIPO_PONTO_TURISTICO AS TPT
                 ON PTT_TPT.DM_TPT_ID = TPT.TPT_ID
                 ";
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
    public static function store($nome, $informacoes, $user, $pais, $cidade, $estado, $rua, $tipoPontoTuristicoId)
    {
        try {

            $db = self::getDb();
            $db->beginTransaction();
            //Criando o Ponto Turistico
            $query = "INSERT INTO " . self::$table_name . " (PTT_NOME, PTT_INFORMACOES, DM_USU_CPF) VALUES (:nome, :informacoes, :id)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":nome" => $nome,
                ":informacoes" => $informacoes,
                ":id" => $user
            ]);

            $pontoTuristicoId = $db->lastInsertId();

            //Criando a relação entre o Ponto Turistico e o Tipo de Ponto Turistico
            $query = "INSERT INTO DM_PTT_TPT(DM_PTT_ID, DM_TPT_ID) VALUES (:pontoTuristicoId, :tipoPontoTuristicoId)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":pontoTuristicoId" => $pontoTuristicoId,
                ":tipoPontoTuristicoId" => $tipoPontoTuristicoId
            ]);

            //Criando e relacionando o Endereço do Ponto Turistico
            $query = "INSERT INTO DM_ENDERECO (END_PAIS, END_ESTADO, END_CIDADE, END_RUA, DM_PTT_ID) VALUES (:pais, :estado, :cidade, :rua, :pontoTuristicoId)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":pais" => $pais,
                ":estado" => $estado,
                ":cidade" => $cidade,
                ":rua" => $rua,
                ":pontoTuristicoId" => $pontoTuristicoId
            ]);

            $db->commit();

        } catch (Exception $e) {
            $db->rollBack();
            return [
                "error" => $e->getMessage()
            ];
        }
    }
    public static function getOne($id)
    {
        try {
            $db = self::getDb();
            $query = "SELECT 
                PTT.PTT_ID AS id,
                PTT.PTT_NOME AS nome,
                PTT.PTT_INFORMACOES AS informacoes,
                PTT.DM_USU_CPF AS usuario,
                END.END_PAIS AS pais,
                END.END_CIDADE AS cidade,
                END.END_ESTADO AS estado,
                END.END_RUA AS rua,
                TPT.TPT_NOME AS tipo
                 FROM " . self::$table_name . " AS PTT
                 INNER JOIN DM_ENDERECO AS END
                 ON PTT.PTT_ID = END.DM_PTT_ID
                 INNER JOIN DM_PTT_TPT AS PTT_TPT
                 ON PTT.PTT_ID = PTT_TPT.DM_PTT_ID
                 INNER JOIN DM_TIPO_PONTO_TURISTICO AS TPT
                 ON PTT_TPT.DM_TPT_ID = TPT.TPT_ID
                 WHERE PTT.PTT_ID = :id
                 ";
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