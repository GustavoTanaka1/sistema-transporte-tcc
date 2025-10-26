<?php

require_once PROJECT_ROOT . '/app/dao/TipoViagemDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class TipoViagemController {
	private $tipoViagemDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->tipoViagemDAO = new TipoViagemDAO();
	}

	public function index() {
		$tiposViagem = $this->tipoViagemDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_tipos_viagem.php';
	}

	public function create() {
		require_once PROJECT_ROOT . '/app/views/form_tipo_viagem.php';
	}

	public function store() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			if (empty($dados['nome'])) {
				FlashMessage::set('O campo Nome é obrigatório.', 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/tipoViagem/create');
				exit();
			}

			if ($this->tipoViagemDAO->create($dados)) {
				FlashMessage::set('Tipo de Viagem criado com sucesso!');
			} else {
				FlashMessage::set('Erro ao criar o tipo de viagem.', 'danger');
			}
			header('Location: ' . BASE_URL . '/tipoViagem');
			exit();
		}
	}

	public function edit($id) {
		$tipoViagem = $this->tipoViagemDAO->getById($id);
		require_once PROJECT_ROOT . '/app/views/form_tipo_viagem.php';
	}

	public function update($id) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			if (empty($dados['nome'])) {
				FlashMessage::set('O campo Nome é obrigatório.', 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/tipoViagem/edit/' . $id);
				exit();
			}

			if ($this->tipoViagemDAO->update($id, $dados)) {
				FlashMessage::set('Tipo de Viagem atualizado com sucesso!');
			} else {
				FlashMessage::set('Erro ao atualizar.', 'danger');
			}
			header('Location: ' . BASE_URL . '/tipoViagem');
			exit();
		}
	}

	public function destroy($id) {
		if ($this->tipoViagemDAO->delete($id)) {
			FlashMessage::set('Tipo de Viagem excluído com sucesso!');
		} else {
			FlashMessage::set('Erro ao excluir.', 'danger');
		}
		header('Location: ' . BASE_URL . '/tipoViagem');
		exit();
	}
}