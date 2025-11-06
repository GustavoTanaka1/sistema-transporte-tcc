<?php

class RevisaoDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function create($dados) {
		$sql = "INSERT INTO apontamentos_revisao (boletim_id, veiculo_id, km_veiculo, tipo_revisao, descricao_problema, urgencia) 
				VALUES (:boletim_id, :veiculo_id, :km_veiculo, :tipo_revisao, :descricao_problema, :urgencia)";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function getAll() {
		$sql = "SELECT 
					rev.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM apontamentos_revisao rev
				JOIN boletins b ON rev.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON rev.veiculo_id = v.id
				ORDER BY rev.data_registro DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}

	public function getAllByBoletimId($boletimId) {
		$sql = "SELECT * FROM apontamentos_revisao WHERE boletim_id = :boletimId ORDER BY data_registro ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['boletimId' => $boletimId]);
		return $stmt->fetchAll();
	}
}