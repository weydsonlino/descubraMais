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
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':nome' => $nomenovo,
            ]);
            $pontosTuristicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM DM_ROTEIRO_TURISTICO WHERE RTT_NOME LIKE :nome";
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