<?php

require_once PROJECT_ROOT . '/app/dao/VeiculoDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class VeiculoController {
	private $veiculoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->veiculoDAO = new VeiculoDAO();
	}

	public function index() {
		$veiculos = $this->veiculoDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/listar_veiculos.php';
	}

	public function create() {
		require_once PROJECT_ROOT . '/app/views/form_veiculo.php';
	}

	private function validarDados($dados, $id = null) {
		$errors = [];
		
		if (empty($dados['placa'])) {
			$errors[] = "O campo Placa é obrigatório.";
		} else {
			$veiculoExistente = $this->veiculoDAO->findByPlaca($dados['placa']);
			if ($veiculoExistente && $veiculoExistente['id'] != $id) {
				$errors[] = "A placa informada já está cadastrada no sistema.";
			}
		}
		
		if (empty($dados['modelo'])) {
			$errors[] = "O campo Modelo é obrigatório.";
		}
		if (empty($dados['ano']) || !is_numeric($dados['ano']) || strlen($dados['ano']) != 4) {
			$errors[] = "O campo Ano deve ser um número com 4 dígitos.";
		}
		if (empty($dados['km_atual']) || !is_numeric($dados['km_atual'])) {
			$errors[] = "O campo Quilometragem é obrigatório e deve ser um número.";
		}
		return $errors;
	}

	public function store() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			$errors = $this->validarDados($dados);

			if (!empty($errors)) {
				FlashMessage::set(implode('<br>', $errors), 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/veiculo/create');
				exit();
			}

			if ($this->veiculoDAO->create($dados)) {
				FlashMessage::set('Veículo cadastrado com sucesso!');
			} else {
				FlashMessage::set('Erro ao cadastrar o veículo.', 'danger');
			}
			header('Location: ' . BASE_URL . '/veiculo');
			exit();
		}
	}

	public function edit($id) {
		$veiculo = $this->veiculoDAO->getById($id);
		require_once PROJECT_ROOT . '/app/views/form_veiculo.php';
	}

	public function update($id) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = $_POST;
			$errors = $this->validarDados($dados, $id);

			if (!empty($errors)) {
				FlashMessage::set(implode('<br>', $errors), 'danger');
				$_SESSION['form_data'] = $dados;
				header('Location: ' . BASE_URL . '/veiculo/edit/' . $id);
				exit();
			}
			
			if($this->veiculoDAO->update($id, $dados)) {
				FlashMessage::set('Veículo atualizado com sucesso!');
			} else {
				FlashMessage::set('Erro ao atualizar o veículo.', 'danger');
			}
			header('Location: ' . BASE_URL . '/veiculo');
			exit();
		}
	}

	public function destroy($id) {
		if ($this->veiculoDAO->delete($id)) {
			FlashMessage::set('Veículo inativado com sucesso!');
		} else {
			FlashMessage::set('Erro ao inativar o veículo.', 'danger');
		}
		header('Location: ' . BASE_URL . '/veiculo');
		exit();
	}
}