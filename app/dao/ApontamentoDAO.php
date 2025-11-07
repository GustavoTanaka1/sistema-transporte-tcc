<?php

class ApontamentoDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getByBoletimId($boletimId) {
		$sql = "SELECT 
					a.*,
					ta.nome as tipo_apontamento_nome
				FROM apontamentos a
				JOIN tipo_apontamentos ta ON a.tipo_apontamento_id = ta.id
				WHERE a.boletim_id = :boletimId
				ORDER BY a.hora_inicio ASC";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['boletimId' => $boletimId]);
		return $stmt->fetchAll();
	}

	public function findLastOpenByBoletimId($boletimId) {
		$sql = "SELECT 
					a.*,
					ta.nome as tipo_apontamento_nome 
				FROM apontamentos a
				JOIN tipo_apontamentos ta ON a.tipo_apontamento_id = ta.id
				WHERE a.boletim_id = :boletimId AND a.status = 'Em andamento'
				ORDER BY a.hora_inicio DESC
				LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['boletimId' => $boletimId]);
		return $stmt->fetch();
	}

	public function countAtividadesEmAndamentoPorTipo($tipoNome) {
		$sql = "SELECT COUNT(a.id)
				FROM apontamentos a
				JOIN tipo_apontamentos ta ON a.tipo_apontamento_id = ta.id
				WHERE a.status = 'Em andamento' AND ta.nome = :tipoNome";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['tipoNome' => $tipoNome]);
		return (int)$stmt->fetchColumn();
	}

	public function finalizeApontamento($apontamentoId) {
		$sql = "UPDATE apontamentos 
				SET hora_fim = CURTIME(), status = 'Finalizado' 
				WHERE id = :id AND status = 'Em andamento'";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['id' => $apontamentoId]);
	}

	public function createParadaApontamento($boletimId, $tipoParadaId, $observacao) {
		try {
			$this->pdo->beginTransaction();

			$sqlParada = "INSERT INTO apontamentos_parada (tipo_parada_id, observacao) VALUES (:tipo_parada_id, :observacao)";
			$stmtParada = $this->pdo->prepare($sqlParada);
			$stmtParada->execute(['tipo_parada_id' => $tipoParadaId, 'observacao' => $observacao]);
			$apontamentoEspecificoId = $this->pdo->lastInsertId();

			$sqlTipo = "SELECT id FROM tipo_apontamentos WHERE nome = 'Parada' LIMIT 1";
			$tipoApontamentoId = $this->pdo->query($sqlTipo)->fetchColumn();
			if (!$tipoApontamentoId) throw new Exception("Tipo 'Parada' não encontrado.");

			$sqlApontamento = "INSERT INTO apontamentos (boletim_id, tipo_apontamento_id, apontamento_especifico_id, hora_inicio, status) 
							VALUES (:boletim_id, :tipo_apontamento_id, :apontamento_especifico_id, CURTIME(), 'Em andamento')";
			$stmtApontamento = $this->pdo->prepare($sqlApontamento);
			$stmtApontamento->execute([
				'boletim_id' => $boletimId,
				'tipo_apontamento_id' => $tipoApontamentoId,
				'apontamento_especifico_id' => $apontamentoEspecificoId
			]);
			
			$this->pdo->commit();
			return true;

		} catch (Exception $e) {
			$this->pdo->rollBack();
			error_log("Erro ao criar apontamento de parada: " . $e->getMessage());
			return false;
		}
	}

	public function createAbastecimentoApontamento($boletimId, $local, $litros, $valor, $km) {
		try {
			$this->pdo->beginTransaction();

			$sqlAbastecimento = "INSERT INTO apontamentos_abastecimento (local, litros, valor, km) VALUES (:local, :litros, :valor, :km)";
			$stmtAbastecimento = $this->pdo->prepare($sqlAbastecimento);
			$stmtAbastecimento->execute(['local' => $local, 'litros' => $litros, 'valor' => $valor, 'km' => $km]);
			$apontamentoEspecificoId = $this->pdo->lastInsertId();

			$sqlTipo = "SELECT id FROM tipo_apontamentos WHERE nome = 'Abastecimento' LIMIT 1";
			$tipoApontamentoId = $this->pdo->query($sqlTipo)->fetchColumn();
			if (!$tipoApontamentoId) throw new Exception("Tipo 'Abastecimento' não encontrado.");

			$sqlApontamento = "INSERT INTO apontamentos (boletim_id, tipo_apontamento_id, apontamento_especifico_id, hora_inicio, status) 
							VALUES (:boletim_id, :tipo_apontamento_id, :apontamento_especifico_id, CURTIME(), 'Em andamento')";
			$stmtApontamento = $this->pdo->prepare($sqlApontamento);
			$stmtApontamento->execute([
				'boletim_id' => $boletimId,
				'tipo_apontamento_id' => $tipoApontamentoId,
				'apontamento_especifico_id' => $apontamentoEspecificoId
			]);

			$this->pdo->commit();
			return true;

		} catch (Exception $e) {
			$this->pdo->rollBack();
			error_log("Erro ao criar apontamento de abastecimento: " . $e->getMessage());
			return false;
		}
	}

	public function createViagemApontamento($boletimId, $viagemProgramadaId) {
		try {
			$sqlTipo = "SELECT id FROM tipo_apontamentos WHERE nome = 'Viagem Programada' LIMIT 1";
			$tipoApontamentoId = $this->pdo->query($sqlTipo)->fetchColumn();
			if (!$tipoApontamentoId) throw new Exception("Tipo 'Viagem Programada' não encontrado.");

			$sqlApontamento = "INSERT INTO apontamentos (boletim_id, tipo_apontamento_id, viagem_programada_id, hora_inicio, status) 
							VALUES (:boletim_id, :tipo_apontamento_id, :viagem_programada_id, CURTIME(), 'Em andamento')";
			$stmtApontamento = $this->pdo->prepare($sqlApontamento);
			
			return $stmtApontamento->execute([
				'boletim_id' => $boletimId,
				'tipo_apontamento_id' => $tipoApontamentoId,
				'viagem_programada_id' => $viagemProgramadaId
			]);
		} catch (Exception $e) {
			error_log("Erro ao criar apontamento de viagem: " . $e->getMessage());
			return false;
		}
	}
}