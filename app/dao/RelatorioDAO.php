<?php

class RelatorioDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getTempoPorTipoApontamento($dataInicio, $dataFim, $funcionarioId = null) {
		$sql = "SELECT 
					f.nome as funcionario_nome,
					ta.nome as tipo_apontamento_nome,
					SEC_TO_TIME(SUM(IF(a.hora_fim < a.hora_inicio, 
									(TIME_TO_SEC('24:00:00') - TIME_TO_SEC(a.hora_inicio)) + TIME_TO_SEC(a.hora_fim), 
									TIME_TO_SEC(a.hora_fim) - TIME_TO_SEC(a.hora_inicio))
								)) as tempo_total
				FROM apontamentos a
				JOIN tipo_apontamentos ta ON a.tipo_apontamento_id = ta.id
				JOIN boletins b ON a.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				WHERE b.data_abertura BETWEEN :dataInicio AND :dataFim
				AND a.status = 'Finalizado'";
		
		$params = [
			'dataInicio' => $dataInicio,
			'dataFim' => $dataFim
		];

		if ($funcionarioId) {
			$sql .= " AND b.funcionario_id = :funcionarioId";
			$params['funcionarioId'] = $funcionarioId;
		}

		$sql .= " GROUP BY f.nome, ta.nome ORDER BY f.nome, tempo_total DESC";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll();
	}

	public function getRelatorioConsumo($dataInicio, $dataFim, $veiculoId = null) {
		$sql = "SELECT
					v.id as veiculo_id, 
					v.placa, 
					v.modelo,
					SUM(b.km_final - b.km_inicial) as total_km_rodado,
					(
						SELECT SUM(aa.litros) 
						FROM apontamentos_abastecimento aa
						JOIN apontamentos a ON a.apontamento_especifico_id = aa.id 
											AND a.tipo_apontamento_id = (SELECT id FROM tipo_apontamentos WHERE nome = 'Abastecimento')
						JOIN boletins b_abs ON a.boletim_id = b_abs.id
						WHERE b_abs.veiculo_id = v.id 
						AND b_abs.data_abertura BETWEEN :dataInicioSub AND :dataFimSub
					) as total_litros
				FROM boletins b
				JOIN veiculos v ON b.veiculo_id = v.id
				WHERE
					b.status = 'Fechado'
					AND b.data_fechamento BETWEEN :dataInicio AND :dataFim";
		
		$params = [
			'dataInicio' => $dataInicio,
			'dataFim' => $dataFim,
			'dataInicioSub' => $dataInicio,
			'dataFimSub' => $dataFim
		];
		
		if ($veiculoId) {
			$sql .= " AND v.id = :veiculoId";
			$params['veiculoId'] = $veiculoId;
		}

		$sql .= " GROUP BY v.id, v.placa, v.modelo";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll();
	}

	public function getTempoTotalPorTipoParada($dataInicio, $dataFim, $tipoParadaId = null, $funcionarioId = null) {
		$sql = "SELECT 
					tp.nome as tipo_parada_nome,
					COUNT(ap_parada.id) as total_ocorrencias,
					SEC_TO_TIME(SUM(IF(a.hora_fim < a.hora_inicio, 
									(TIME_TO_SEC('24:00:00') - TIME_TO_SEC(a.hora_inicio)) + TIME_TO_SEC(a.hora_fim), 
									TIME_TO_SEC(a.hora_fim) - TIME_TO_SEC(a.hora_inicio))
								)) as tempo_total
				FROM apontamentos_parada ap_parada
				JOIN tipo_paradas tp ON ap_parada.tipo_parada_id = tp.id
				JOIN apontamentos a ON a.apontamento_especifico_id = ap_parada.id AND a.tipo_apontamento_id = (SELECT id FROM tipo_apontamentos WHERE nome = 'Parada')
				JOIN boletins b ON a.boletim_id = b.id
				WHERE b.data_abertura BETWEEN :dataInicio AND :dataFim
				AND a.status = 'Finalizado'";

		$params = [
			'dataInicio' => $dataInicio,
			'dataFim' => $dataFim
		];

		if ($tipoParadaId) {
			$sql .= " AND tp.id = :tipoParadaId";
			$params['tipoParadaId'] = $tipoParadaId;
		}
		
		if ($funcionarioId) {
			$sql .= " AND b.funcionario_id = :funcionarioId";
			$params['funcionarioId'] = $funcionarioId;
		}

		$sql .= " GROUP BY tp.nome ORDER BY tempo_total DESC";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll();
	}

	public function getRelatorioRevisoes($dataInicio, $dataFim, $veiculoId = null, $urgencia = null) {
		$sql = "SELECT 
					rev.*,
					f.nome as funcionario_nome,
					v.placa as veiculo_placa
				FROM apontamentos_revisao rev
				JOIN boletins b ON rev.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				JOIN veiculos v ON rev.veiculo_id = v.id
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

	public function getJornadasExtensas($dataInicio, $dataFim, $limiteHoras = '10:00:00') {
		$sql = "SELECT
					b.id as boletim_id,
					f.nome as funcionario_nome,
					b.data_abertura,
					SEC_TO_TIME(TIMESTAMPDIFF(SECOND, 
								CONCAT(b.data_abertura, ' ', b.hora_abertura), 
								CONCAT(b.data_fechamento, ' ', b.hora_fechamento)
					)) as duracao_total
				FROM boletins b
				JOIN funcionarios f ON b.funcionario_id = f.id
				WHERE b.status = 'Fechado'
				AND b.data_fechamento BETWEEN :dataInicio AND :dataFim
				HAVING duracao_total > :limiteHoras";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			'dataInicio' => $dataInicio,
			'dataFim' => $dataFim,
			'limiteHoras' => $limiteHoras
		]);
		return $stmt->fetchAll();
	}

	public function getParadasLongas($dataInicio, $dataFim, $tipoParadaNome = 'Refeição', $limiteTempo = '01:30:00') {
		$sql = "SELECT 
					f.nome as funcionario_nome,
					b.id as boletim_id,
					b.data_abertura,
					SEC_TO_TIME(IF(a.hora_fim < a.hora_inicio, 
								(TIME_TO_SEC('24:00:00') - TIME_TO_SEC(a.hora_inicio)) + TIME_TO_SEC(a.hora_fim), 
								TIME_TO_SEC(a.hora_fim) - TIME_TO_SEC(a.hora_inicio))
							) as duracao_parada
				FROM apontamentos a
				JOIN tipo_apontamentos ta ON a.tipo_apontamento_id = ta.id AND ta.nome = 'Parada'
				JOIN apontamentos_parada ap ON a.apontamento_especifico_id = ap.id
				JOIN tipo_paradas tp ON ap.tipo_parada_id = tp.id AND tp.nome = :tipoParadaNome
				JOIN boletins b ON a.boletim_id = b.id
				JOIN funcionarios f ON b.funcionario_id = f.id
				WHERE b.data_abertura BETWEEN :dataInicio AND :dataFim
				AND a.status = 'Finalizado'
				HAVING duracao_parada > :limiteTempo";
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			'dataInicio' => $dataInicio,
			'dataFim' => $dataFim,
			'tipoParadaNome' => $tipoParadaNome,
			'limiteTempo' => $limiteTempo
		]);
		return $stmt->fetchAll();
	}
}