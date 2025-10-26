<?php 
$pageTitle = "Dashboard";
require_once 'partials/header.php'; 
?>

<div class="container-fluid">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<span class="text-muted">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_login']); ?>!</span>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="card text-center text-white bg-primary mb-3">
				<div class="card-body">
					<h5 class="card-title">Veículos</h5>
					<p class="card-text">Gerencie a frota da empresa.</p>
					<a href="<?= BASE_URL ?>/veiculo" class="btn btn-light">Acessar</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card text-center text-white bg-success mb-3">
				<div class="card-body">
					<h5 class="card-title">Funcionários</h5>
					<p class="card-text">Cadastre e edite colaboradores.</p>
					<a href="<?= BASE_URL ?>/funcionario" class="btn btn-light">Acessar</a>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card text-center text-white bg-info mb-3">
				<div class="card-body">
					<h5 class="card-title">Apontamentos</h5>
					<p class="card-text">Lance as horas de trabalho.</p>
					<a href="<?= BASE_URL ?>/apontamento" class="btn btn-light">Acessar</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>