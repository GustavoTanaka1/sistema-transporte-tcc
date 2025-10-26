<?php

require_once PROJECT_ROOT . '/app/dao/ViagemProgramadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/FuncionarioDAO.php';
require_once PROJECT_ROOT . '/app/dao/VeiculoDAO.php';
require_once PROJECT_ROOT . '/app/dao/TipoViagemDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class ViagemProgramadaController {
	private $viagemDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->viagemDAO = new ViagemProgramadaDAO();
	}

	public function index() {
		$viagens = $this->viagemDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_viagens_programadas.php';
	}

	private function getDadosFormulario() {
		$funcionarioDAO = new FuncionarioDAO();
		$veiculoDAO = new VeiculoDAO();
		$tipoViagemDAO = new TipoViagemDAO();

		return [
			'funcionarios' => $funcionarioDAO->getAll(),
			'veiculos' => $veiculoDAO->getAll(),
			'tiposViagem' => $tipoViagemDAO->getAll()
		];
	}

	public function create() {
		$dadosFormulario = $this->getDadosFormulario();
		extract($dadosFormulario);
		require_once PROJECT_ROOT . '/app/views/form_viagem_programada.php';
	}

	public function store() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			
			if ($this->viagemDAO->create($dados)) {
				FlashMessage::set('Viagem programada com sucesso!');
			} else {
				FlashMessage::set('Erro ao programar a viagem.', 'danger');
			}
			header('Location: ' . BASE_URL . '/viagemProgramada');
			exit();
		}
	}

	public function edit($id) {
		$viagemProgramada = $this->viagemDAO->getById($id);
		$dadosFormulario = $this->getDadosFormulario();
		extract($dadosFormulario);
		require_once PROJECT_ROOT . '/app/views/form_viagem_programada.php';
	}

	public function update($id) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			
			if ($this->viagemDAO->update($id, $dados)) {
				FlashMessage::set('Viagem atualizada com sucesso!');
			} else {
				FlashMessage::set('Erro ao atualizar a viagem.', 'danger');
			}
			header('Location: ' . BASE_URL . '/viagemProgramada');
			exit();
		}
	}

	public function destroy($id) {
		if ($this->viagemDAO->delete($id)) {
			FlashMessage::set('Viagem programada excluída com sucesso!');
		} else {
			FlashMessage::set('Erro ao excluir a viagem.', 'danger');
		}
		header('Location: ' . BASE_URL . '/viagemProgramada');
		exit();
	}
}