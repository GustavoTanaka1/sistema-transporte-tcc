<?php

require_once PROJECT_ROOT . '/app/models/FuncionarioModel.php';

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

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'],
                'cargo' => $_POST['cargo'],
                'cpf' => $_POST['cpf'],
                'telefone' => $_POST['telefone'],
                'status' => $_POST['status']
            ];

            $cpfExistente = $this->funcionarioModel->findByCpf($dados['cpf']);
            if ($cpfExistente) {
                echo "Erro: CPF já cadastrado.";
                exit();
            }

            $this->funcionarioModel->create($dados);
            header('Location: ' . BASE_URL . '/funcionario');
        }
    }

    public function edit($id) {
        $funcionario = $this->funcionarioModel->getById($id);
        require_once PROJECT_ROOT . '/app/views/form_funcionario.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome' => $_POST['nome'],
                'cargo' => $_POST['cargo'],
                'cpf' => $_POST['cpf'],
                'telefone' => $_POST['telefone'],
                'status' => $_POST['status']
            ];
            $this->funcionarioModel->update($id, $dados);
            header('Location: ' . BASE_URL . '/funcionario');
        }
    }

    public function destroy($id) {
        $this->funcionarioModel->delete($id);
        header('Location: ' . BASE_URL . '/funcionario');
    }
}