<?php
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $pageTitle ?? 'Sistema de Transporte' ?></title>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" media="screen">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/custom.css" media="screen">
	<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/print.css" media="print">
	
	<style media="screen">
		body {
			padding-top: 70px; 
			background-color: #f8f9fa;
		}
	</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
	<div class="container-fluid">
		<a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">
			<img src="<?= BASE_URL ?>/public/img/header.png" alt="Tanaka Transportes">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="main-nav">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>/dashboard">Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>/boletim">Boletins</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-pencil-square me-1"></i> Cadastros
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/funcionario">Funcionários</a></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/veiculo">Veículos</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-clipboard-data me-1"></i> Operacional
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/viagemProgramada">Planejamento de Viagens</a></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/revisao">Gerenciar Revisões</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/aptParada">Apontamentos de Paradas</a></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/aptAbastecimento">Apontamentos de Abastecimentos</a></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/rota">Apontamentos de Rotas/Entregas</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/simulador" target="_blank">Abrir Simulador Mobile</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE_URL ?>/relatorio">
						<i class="bi bi-file-earmark-bar-graph me-1"></i> Relatórios
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-gear-fill me-1"></i> Configurações
					</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/tipoApontamento">Tipos de Apontamento</a></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/tipoParada">Tipos de Parada</a></li>
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/tipoViagem">Tipos de Viagem</a></li>
					</ul>
				</li>
			</ul>

			<div class="d-flex align-items-center text-white">
				<div class="text-end me-3">
					<span id="current-time" class="d-block small fw-bold">--:--:--</span>
					<span id="current-date" class="d-block small fw-bold">--/--/----</span>
				</div>
				<div class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($_SESSION['usuario_login']); ?>
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
						<li><a class="dropdown-item" href="<?= BASE_URL ?>/login/logout">Sair</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>

<main class="container py-4">
	<?php
	FlashMessage::display();
	?>