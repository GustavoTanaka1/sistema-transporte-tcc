<?php

require_once PROJECT_ROOT . '/app/dao/UsuarioDAO.php';

class LoginController {

	public function index() {
		require_once PROJECT_ROOT . '/app/views/login.php';
	}

	public function autenticar() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$usuarioDAO = new UsuarioDAO();
			$usuario = $usuarioDAO->autenticar($_POST['login'], $_POST['senha']);

			if ($usuario) {
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