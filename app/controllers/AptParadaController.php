<?php

require_once PROJECT_ROOT . '/app/dao/AptParadaDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class AptParadaController {
	private $paradaDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->paradaDAO = new AptParadaDAO();
	}

	public function index() {
		$paradas = $this->paradaDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_paradas.php';
	}
}