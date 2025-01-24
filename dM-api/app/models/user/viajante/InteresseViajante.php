<?php
require_once "core/Model.php";

class InteresseViajante extends model
{
    protected static $table = "DM_VIA_TPT";

    public static function store($ViajanteId, $TipoPontoTuristicoId)
    {
        try {
            $db = self::getdb();
            $query = "INSERT INTO " . self::$table . " (DM_VIA_ID, DM_TPT_ID) VALUES (:viajanteid , :tipopontoturistico)";
            $stmt = $db->prepare($query);
            $stmt->execute([
                ":viajanteid" => $ViajanteId,
                ":tipopontoturistico" => $TipoPontoTuristicoId
            ]);

            return [
                "message" => "Interesse do viajante cadastrado com sucesso",
                "data" => [
                    "viajanteId" => $ViajanteId,
                    "tipoPontoTuristicoId" => $TipoPontoTuristicoId
                ]
            ];

        } catch (PDOException $e) {
            return [
                "erro" => "erro ao cadastrar interesse do viajante" . $e->getMessage(),
            ];
        }
    }

}

?>