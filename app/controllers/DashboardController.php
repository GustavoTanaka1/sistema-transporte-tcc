<?php

require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';

class DashboardController {

	private $boletimDAO;
	private $apontamentoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->boletimDAO = new BoletimDAO();
		$this->apontamentoDAO = new ApontamentoDAO();
	}

	public function index() {
		$boletinsAbertos = $this->boletimDAO->getAllAbertos();
		$monitoramento = [];

		foreach ($boletinsAbertos as $boletim) {
			$atividadeAtual = $this->apontamentoDAO->findLastOpenByBoletimId($boletim['id']);
			
			$monitoramento[] = [
				'boletim' => $boletim,
				'atividade_atual' => $atividadeAtual
			];
		}

		require_once PROJECT_ROOT . '/app/views/dashboard.php';
	}
}