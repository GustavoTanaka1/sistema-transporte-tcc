<?php

class RotaDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function create($dados) {
		$sql = "INSERT INTO rotas (boletim_id, apontamento_id, destino, hora_chegada, hora_saida, status_entrega, observacao) 
				VALUES (:boletim_id, :apontamento_id, :destino, CURTIME(), NULL, :status_entrega, :observacao)";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function getAll() {
		$sql = "SELECT 
					r.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa,
					a.viagem_programada_id 
				FROM rotas r
				JOIN boletins b ON r.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON b.veiculo_id = v.id
				LEFT JOIN apontamentos a ON r.apontamento_id = a.id
				ORDER BY r.data_registro DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}
	
	public function getAllByBoletimId($boletimId) {
		$sql = "SELECT * FROM rotas WHERE boletim_id = :boletimId ORDER BY data_registro ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['boletimId' => $boletimId]);
		return $stmt->fetchAll();
	}
}