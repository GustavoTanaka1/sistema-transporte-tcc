<?php

require_once PROJECT_ROOT . '/app/models/RelatorioModel.php';
require_once PROJECT_ROOT . '/app/models/FuncionarioModel.php';

class RelatorioController {

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
    }

    public function index() {
        $funcionarioModel = new FuncionarioModel();
        $funcionarios = $funcionarioModel->getAll();

        $resultados = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataInicio = $_POST['data_inicio'];
            $dataFim = $_POST['data_fim'];
            $funcionarioId = $_POST['funcionario_id'] ?: null;

            $relatorioModel = new RelatorioModel();
            $resultados = $relatorioModel->getProdutividadePorFuncionario($dataInicio, $dataFim, $funcionarioId);
        }

        require_once PROJECT_ROOT . '/app/views/relatorio_produtividade.php';
    }
}