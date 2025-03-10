<?php
require 'vendor/autoload.php';
require 'core/Controller.php';
require 'app/models/Pesquisa.php';

class PesquisaController extends Controller
{
    public function pesquisa($nome)
    {
        $resultado = Pesquisa::buscarPorNome($nome);
        $this->respond(["message" => 'dados encontrados para ' . $nome, $resultado], 200);
    }
}

?>