<?php
require_once 'core/Controller.php';
require_once 'app/models/user/viajante/InteresseViajante.php';

class InteresseViajanteController extends Controller
{

    public function store()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $ViajanteId = $data["viajanteId"];
        $TipoPontoTuristicoId = $data["tipoPontoTuristicoId"];
        $interesse = InteresseViajante::store($ViajanteId, $TipoPontoTuristicoId);
        $this->respond($interesse, 200);
    }
}

?>