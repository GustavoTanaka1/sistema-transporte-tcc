<?php

class DashboardController {

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
	}

	public function index() {
		require_once PROJECT_ROOT . '/app/views/dashboard.php';
	}
}