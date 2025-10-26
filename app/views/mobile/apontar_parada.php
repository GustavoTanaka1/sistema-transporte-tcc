<?php 
$pageTitle = "Apontar Parada";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card">
	<div class="card-body">
		<form action="<?= BASE_URL ?>/mobile/salvarParada" method="POST">
			<div class="mb-3">
				<label for="tipo_parada_id" class="form-label">Motivo da Parada:</label>
				<select id="tipo_parada_id" name="tipo_parada_id" class="form-select" required>
					<option value="">Selecione um motivo...</option>
					<?php foreach ($tiposParada as $tipo): ?>
						<option value="<?= $tipo['id'] ?>">
							<?= htmlspecialchars($tipo['nome']) ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="mb-3">
				<label for="observacao" class="form-label">Observação (Opcional):</label>
				<textarea id="observacao" name="observacao" class="form-control" rows="3" placeholder="Detalhes adicionais sobre a parada..."></textarea>
			</div>
			<div class="d-grid gap-2">
				<button type="submit" class="btn btn-primary btn-full-width">Iniciar Parada</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>