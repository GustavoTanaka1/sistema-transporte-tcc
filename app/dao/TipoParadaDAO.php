<?php

class TipoParadaDAO {
	private $pdo;

	public function __construct() {
		$this->pdo = Conexao::getConexao();
	}

	public function getAll() {
		$sql = "SELECT * FROM tipo_paradas ORDER BY nome ASC";
		$stmt = $this->pdo->query($sql);
		return $stmt->fetchAll();
	}

	public function getById($id) {
		$sql = "SELECT * FROM tipo_paradas WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public function create($dados) {
		$sql = "INSERT INTO tipo_paradas (nome) VALUES (:nome)";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function update($id, $dados) {
		$dados['id'] = $id;
		$sql = "UPDATE tipo_paradas SET nome = :nome WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute($dados);
	}

	public function delete($id) {
		$sql = "DELETE FROM tipo_paradas WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		return $stmt->execute(['id' => $id]);
	}
}