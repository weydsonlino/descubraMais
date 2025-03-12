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
}

?>