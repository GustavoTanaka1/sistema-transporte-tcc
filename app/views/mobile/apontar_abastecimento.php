<?php 
$pageTitle = "Apontar Abastecimento";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card">
	<div class="card-body">
		<form action="<?= BASE_URL ?>/mobile/salvarAbastecimento" method="POST">
			<div class="mb-3">
				<label for="local" class="form-label">Local (Posto):</label>
				<input type="text" id="local" name="local" class="form-control" placeholder="Nome do posto ou endereço" required>
			</div>
			<div class="mb-3">
				<label for="km" class="form-label">KM Atual do Veículo:</label>
				<input type="number" step="0.1" id="km" name="km" class="form-control" placeholder="Quilometragem no painel" required>
			</div>
			<div class="row">
				<div class="col-6 mb-3">
					<label for="litros" class="form-label">Litros:</label>
					<input type="number" step="0.01" id="litros" name="litros" class="form-control" placeholder="Ex: 50.75" required>
				</div>
				<div class="col-6 mb-3">
					<label for="valor" class="form-label">Valor Total (R$):</label>
					<input type="number" step="0.01" id="valor" name="valor" class="form-control" placeholder="Ex: 250.00" required>
				</div>
			</div>
			<div class="d-grid gap-2">
				<button type="submit" class="btn btn-primary btn-full-width">Registrar Abastecimento</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>