<?php

class UsuarioDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function findByLogin($login) {
		$sql = "SELECT * FROM usuarios WHERE login = :login";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['login' => $login]);
		return $stmt->fetch();
	}

	public function autenticar($login, $senha) {
		$usuario = $this->findByLogin($login);

		if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
			return $usuario;
		}

		return false;
	}
}