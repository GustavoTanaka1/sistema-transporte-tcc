<?php

require_once PROJECT_ROOT . '/app/dao/TipoParadaDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class TipoParadaController {
	private $tipoParadaDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->tipoParadaDAO = new TipoParadaDAO();
	}

	public function index() {
		$tiposParada = $this->tipoParadaDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_tipos_parada.php';
	}

	public function create() {
		require_once PROJECT_ROOT . '/app/views/form_tipo_parada.php';
	}

	public function store() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			if (empty($dados['nome'])) {
				FlashMessage::set('O campo Nome é obrigatório.', 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/tipoParada/create');
				exit();
			}

			if ($this->tipoParadaDAO->create($dados)) {
				FlashMessage::set('Tipo de Parada criado com sucesso!');
			} else {
				FlashMessage::set('Erro ao criar o tipo de parada.', 'danger');
			}
			header('Location: ' . BASE_URL . '/tipoParada');
			exit();
		}
	}

	public function edit($id) {
		$tipoParada = $this->tipoParadaDAO->getById($id);
		require_once PROJECT_ROOT . '/app/views/form_tipo_parada.php';
	}

	public function update($id) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			if (empty($dados['nome'])) {
				FlashMessage::set('O campo Nome é obrigatório.', 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/tipoParada/edit/' . $id);
				exit();
			}

			if ($this->tipoParadaDAO->update($id, $dados)) {
				FlashMessage::set('Tipo de Parada atualizado com sucesso!');
			} else {
				FlashMessage::set('Erro ao atualizar.', 'danger');
			}
			header('Location: ' . BASE_URL . '/tipoParada');
			exit();
		}
	}

	public function destroy($id) {
		if ($this->tipoParadaDAO->delete($id)) {
			FlashMessage::set('Tipo de Parada excluído com sucesso!');
		} else {
			FlashMessage::set('Erro ao excluir. Verifique se não há registros vinculados.', 'danger');
		}
		header('Location: ' . BASE_URL . '/tipoParada');
		exit();
	}
}