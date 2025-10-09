<?php
    
class VeiculoModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    public function getAll() {
        $sql = "SELECT * FROM veiculos ORDER BY id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM veiculos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function findByPlaca($placa) {
        $sql = "SELECT id FROM veiculos WHERE placa = :placa";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['placa' => $placa]);
        return $stmt->fetch();
    }

    public function create($dados) {
        $sql = "INSERT INTO veiculos (placa, modelo, ano, km_atual, status) VALUES (:placa, :modelo, :ano, :km_atual, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($dados);
    }

    public function update($id, $dados) {
        $dados['id'] = $id;
        $sql = "UPDATE veiculos SET placa = :placa, modelo = :modelo, ano = :ano, km_atual = :km_atual, status = :status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($dados);
    }

    public function delete($id) {
        $sql = "UPDATE veiculos SET status = 'inativo' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}