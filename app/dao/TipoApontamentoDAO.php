<?php

class TipoApontamentoDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getAll() {
		$sql = "SELECT * FROM tipo_apontamentos ORDER BY nome ASC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}

	public function getById($id) {
		$sql = "SELECT * FROM tipo_apontamentos WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public function getApontamentoDetailTables() {
		$sql = "SHOW TABLES LIKE 'apontamentos_%'";
		$stmt = $this->pdo->query($sql);
		$tabelas = $stmt->fetchAll(PDO::FETCH_COLUMN);

		$sqlRotas = "SHOW TABLES LIKE 'rotas'";
		$stmtRotas = $this->pdo->query($sqlRotas);
		if ($stmtRotas->rowCount() > 0) {
			$tabelas[] = 'rotas';
		}

		sort($tabelas);
		return $tabelas;
	}

	public function create($dados) {
		$sql = "INSERT INTO tipo_apontamentos (nome, tabela_referencia) VALUES (:nome, :tabela_referencia)";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function update($id, $dados) {
		$dados['id'] = $id;
		$sql = "UPDATE tipo_apontamentos SET nome = :nome, tabela_referencia = :tabela_referencia WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function delete($id) {
		$sql = "DELETE FROM tipo_apontamentos WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['id' => $id]);
	}
}