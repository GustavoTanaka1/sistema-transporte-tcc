<?php

require_once PROJECT_ROOT . '/app/dao/AptAbastecimentoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class AptAbastecimentoController {
	private $abastecimentoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->abastecimentoDAO = new AptAbastecimentoDAO();
	}

	public function index() {
		$abastecimentos = $this->abastecimentoDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_abastecimentos.php';
	}
}