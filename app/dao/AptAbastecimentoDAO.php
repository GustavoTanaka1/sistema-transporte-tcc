<?php

class AptAbastecimentoDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getById($id) {
		$sql = "SELECT * FROM apontamentos_abastecimento WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public function getAll() {
		$sql = "SELECT 
					ap_abs.*,
					a.hora_inicio,
					a.hora_fim,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM apontamentos_abastecimento ap_abs
				JOIN apontamentos a ON a.apontamento_especifico_id = ap_abs.id AND a.tipo_apontamento_id = (SELECT id FROM tipo_apontamentos WHERE nome = 'Abastecimento')
				JOIN boletins b ON a.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON b.veiculo_id = v.id
				ORDER BY a.hora_inicio DESC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}
}