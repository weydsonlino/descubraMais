<?php
require 'vendor/autoload.php';
require 'core/Controller.php';
require 'app/models/Pesquisa.php';

class PesquisaController extends Controller
{
    public function pesquisa($nome)
    {
        $queryParams = $_GET;
        if (isset($queryParams)) {
            $nome = $queryParams['nome'] ?? null;
            $resultado = Pesquisa::buscarPorNome($nome);
            $this->respond($resultado, 200);
        }
    }
}

?>