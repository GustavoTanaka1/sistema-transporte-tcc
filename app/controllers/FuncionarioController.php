<?php

require_once PROJECT_ROOT . '/app/models/FuncionarioModel.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class FuncionarioController {
    private $funcionarioModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
        $this->funcionarioModel = new FuncionarioModel();
    }

    public function index() {
        $funcionarios = $this->funcionarioModel->getAll();
        require_once PROJECT_ROOT . '/app/views/listar_funcionarios.php';
    }

    public function create() {
        require_once PROJECT_ROOT . '/app/views/form_funcionario.php';
    }

    private function validarDados($dados, $id = null) {
        $errors = [];
        if (empty($dados['nome'])) {
            $errors[] = "O campo Nome é obrigatório.";
        }
        if (empty($dados['cargo'])) {
            $errors[] = "O campo Cargo é obrigatório.";
        }
        if (empty($dados['cpf'])) {
            $errors[] = "O campo CPF é obrigatório.";
        } else {
            $cpfExistente = $this->funcionarioModel->findByCpf($dados['cpf']);
            if ($cpfExistente && $cpfExistente['id'] != $id) {
                $errors[] = "O CPF informado já está cadastrado no sistema.";
            }
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
                header('Location: ' . BASE_URL . '/funcionario/create');
                exit();
            }
            
            if ($this->funcionarioModel->create($dados)) {
                FlashMessage::set('Funcionário cadastrado com sucesso!');
            } else {
                FlashMessage::set('Erro ao cadastrar o funcionário.', 'danger');
            }
            header('Location: ' . BASE_URL . '/funcionario');
            exit();
        }
    }

    public function edit($id) {
        $funcionario = $this->funcionarioModel->getById($id);
        require_once PROJECT_ROOT . '/app/views/form_funcionario.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = $_POST;
            $errors = $this->validarDados($dados, $id);

            if (!empty($errors)) {
                FlashMessage::set(implode('<br>', $errors), 'danger');
                $_SESSION['form_data'] = $dados;
                header('Location: ' . BASE_URL . '/funcionario/edit/' . $id);
                exit();
            }

            if ($this->funcionarioModel->update($id, $dados)) {
                FlashMessage::set('Funcionário atualizado com sucesso!');
            } else {
                FlashMessage::set('Erro ao atualizar o funcionário.', 'danger');
            }
            header('Location: ' . BASE_URL . '/funcionario');
            exit();
        }
    }

    public function destroy($id) {
        if ($this->funcionarioModel->delete($id)) {
            FlashMessage::set('Funcionário inativado com sucesso!');
        } else {
            FlashMessage::set('Erro ao inativar o funcionário.', 'danger');
        }
        header('Location: ' . BASE_URL . '/funcionario');
        exit();
    }
}