<?php

class ApontamentoModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Conexao::getConexao();
    }

    public function getAll() {
        $sql = "SELECT 
                    ap.*, 
                    f.nome as funcionario_nome, 
                    v.placa as veiculo_placa
                FROM apontamentos ap
                LEFT JOIN funcionarios f ON ap.funcionario_id = f.id
                LEFT JOIN veiculos v ON ap.veiculo_id = v.id
                ORDER BY ap.data DESC, ap.hora_inicio DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM apontamentos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($dados) {
        $sql = "INSERT INTO apontamentos (funcionario_id, veiculo_id, data, hora_inicio, hora_fim, observacao) 
                VALUES (:funcionario_id, :veiculo_id, :data, :hora_inicio, :hora_fim, :observacao)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($dados);
    }

    public function update($id, $dados) {
        $dados['id'] = $id;
        $sql = "UPDATE apontamentos SET 
                    funcionario_id = :funcionario_id, 
                    veiculo_id = :veiculo_id, 
                    data = :data, 
                    hora_inicio = :hora_inicio, 
                    hora_fim = :hora_fim, 
                    observacao = :observacao 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($dados);
    }

    public function delete($id) {
        $sql = "DELETE FROM apontamentos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}