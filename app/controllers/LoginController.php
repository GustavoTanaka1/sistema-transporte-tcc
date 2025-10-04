<?php

require_once PROJECT_ROOT . '/app/models/UsuarioModel.php';

class LoginController {
    
    public function index() {
        require_once PROJECT_ROOT . '/app/views/login.php';
    }

    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? null;
            $senha = $_POST['senha'] ?? null;

            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->findByLogin($login);

            if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_login'] = $usuario['login'];
                header('Location: ' . BASE_URL . '/dashboard');
                exit();
            } else {
                header('Location: ' . BASE_URL);
                exit();
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL);
        exit();
    }
}