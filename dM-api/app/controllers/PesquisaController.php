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
    //provisorio
    public function index()
    {
        $resultado = Pesquisa::index();
        $this->respond($resultado, 200);
    }
    public function getOne($id)
    {
        $id = $id['id'];
        $resultado = Pesquisa::getOne($id);
        $this->respond($resultado, 200);
    }
}

?>