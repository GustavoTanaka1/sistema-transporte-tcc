<?php

class BoletimDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getAll() {
		$sql = "SELECT 
					b.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM boletins b
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON b.veiculo_id = v.id
				ORDER BY b.data_abertura DESC, b.hora_abertura DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}

	public function getAllAbertos() {
		$sql = "SELECT 
					b.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM boletins b
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON b.veiculo_id = v.id
				WHERE b.status = 'Aberto'
				ORDER BY f.nome ASC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}

	public function getById($id) {
		$sql = "SELECT 
					b.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa,
					v.modelo as veiculo_modelo
				FROM boletins b
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON b.veiculo_id = v.id
				WHERE b.id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public function getBoletimAbertoPorFuncionario($funcionarioId) {
		$sql = "SELECT * FROM boletins 
				WHERE funcionario_id = :funcionarioId AND status = 'Aberto'
				ORDER BY data_abertura DESC, hora_abertura DESC
				LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['funcionarioId' => $funcionarioId]);
		return $stmt->fetch();
	}

	public function create($dados) {
		$sql = "INSERT INTO boletins (funcionario_id, veiculo_id, data_abertura, hora_abertura, km_inicial, status) 
				VALUES (:funcionario_id, :veiculo_id, CURDATE(), CURTIME(), :km_inicial, 'Aberto')";
		$stmt = $this->pdo->prepare($sql);
		
		if ($stmt->execute($dados)) {
			return $this->pdo->lastInsertId();
		}
		return false;
	}

	public function fecharBoletim($boletimId, $kmFinal) {
		$sql = "UPDATE boletins 
				SET data_fechamento = CURDATE(), hora_fechamento = CURTIME(), km_final = :km_final, status = 'Fechado'
				WHERE id = :id AND status = 'Aberto'";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['km_final' => $kmFinal, 'id' => $boletimId]);
	}
}