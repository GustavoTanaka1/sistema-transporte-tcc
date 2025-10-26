<?php

class Conexao {
	private static $pdo;

	private function __construct() {}

	public static function getConexao() {
		if (!isset(self::$pdo)) {
			$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

			try {
				self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
				]);
			} catch (PDOException $e) {
				error_log('Erro de conexão: ' . $e->getMessage());
				die('Erro ao conectar ao banco de dados. Verifique o log para mais detalhes.');
			}
		}
		return self::$pdo;
	}
}