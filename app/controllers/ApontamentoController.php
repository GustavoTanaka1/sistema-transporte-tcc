<?php

require_once PROJECT_ROOT . '/app/models/ApontamentoModel.php';
require_once PROJECT_ROOT . '/app/models/FuncionarioModel.php';
require_once PROJECT_ROOT . '/app/models/VeiculoModel.php';

class ApontamentoController {
    private $apontamentoModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
        $this->apontamentoModel = new ApontamentoModel();
    }

    public function index() {
        $apontamentos = $this->apontamentoModel->getAll();
        require_once PROJECT_ROOT . '/app/views/listar_apontamentos.php';
    }

    public function create() {
        $funcionarioModel = new FuncionarioModel();
        $veiculoModel = new VeiculoModel();

        $funcionarios = $funcionarioModel->getAll();
        $veiculos = $veiculoModel->getAll();

        require_once PROJECT_ROOT . '/app/views/form_apontamento.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'funcionario_id' => $_POST['funcionario_id'],
                'veiculo_id' => $_POST['veiculo_id'],
                'data' => $_POST['data'],
                'hora_inicio' => $_POST['hora_inicio'],
                'hora_fim' => $_POST['hora_fim'],
                'observacao' => $_POST['observacao']
            ];
            $this->apontamentoModel->create($dados);
            header('Location: ' . BASE_URL . '/apontamento');
        }
    }

    public function edit($id) {
        $apontamento = $this->apontamentoModel->getById($id);

        $funcionarioModel = new FuncionarioModel();
        $veiculoModel = new VeiculoModel();
        $funcionarios = $funcionarioModel->getAll();
        $veiculos = $veiculoModel->getAll();

        require_once PROJECT_ROOT . '/app/views/form_apontamento.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'funcionario_id' => $_POST['funcionario_id'],
                'veiculo_id' => $_POST['veiculo_id'],
                'data' => $_POST['data'],
                'hora_inicio' => $_POST['hora_inicio'],
                'hora_fim' => $_POST['hora_fim'],
                'observacao' => $_POST['observacao']
            ];
            $this->apontamentoModel->update($id, $dados);
            header('Location: ' . BASE_URL . '/apontamento');
        }
    }

    public function destroy($id) {
        $this->apontamentoModel->delete($id);
        header('Location: ' . BASE_URL . '/apontamento');
    }
}