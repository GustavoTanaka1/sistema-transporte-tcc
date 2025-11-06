<?php

require_once PROJECT_ROOT . '/app/dao/RevisaoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class RevisaoController {
	private $revisaoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->revisaoDAO = new RevisaoDAO();
	}

	public function index() {
		$revisoes = $this->revisaoDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_revisoes.php';
	}
}