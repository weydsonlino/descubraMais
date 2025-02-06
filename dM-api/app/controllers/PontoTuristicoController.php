<?php
require_once "core/Controller.php";
require_once "app/models/PontoTuristico.php";

class PontoTuristicoController extends Controller
{
    public function index()
    {
        $pontosTuristicos = PontoTuristico::getAll();
        $this->respond($pontosTuristicos, 200);
    }
    public function store()
    {
        $data = self::getRequestBody();
        $nome = $data['nome'];
        $pais = $data['pais'];
        $cidade = $data['cidade'];
        $estado = $data['estado'];
        $rua = $data['rua'];
        $informacoes = $data['informacoes'];
        $user = $data['user'];
        $tipoPontoTuristicoId = $data['tipoPontoTuristicoId'];
        $pontoTuristico = PontoTuristico::store($nome, $informacoes, $user, $pais, $cidade, $estado, $rua, $tipoPontoTuristicoId);
        if (isset($pontoTuristico['error'])) {
            $this->respond([
                'message' => 'Erro ao cadastrar ponto turístico',
                $pontoTuristico
            ], 500);
        } else {
            $this->respond([
                'message' => 'Ponto turístico cadastrado com sucesso',
            ], 201);
        }
    }

    public function show($id)
    {
        if ($id) {
            $pontoTuristico = PontoTuristico::getOne($id);
            $this->respond($pontoTuristico, 200);
        } else {
            $this->respond(['message' => 'Esse Ponto Turistico não existe'], 404);
        }

    }
}


?>