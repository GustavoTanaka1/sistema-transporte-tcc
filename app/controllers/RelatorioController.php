<?php

require_once PROJECT_ROOT . '/app/dao/RelatorioDAO.php';
require_once PROJECT_ROOT . '/app/dao/FuncionarioDAO.php';

class RelatorioController {
	
	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
	}

	public function index() {
		$funcionarioDAO = new FuncionarioDAO();
		$funcionarios = $funcionarioDAO->getAll();
		$resultados = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];
			$funcionarioId = $_POST['funcionario_id'] ?: null;
			
			$relatorioDAO = new RelatorioDAO();
			$resultados = $relatorioDAO->getProdutividadePorFuncionario($dataInicio, $dataFim, $funcionarioId);
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_produtividade.php';
	}

	public function exportarPdf() {
	}
}