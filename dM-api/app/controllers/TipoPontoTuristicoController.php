<?php
require_once 'app/models/TipoPontoTuristico.php';
require_once 'core/Controller.php';

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
        $data = json_decode(file_get_contents('php://input'), true);
        $nome = $data["nome"];

        $tipoPontoTuristico = TipoPontoTuristico::create($nome);
        $this->respond($tipoPontoTuristico, 200);
    }
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $nome = $data["nome"];
        $id = $data["id"];
        $tipoPontoTuristico = TipoPontoTuristico::update($id, $nome);
        $this->respond($tipoPontoTuristico, 200);
    }
    public function delete($id)
    {
        if ($id) {
            $tipoPontoTuristico = TipoPontoTuristico::delete($id);
            $this->respond($tipoPontoTuristico, 200);
        } else {
            $this->respond(["error" => "Tipo de Ponto Turistico não econtrado"], 404);
        }
    }
}

?>