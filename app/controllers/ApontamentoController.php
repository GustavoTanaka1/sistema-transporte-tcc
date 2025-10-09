<?php

require_once PROJECT_ROOT . '/app/models/ApontamentoModel.php';
require_once PROJECT_ROOT . '/app/models/FuncionarioModel.php';
require_once PROJECT_ROOT . '/app/models/VeiculoModel.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class ApontamentoController {
    private $apontamentoModel;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL);
            exit();
        }
        $this->apontamentoModel = new ApontamentoModel();
    }

    public function index() {
        $apontamentos = $this->apontamentoModel->getAll();
        require_once PROJECT_ROOT . '/app/views/listar_apontamentos.php';
    }

    public function create() {
        $funcionarioModel = new FuncionarioModel();
        $veiculoModel = new VeiculoModel();
        $funcionarios = $funcionarioModel->getAll();
        $veiculos = $veiculoModel->getAll();
        require_once PROJECT_ROOT . '/app/views/form_apontamento.php';
    }

    private function validarDados($dados) {
        $errors = [];
        if (empty($dados['funcionario_id'])) $errors[] = "Selecione um funcionário.";
        if (empty($dados['veiculo_id'])) $errors[] = "Selecione um veículo.";
        if (empty($dados['data'])) $errors[] = "O campo Data é obrigatório.";
        if (empty($dados['hora_inicio'])) $errors[] = "O campo Hora de Início é obrigatório.";
        if (empty($dados['hora_fim'])) $errors[] = "O campo Hora de Fim é obrigatório.";
        if (!empty($dados['hora_inicio']) && !empty($dados['hora_fim']) && $dados['hora_fim'] <= $dados['hora_inicio']) {
            $errors[] = "A Hora de Fim deve ser maior que a Hora de Início.";
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
                header('Location: ' . BASE_URL . '/apontamento/create');
                exit();
            }

            if ($this->apontamentoModel->create($dados)) {
                FlashMessage::set('Apontamento lançado com sucesso!');
            } else {
                FlashMessage::set('Erro ao lançar o apontamento.', 'danger');
            }
            header('Location: ' . BASE_URL . '/apontamento');
            exit();
        }
    }

    public function edit($id) {
        $apontamento = $this->apontamentoModel->getById($id);
        $funcionarioModel = new FuncionarioModel();
        $veiculoModel = new VeiculoModel();
        $funcionarios = $funcionarioModel->getAll();
        $veiculos = $veiculoModel->getAll();
        require_once PROJECT_ROOT . '/app/views/form_apontamento.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = $_POST;
            $errors = $this->validarDados($dados);
            
            if (!empty($errors)) {
                FlashMessage::set(implode('<br>', $errors), 'danger');
                $_SESSION['form_data'] = $dados;
                header('Location: ' . BASE_URL . '/apontamento/edit/' . $id);
                exit();
            }

            if ($this->apontamentoModel->update($id, $dados)) {
                FlashMessage::set('Apontamento atualizado com sucesso!');
            } else {
                FlashMessage::set('Erro ao atualizar o apontamento.', 'danger');
            }
            header('Location: ' . BASE_URL . '/apontamento');
            exit();
        }
    }

    public function destroy($id) {
        if ($this->apontamentoModel->delete($id)) {
            FlashMessage::set('Apontamento excluído com sucesso!');
        } else {
            FlashMessage::set('Erro ao excluir o apontamento.', 'danger');
        }
        header('Location: ' . BASE_URL . '/apontamento');
        exit();
    }
}