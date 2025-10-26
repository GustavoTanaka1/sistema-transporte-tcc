<?php 
$pageTitle = isset($tipoViagem) ? "Editar Tipo de Viagem" : "Novo Tipo de Viagem";
require_once 'partials/header.php'; 

$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
	<div class="card-header">
		<?= $pageTitle ?>
	</div>
	<div class="card-body">
		<form action="<?= isset($tipoViagem) ? BASE_URL . '/tipoViagem/update/' . $tipoViagem['id'] : BASE_URL . '/tipoViagem/store' ?>" method="POST">
			<div class="mb-3">
				<label for="nome" class="form-label">Nome:</label>
				<input type="text" id="nome" name="nome" class="form-control" value="<?= $formData['nome'] ?? $tipoViagem['nome'] ?? '' ?>" placeholder="Ex: Rota de Entrega" required>
			</div>
			<button type="submit" class="btn btn-primary">Salvar</button>
			<a href="<?= BASE_URL ?>/tipoViagem" class="btn btn-secondary">Cancelar</a>
		</form>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>