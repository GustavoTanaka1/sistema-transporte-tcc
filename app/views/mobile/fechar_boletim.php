<?php 
$pageTitle = "Fechar Boletim #" . $boletimAberto['id'];
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card shadow-sm">
	<div class="card-header">
	<h5 class="mb-0">Confirmar Fechamento</h5>
	</div>
	<div class="card-body">
		<div class="alert alert-info">
			<strong>KM Inicial Registrada:</strong> <?= htmlspecialchars($boletimAberto['km_inicial']) ?> KM
		</div>

		<form action="<?= BASE_URL ?>/mobile/salvarFechamentoBoletim" method="POST">
			<div class="mb-3">
				<label for="km_final" class="form-label">KM Final do Veículo:</label>
				<input type="number" step="0.1" id="km_final" name="km_final" class="form-control" placeholder="Digite a quilometragem final" required>
			</div>
			<div class="d-grid gap-2 mt-4">
				<button type="submit" class="btn btn-danger btn-full-width">Confirmar e Fechar Boletim</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary btn-full-width">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>