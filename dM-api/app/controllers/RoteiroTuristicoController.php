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
        $check = $this->checkSession();
        if (isset($check["error"])) {
            $this->respond($check, 401);
        } else {
            $data = $this->getRequestBody();
            $nome = $data["nome"];
            $visibilidade = $data["visibilidade"];
            $informacoes = $data["informacoes"];
            $cpf = $data["cpf"];
            $pontosTuristicos = $data["pontosTuristicos"];
            $roteiroTuristico = RoteiroTuristico::store($nome, $visibilidade, $informacoes, $cpf, $pontosTuristicos);
            if (isset($roteiroTuristico["error"])) {
                $this->respond($roteiroTuristico, 400);
            }
            $this->respond($roteiroTuristico, 200);
        }

    }

    public function delete($id)
    {
        $check = $this->checkSession();
        if (isset($check["error"])) {
            $this->respond($check, 401);
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
        $check = $this->checkSession();
        if (isset($check["error"])) {
            $this->respond($check, 401);
        } else {
            $data = $this->getRequestBody();
            $nome = $data["nome"];
            $visibilidade = $data["visibilidade"];
            $informacoes = $data["informacoes"];
            $cpf = $data["cpf"];
            $pontosTuristicos = $data["pontosTuristicos"];

            $roteiroTuristico = RoteiroTuristico::update($id, $nome, $visibilidade, $informacoes, $cpf, $pontosTuristicos);
            if (isset($roteiroTuristico["error"])) {
                $this->respond($roteiroTuristico, 400);
            }
            $this->respond($roteiroTuristico, 200);
        }
    }

}

?>