<?php

require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class BoletimController {
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
		$boletins = $this->boletimDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_boletins.php';
	}

	public function detalhes($id) {
		$boletim = $this->boletimDAO->getById($id);
		$apontamentos = $this->apontamentoDAO->getByBoletimId($id);

		if (!$boletim) {
			FlashMessage::set('Boletim não encontrado.', 'danger');
			header('Location: ' . BASE_URL . '/boletim');
			exit();
		}

		require_once PROJECT_ROOT . '/app/views/detalhes_boletim.php';
	}
}