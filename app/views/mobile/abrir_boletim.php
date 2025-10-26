<?php 
$pageTitle = "Abrir Boletim";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card">
	<div class="card-body">
		<form action="<?= BASE_URL ?>/mobile/salvarBoletim" method="POST">
			<div class="mb-3">
				<label for="veiculo_id" class="form-label">Veículo:</label>
				<select id="veiculo_id" name="veiculo_id" class="form-select" required>
					<option value="">Selecione um veículo...</option>
					<?php foreach ($veiculos as $veiculo): ?>
						<?php if ($veiculo['status'] == 'ativo'): ?>
							<option value="<?= $veiculo['id'] ?>">
								<?= htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['modelo']) ?>
							</option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="mb-3">
				<label for="km_inicial" class="form-label">KM Inicial:</label>
				<input type="number" id="km_inicial" name="km_inicial" class="form-control" placeholder="Digite a quilometragem" required>
			</div>
			<div class="d-grid gap-2">
				<button type="submit" class="btn btn-primary btn-full-width">Iniciar Boletim</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>