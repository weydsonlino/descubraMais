<?php
require 'vendor/autoload.php';
require 'core/Model.php';

class Pesquisa extends Model
{
    public static function buscarPorNome($nome)
    {
        try {
            $nomenovo = '%' . $nome . '%';
            $db = self::getDb();
            $db->beginTransaction();

            $query = "SELECT * FROM DM_PONTO_TURISTICO WHERE PTT_NOME LIKE :nome";

            $query = "SELECT DM_PONTO_TURISTICO.PTT_NOME as nome,MIN(DM_IMAGEM_PONTO_TURISTICO.DM_IMAGEM) AS imagem, 
                    DM_PONTO_TURISTICO.PTT_ID AS id
                    from DM_PONTO_TURISTICO, DM_IMAGEM_PONTO_TURISTICO
                    where 
                    DM_PONTO_TURISTICO.PTT_NOME LIKE :nome AND
                    DM_IMAGEM_PONTO_TURISTICO.DM_PTT_ID = DM_PONTO_TURISTICO.PTT_ID
                    GROUP BY DM_PONTO_TURISTICO.PTT_ID, DM_PONTO_TURISTICO.PTT_NOME";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':nome' => $nomenovo,
            ]);
            $pontosTuristicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT DM_ROTEIRO_TURISTICO.RTT_NOME as nome 
                    FROM DM_ROTEIRO_TURISTICO
                    WHERE RTT_NOME LIKE :nome";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':nome' => $nomenovo,
            ]);

            $roteirosTuristicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $db->commit();

            return [
                "pontosTuristicos" => $pontosTuristicos,
                "roteirosTuristicos" => $roteirosTuristicos
            ];

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar pontos turísticos",
                "error" => $e->getMessage()
            ];
        }

    }
    public static function index()
    {
        try {
            $db = self::getDb();

            $query = "SELECT DM_PONTO_TURISTICO.PTT_ID AS ID, DM_PONTO_TURISTICO.PTT_NOME AS NOME, DM_PONTO_TURISTICO.PTT_INFORMACOES AS INFORMACOES, MIN(DM_IMAGEM_PONTO_TURISTICO.DM_IMAGEM) AS IMAGEM
                    FROM DM_PONTO_TURISTICO, DM_IMAGEM_PONTO_TURISTICO
                    WHERE DM_IMAGEM_PONTO_TURISTICO.DM_PTT_ID = DM_PONTO_TURISTICO.PTT_ID
                    GROUP BY DM_PONTO_TURISTICO.PTT_ID, DM_PONTO_TURISTICO.PTT_NOME, DM_PONTO_TURISTICO.PTT_INFORMACOES
                    LIMIT 10";

            $stmt = $db->prepare($query);
            $stmt->execute();
            $pontosTuristicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $pontosTuristicos;

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar pontos turísticos",
                "error" => $e->getMessage()
            ];
        }
    }
    public static function getOne($id)
    {
        try {
            $db = self::getDb();

            $query = "SELECT
                    DM_PONTO_TURISTICO.PTT_ID AS ID, 
                    DM_PONTO_TURISTICO.PTT_NOME AS NOME, 
                    DM_PONTO_TURISTICO.PTT_INFORMACOES AS INFORMACOES,
                    DM_TIPO_PONTO_TURISTICO.TPT_NOME AS TIPO,
                    DM_IMAGEM_PONTO_TURISTICO.DM_IMAGEM AS IMAGEM
                FROM DM_PONTO_TURISTICO
                LEFT JOIN DM_IMAGEM_PONTO_TURISTICO 
                    ON DM_IMAGEM_PONTO_TURISTICO.DM_PTT_ID = DM_PONTO_TURISTICO.PTT_ID
                LEFT JOIN DM_PTT_TPT 
                    ON DM_PTT_TPT.DM_PTT_ID = DM_PONTO_TURISTICO.PTT_ID 
                LEFT JOIN DM_TIPO_PONTO_TURISTICO 
                    ON DM_TIPO_PONTO_TURISTICO.TPT_ID = DM_PTT_TPT.DM_TPT_ID
                WHERE DM_PONTO_TURISTICO.PTT_ID = :id
                ";

            $stmt = $db->prepare($query);
            $stmt->execute([
                ':id' => $id
            ]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (Exception $e) {
            return [
                "message" => "Erro ao buscar pontos turísticos",
                "error" => $e->getMessage()
            ];
        }
    }
}

?>