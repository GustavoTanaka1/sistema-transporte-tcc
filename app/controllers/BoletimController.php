<?php

require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/dao/ViagemProgramadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/AptParadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/AptAbastecimentoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class BoletimController {
	private $boletimDAO;
	private $apontamentoDAO;
	private $viagemDAO;
	private $paradaDAO;
	private $abastecimentoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->boletimDAO = new BoletimDAO();
		$this->apontamentoDAO = new ApontamentoDAO();
		$this->viagemDAO = new ViagemProgramadaDAO();
		$this->paradaDAO = new AptParadaDAO();
		$this->abastecimentoDAO = new AptAbastecimentoDAO();
	}

	public function index() {
		$boletins = $this->boletimDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_boletins.php';
	}

	public function detalhes($id) {
		$boletim = $this->boletimDAO->getById($id);
		if (!$boletim) {
			FlashMessage::set('Boletim não encontrado.', 'danger');
			header('Location: ' . BASE_URL . '/boletim');
			exit();
		}

		$apontamentosLog = $this->apontamentoDAO->getByBoletimId($id);
		$apontamentosEnriquecidos = [];

		foreach ($apontamentosLog as $apontamento) {
			$detalhes = [];
			if ($apontamento['viagem_programada_id']) {
				$detalhes = $this->viagemDAO->getById($apontamento['viagem_programada_id']);
			} elseif ($apontamento['apontamento_especifico_id']) {
				
				if ($apontamento['tipo_apontamento_nome'] == 'Parada') {
					$detalhes = $this->paradaDAO->getById($apontamento['apontamento_especifico_id']);
				} elseif ($apontamento['tipo_apontamento_nome'] == 'Abastecimento') {
					$detalhes = $this->abastecimentoDAO->getById($apontamento['apontamento_especifico_id']);
				}
			}
			$apontamentosEnriquecidos[] = array_merge($apontamento, ['detalhes' => $detalhes]);
		}

		$apontamentos = $apontamentosEnriquecidos;
		require_once PROJECT_ROOT . '/app/views/detalhes_boletim.php';
	}
}