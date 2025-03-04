<?php
require_once 'core/Controller.php';
require_once 'app/models/user/viajante/InteresseViajante.php';

class InteresseViajanteController extends Controller
{

    public function store()
    {
        $data = $this->getRequestBody();
        $ViajanteId = $data["viajanteId"];
        $TipoPontoTuristicoId = $data["tipoPontoTuristicoId"];
        $interesse = InteresseViajante::store($ViajanteId, $TipoPontoTuristicoId);
        $this->respond($interesse, 200);
    }
}

?>