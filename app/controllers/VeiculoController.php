<?php

require_once PROJECT_ROOT . '/app/models/VeiculoModel.php';

class VeiculoController {
    private $veiculoModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
        $this->veiculoModel = new VeiculoModel();
    }

    public function index() {
        $veiculos = $this->veiculoModel->getAll();
        require_once PROJECT_ROOT . '/app/views/listar_veiculos.php';
    }

    public function create() {
        require_once PROJECT_ROOT . '/app/views/form_veiculo.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'placa' => $_POST['placa'],
                'modelo' => $_POST['modelo'],
                'ano' => $_POST['ano'],
                'km_atual' => $_POST['km_atual'],
                'status' => $_POST['status']
            ];
            $this->veiculoModel->create($dados);
            header('Location: ' . BASE_URL . '/veiculo');
        }
    }

    public function edit($id) {
        $veiculo = $this->veiculoModel->getById($id);
        require_once PROJECT_ROOT . '/app/views/form_veiculo.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'placa' => $_POST['placa'],
                'modelo' => $_POST['modelo'],
                'ano' => $_POST['ano'],
                'km_atual' => $_POST['km_atual'],
                'status' => $_POST['status']
            ];
            $this->veiculoModel->update($id, $dados);
            header('Location: ' . BASE_URL . '/veiculo');
        }
    }

    public function destroy($id) {
        $this->veiculoModel->delete($id);
        header('Location: ' . BASE_URL . '/veiculo');
    }
}