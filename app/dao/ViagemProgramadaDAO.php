<?php

class ViagemProgramadaDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getAll() {
		$sql = "SELECT 
					vp.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa,
					tv.nome as tipo_viagem_nome
				FROM viagens_programadas vp
				JOIN funcionarios f ON vp.funcionario_id = f.id
				JOIN veiculos v ON vp.veiculo_id = v.id
				LEFT JOIN tipo_viagens tv ON vp.tipo_viagem_id = tv.id
				ORDER BY vp.data_prevista_inicio DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}

	public function getById($id) {
		$sql = "SELECT * FROM viagens_programadas WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public function findByFuncionarioIdAndStatus($funcionarioId, $status = 'Programada') {
		$sql = "SELECT * FROM viagens_programadas 
				WHERE funcionario_id = :funcionarioId AND status = :status
				ORDER BY data_prevista_inicio ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['funcionarioId' => $funcionarioId, 'status' => $status]);
		return $stmt->fetchAll();
	}

	public function create($dados) {
		$sql = "INSERT INTO viagens_programadas (titulo, tipo_viagem_id, origem, destino, data_prevista_inicio, data_prevista_fim, funcionario_id, veiculo_id, status)
				VALUES (:titulo, :tipo_viagem_id, :origem, :destino, :data_prevista_inicio, :data_prevista_fim, :funcionario_id, :veiculo_id, :status)";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function update($id, $dados) {
		$dados['id'] = $id;
		$sql = "UPDATE viagens_programadas SET 
					titulo = :titulo, tipo_viagem_id = :tipo_viagem_id, origem = :origem, destino = :destino, 
					data_prevista_inicio = :data_prevista_inicio, data_prevista_fim = :data_prevista_fim, 
					funcionario_id = :funcionario_id, veiculo_id = :veiculo_id, status = :status
				WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function updateStatus($id, $status) {
		$sql = "UPDATE viagens_programadas SET status = :status WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['status' => $status, 'id' => $id]);
	}

	public function delete($id) {
		$sql = "DELETE FROM viagens_programadas WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['id' => $id]);
	}
}