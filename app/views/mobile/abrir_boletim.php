<?php 
$pageTitle = "Abrir Boletim";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card shadow-sm">
	<div class="card-header">
		<h5 class="mb-0">Iniciar Jornada</h5>
	</div>
	<div class="card-body">
		<form action="<?= BASE_URL ?>/mobile/salvarBoletim" method="POST">
			<div class="mb-3">
				<label for="veiculo_id" class="form-label">Selecione o Veículo:</label>
				<select id="veiculo_id" name="veiculo_id" class="form-select form-select-lg" required>
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
				<input type="number" id="km_inicial" name="km_inicial" class="form-control form-control-lg" placeholder="Digite a quilometragem" required>
			</div>
			<div class="d-grid gap-2 mt-4">
				<button type="submit" class="btn btn-primary btn-full-width">Iniciar Boletim</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary btn-full-width">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>