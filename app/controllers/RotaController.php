<?php

require_once PROJECT_ROOT . '/app/dao/RotaDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class RotaController {
	private $rotaDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->rotaDAO = new RotaDAO();
	}

	public function index() {
		$rotas = $this->rotaDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_rotas.php';
	}
}