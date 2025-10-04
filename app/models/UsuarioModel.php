<?php

require_once PROJECT_ROOT . '/app/core/conexao.php';

class UsuarioModel {
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
}