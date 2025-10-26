<?php

require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class ApontamentoController {
	private $apontamentoDAO;
	private $boletimDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			echo "Erro de autenticação.";
			exit(); 
		}
		$this->apontamentoDAO = new ApontamentoDAO();
		$this->boletimDAO = new BoletimDAO();
	}

	public function iniciarParada() {
	
	}

	public function finalizarAtividade() {
	
	}

}