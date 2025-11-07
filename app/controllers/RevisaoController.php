<?php

require_once PROJECT_ROOT . '/app/dao/RevisaoDAO.php';
require_once PROJECT_ROOT . '/app/dao/VeiculoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class RevisaoController {
	private $revisaoDAO;
	private $veiculoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->revisaoDAO = new RevisaoDAO();
		$this->veiculoDAO = new VeiculoDAO();
	}

	public function index() {
		$veiculos = $this->veiculoDAO->getAll();
		$resultados = null;
		$filtroInfo = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_revisoes'])) {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];
			$veiculoId = $_POST['veiculo_id'] ?: null;
			$urgencia = $_POST['urgencia'] ?: null;

			$veiculoNome = "Todos os Veículos";
			if ($veiculoId) {
				$veic = $this->veiculoDAO->getById($veiculoId);
				if ($veic) $veiculoNome = $veic['placa'] . ' - ' . $veic['modelo'];
			}
			$filtroInfo = [
				'dataInicio' => $dataInicio,
				'dataFim' => $dataFim,
				'veiculoNome' => $veiculoNome,
				'urgencia' => $urgencia ?: 'Todas'
			];

			$resultados = $this->revisaoDAO->getAllFiltrado($dataInicio, $dataFim, $veiculoId, $urgencia);
		} else {
			$resultados = $this->revisaoDAO->getAll();
		}

		$revisoes = $resultados;
		require_once PROJECT_ROOT . '/app/views/listar_revisoes.php';
	}
	
	public function setStatus($id, $status) {
		$statusMap = [
			'1' => 'Em Andamento',
			'2' => 'Concluída'
		];
		
		$statusValido = $statusMap[$status] ?? 'Pendente';

		if ($this->revisaoDAO->updateStatus($id, $statusValido)) {
			FlashMessage::set('Status da revisão atualizado com sucesso!');
		} else {
			FlashMessage::set('Erro ao atualizar o status.', 'danger');
		}
		header('Location: ' . BASE_URL . '/revisao');
		exit();
	}
}