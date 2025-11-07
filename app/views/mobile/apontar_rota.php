<?php 
$pageTitle = "Apontar Rota/Entrega";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card shadow-sm">
	<div class="card-header">
		<h5 class="mb-0">Registrar Ponto de Rota/Entrega</h5>
	</div>
	<div class="card-body">
		<form action="<?= BASE_URL ?>/mobile/salvarRota" method="POST">
			<input type="hidden" name="apontamento_id" value="<?= $apontamentoViagemId ?>"> 

			<div class="mb-3">
				<label for="destino" class="form-label">Destino / Local:</label>
				<input type="text" id="destino" name="destino" class="form-control" placeholder="Endereço ou Ponto de Referência" required>
			</div>
			
			<div class="mb-3">
				<label for="status_entrega" class="form-label">Status (Opcional):</label>
				<select id="status_entrega" name="status_entrega" class="form-select">
					<option value="">Selecione (se aplicável)</option>
					<option value="Realizada">Entrega Realizada</option>
					<option value="Coleta Efetuada">Coleta Efetuada</option>
					<option value="Pendente">Pendente</option>
					<option value="Recusada">Recusada</option>
					<option value="Destinatário Ausente">Destinatário Ausente</option>
					<option value="Endereço Incorreto">Endereço Incorreto</option>
				</select>
			</div>

			<div class="mb-3">
				<label for="observacao" class="form-label">Observação (Opcional):</label>
				<textarea id="observacao" name="observacao" class="form-control" rows="3" placeholder="Detalhes sobre a entrega, coleta ou ponto..."></textarea>
			</div>

			<div class="d-grid gap-2 mt-4">
				<button type="submit" class="btn btn-primary btn-full-width">Registrar Ponto</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary btn-full-width">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>