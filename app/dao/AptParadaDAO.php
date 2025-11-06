<?php

class AptParadaDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getById($id) {
		$sql = "SELECT 
					ap.*,
					tp.nome as tipo_parada_nome
				FROM apontamentos_parada ap
				JOIN tipo_paradas tp ON ap.tipo_parada_id = tp.id
				WHERE ap.id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public function getAll() {
		$sql = "SELECT 
					ap_parada.*,
					tp.nome as tipo_parada_nome,
					a.hora_inicio,
					a.hora_fim,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM apontamentos_parada ap_parada
				JOIN apontamentos a ON a.apontamento_especifico_id = ap_parada.id AND a.tipo_apontamento_id = (SELECT id FROM tipo_apontamentos WHERE nome = 'Parada')
				JOIN boletins b ON a.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON b.veiculo_id = v.id
				JOIN tipo_paradas tp ON ap_parada.tipo_parada_id = tp.id
				ORDER BY a.hora_inicio DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}
}