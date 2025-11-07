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
				LEFT JOIN boletins b ON rev.boletim_id = b.id
				LEFT JOIN funcionarios f ON b.funcionario_id = f.id
				LEFT JOIN veiculos v ON rev.veiculo_id = v.id
				ORDER BY rev.data_registro DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}
	
	public function getAllFiltrado($dataInicio, $dataFim, $veiculoId = null, $urgencia = null) {
		$sql = "SELECT 
					rev.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM apontamentos_revisao rev
				LEFT JOIN boletins b ON rev.boletim_id = b.id
				LEFT JOIN funcionarios f ON b.funcionario_id = f.id
				LEFT JOIN veiculos v ON rev.veiculo_id = v.id
				WHERE rev.data_registro BETWEEN :dataInicio AND :dataFim";
		
		$params = [
			'dataInicio' => $dataInicio . ' 00:00:00',
			'dataFim' => $dataFim . ' 23:59:59'
		];

		if ($veiculoId) {
			$sql .= " AND rev.veiculo_id = :veiculoId";
			$params['veiculoId'] = $veiculoId;
		}
		if ($urgencia) {
			$sql .= " AND rev.urgencia = :urgencia";
			$params['urgencia'] = $urgencia;
		}

		$sql .= " ORDER BY rev.data_registro DESC";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll();
	}

	public function getAllByBoletimId($boletimId) {
		$sql = "SELECT * FROM apontamentos_revisao WHERE boletim_id = :boletimId ORDER BY data_registro ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['boletimId' => $boletimId]);
		return $stmt->fetchAll();
	}

	public function countRevisoesUrgentesPendentes() {
		$sql = "SELECT COUNT(id) FROM apontamentos_revisao WHERE urgencia = 'Alta' AND status_revisao = 'Pendente'";
		$stmt = $this->pdo->query($sql);
		return (int)$stmt->fetchColumn();
	}
	
	public function updateStatus($id, $status) {
		$sql = "UPDATE apontamentos_revisao SET status_revisao = :status WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['status' => $status, 'id' => $id]);
	}
}