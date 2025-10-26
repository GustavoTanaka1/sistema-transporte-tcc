<?php 
$pageTitle = isset($tipoParada) ? "Editar Tipo de Parada" : "Novo Tipo de Parada";
require_once 'partials/header.php'; 

$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
	<div class="card-header">
		<?= $pageTitle ?>
	</div>
	<div class="card-body">
		<form action="<?= isset($tipoParada) ? BASE_URL . '/tipoParada/update/' . $tipoParada['id'] : BASE_URL . '/tipoParada/store' ?>" method="POST">
			<div class="mb-3">
				<label for="nome" class="form-label">Nome:</label>
				<input type="text" id="nome" name="nome" class="form-control" value="<?= $formData['nome'] ?? $tipoParada['nome'] ?? '' ?>" placeholder="Ex: Refeição" required>
			</div>
			<button type="submit" class="btn btn-primary">Salvar</button>
			<a href="<?= BASE_URL ?>/tipoParada" class="btn btn-secondary">Cancelar</a>
		</form>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>