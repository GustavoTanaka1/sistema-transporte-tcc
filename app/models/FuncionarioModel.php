<?php

class FuncionarioModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    public function getAll() {
        $sql = "SELECT * FROM funcionarios ORDER BY nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM funcionarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function findByCpf($cpf) {
        $sql = "SELECT id FROM funcionarios WHERE cpf = :cpf";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['cpf' => $cpf]);
        return $stmt->fetch();
    }

    public function create($dados) {
        $sql = "INSERT INTO funcionarios (nome, cargo, cpf, telefone, status) VALUES (:nome, :cargo, :cpf, :telefone, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($dados);
    }

    public function update($id, $dados) {
        $dados['id'] = $id;
        $sql = "UPDATE funcionarios SET nome = :nome, cargo = :cargo, cpf = :cpf, telefone = :telefone, status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($dados);
    }

    public function delete($id) {
        $sql = "UPDATE funcionarios SET status = 'inativo' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}