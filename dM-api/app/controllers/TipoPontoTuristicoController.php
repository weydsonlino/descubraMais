<?php
require_once 'app/models/TipoPontoTuristico.php';
require_once 'core/Controller.php';
require_once 'app/controllers/AuthenticationController.php';

class TipoPontoTuristicoController extends Controller
{
    public function index()
    {
        $tiposPontoTurisistico = TipoPontoTuristico::getAll();
        $this->respond($tiposPontoTurisistico, 200);
    }
    public function getOne($id)
    {
        if ($id) {
            $tipoPontoTurisistico = TipoPontoTuristico::getOne($id);
            $this->respond($tipoPontoTurisistico, 200);
        } else {
            $this->respond(['error' => 'Tipo de Ponto Turistico não econtrado'], 404);
        }
    }
    public function store()
    {
        $check = $this->checkSession();
        if ($check['error']) {
            $this->respond($check, 401);
        } else {
            $data = self::getRequestBody();
            $nome = $data["nome"];

            $tipoPontoTuristico = TipoPontoTuristico::create($nome);
            $this->respond($tipoPontoTuristico, 200);
        }
    }
    public function update($id)
    {
        $check = $this->checkSession();
        if ($check['error']) {
            $this->respond($check, 401);
        } else {
            $data = self::getRequestBody();
            $nome = $data["nome"];
            $tipoPontoTuristico = TipoPontoTuristico::update($id, $nome);
            $this->respond($tipoPontoTuristico, 200);
        }
    }
    public function delete($id)
    {
        $check = $this->checkSession();
        if ($check['error']) {
            $this->respond($check, 401);
        } else {
            if ($id) {
                $tipoPontoTuristico = TipoPontoTuristico::delete($id);
                $this->respond($tipoPontoTuristico, 200);
            } else {
                $this->respond(["error" => "Tipo de Ponto Turistico não econtrado"], 404);
            }
        }
    }
}

?>