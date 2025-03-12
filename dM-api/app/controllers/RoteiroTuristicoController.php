<?php
require "app/models/RoteiroTuristico.php";
require "core/Controller.php";

class RoteiroTuristicoController extends Controller
{


    public function index()
    {
        $roteiroTuristico = RoteiroTuristico::index();
        $this->respond($roteiroTuristico, 200);
    }
    public function getOne($id)
    {
        if (isset($id)) {
            $roteiroTuristico = RoteiroTuristico::getOne($id);
            $this->respond($roteiroTuristico, 200);
        } else {
            $this->respond(["error" => "Roteiro turistico não encontrado"], 400);
        }
    }
    public function store()
    {
        $token = json_decode(json_encode($this->checkSession()), true);
        if ($token['error']) {
            $this->respond($token, 401);
        } else {
            $data = $this->getRequestBody();
            $nome = $data["nome"] ?? null;
            $visibilidade = $data["visibilidade"] ?? null;
            $informacoes = $data["informacoes"] ?? null;
            $user = $token['user']['user_id'] ?? null;
            $pontosTuristicos = $data["pontosTuristicos"] ?? null;
            $imagens = $data["imagens"] ?? null;
            $roteiroTuristico = RoteiroTuristico::store($nome, $visibilidade, $informacoes, $user, $pontosTuristicos, $imagens);
            if (isset($roteiroTuristico["error"])) {
                $this->respond($roteiroTuristico, 400);
            }
            $this->respond($roteiroTuristico, 200);
        }

    }


    public function delete($id)
    {
        $token = $this->checkSession();
        if (isset($token["error"])) {
            $this->respond($token, 401);
        } else {
            if (isset($id)) {
                $roteiroTuristico = RoteiroTuristico::delete($id);
                $this->respond($roteiroTuristico, 200);

            } else {
                $roteiroTuristico = ["error" => "Roteiro turistico não encontrado"];
                $this->respond($roteiroTuristico, 400);
            }
        }

    }
    public function update($id)
    {
        $token = $this->checkSession();
        if (isset($token["error"])) {
            $this->respond($token, 401);
        } else {
            $data = $this->getRequestBody();
            $nome = $data["nome"];
            $visibilidade = $data["visibilidade"];
            $informacoes = $data["informacoes"];
            $user = $token['user']['user_id'];
            $pontosTuristicos = $data["pontosTuristicos"];

            $roteiroTuristico = RoteiroTuristico::update($id, $nome, $visibilidade, $informacoes, $user, $pontosTuristicos);
            if (isset($roteiroTuristico["error"])) {
                $this->respond($roteiroTuristico, 400);
            }
            $this->respond($roteiroTuristico, 200);
        }
    }

}

?>