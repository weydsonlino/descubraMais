<?php

use Respect\Validation\Rules\Unique;

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
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        $imageUrls = [];
        // Verifica se há imagens enviadas
        if (!empty($_FILES["imagens"]["name"][0])) {
            foreach ($_FILES["imagens"]["tmp_name"] as $key => $tmpName) {
                $fileName = time() . "_" . uniqid() . basename($_FILES["imagens"]["name"][$key]);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $imageUrls[] = "http://localhost:8000/uploads/" . $fileName;
                }
            }
        }

        $nome = $_POST['nome'] ?? null;
        $pais = $_POST['pais'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $estado = $_POST['estado'] ?? null;
        $rua = $_POST['rua'] ?? null;
        $informacoes = $_POST['informacoes'] ?? null;
        $user = $_POST['user'] ?? null;
        $tipoPontoTuristicoId = $_POST['tipoPontoTuristicoId'] ?? null;
        $pontoTuristico = PontoTuristico::store($nome, $informacoes, $user, $pais, $cidade, $estado, $rua, $tipoPontoTuristicoId, $imageUrls);
        if (isset($pontoTuristico['error'])) {
            $this->respond([
                'message' => 'Erro ao cadastrar ponto turístico',
                $pontoTuristico,
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
    public function delete($id)
    {
        $pontoTuristico = PontoTuristico::delete($id);
        if (isset($pontoTuristico['error'])) {
            $this->respond([
                'message' => 'Erro ao deletar ponto turístico',
                $pontoTuristico,
            ], 500);
        } else {
            $this->respond([
                'message' => 'Ponto turístico deletado com sucesso',
            ], 200);
        }
    }
}


?>