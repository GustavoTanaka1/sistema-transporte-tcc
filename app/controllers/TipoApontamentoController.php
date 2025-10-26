<?php

require_once PROJECT_ROOT . '/app/dao/TipoApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class TipoApontamentoController {
	private $tipoApontamentoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->tipoApontamentoDAO = new TipoApontamentoDAO();
	}

	public function index() {
		$tiposApontamento = $this->tipoApontamentoDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_tipos_apontamento.php';
	}

	public function create() {
		$tabelasDisponiveis = $this->tipoApontamentoDAO->getApontamentoDetailTables();
		require_once PROJECT_ROOT . '/app/views/form_tipo_apontamento.php';
	}

	public function store() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			if (empty($dados['nome'])) {
				FlashMessage::set('O campo Nome é obrigatório.', 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/tipoApontamento/create');
				exit();
			}

			if ($this->tipoApontamentoDAO->create($dados)) {
				FlashMessage::set('Tipo de Apontamento criado com sucesso!');
			} else {
				FlashMessage::set('Erro ao criar o tipo de apontamento.', 'danger');
			}
			header('Location: ' . BASE_URL . '/tipoApontamento');
			exit();
		}
	}

	public function edit($id) {
		$tipoApontamento = $this->tipoApontamentoDAO->getById($id);
		$tabelasDisponiveis = $this->tipoApontamentoDAO->getApontamentoDetailTables();
		require_once PROJECT_ROOT . '/app/views/form_tipo_apontamento.php';
	}

	public function update($id) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			if (empty($dados['nome'])) {
				FlashMessage::set('O campo Nome é obrigatório.', 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/tipoApontamento/edit/' . $id);
				exit();
			}

			if ($this->tipoApontamentoDAO->update($id, $dados)) {
				FlashMessage::set('Tipo de Apontamento atualizado com sucesso!');
			} else {
				FlashMessage::set('Erro ao atualizar.', 'danger');
			}
			header('Location: ' . BASE_URL . '/tipoApontamento');
			exit();
		}
	}

	public function destroy($id) {
		if ($this->tipoApontamentoDAO->delete($id)) {
			FlashMessage::set('Tipo de Apontamento excluído com sucesso!');
		} else {
			FlashMessage::set('Erro ao excluir. Verifique se não há registros vinculados.', 'danger');
		}
		header('Location: ' . BASE_URL . '/tipoApontamento');
		exit();
	}
}