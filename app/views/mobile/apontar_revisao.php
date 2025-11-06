<?php 
$pageTitle = "Apontar Revisão/Problema";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<div class="card">
	<div class="card-body">
		<form action="<?= BASE_URL ?>/mobile/salvarRevisao" method="POST">
			
			<div class="mb-3">
				<label for="km_veiculo" class="form-label">KM Atual do Veículo:</label>
				<input type="number" step="0.1" id="km_veiculo" name="km_veiculo" class="form-control" value="<?= $boletimAberto['km_inicial'] ?>" placeholder="Quilometragem no painel" required>
			</div>

			<div class="mb-3">
				<label for="tipo_revisao" class="form-label">Tipo de Revisão/Problema:</label>
				<select id="tipo_revisao" name="tipo_revisao" class="form-select" required>
					<option value="">Selecione o tipo...</option>
					<option value="Pneus">Pneus</option>
					<option value="Freios">Freios</option>
					<option value="Óleo e Filtros">Óleo e Filtros</option>
					<option value="Elétrica">Elétrica</option>
					<option value="Motor">Motor</option>
					<option value="Outro">Outro</option>
				</select>
			</div>

			<div class="mb-3">
				<label for="urgencia" class="form-label">Urgência:</label>
				<select id="urgencia" name="urgencia" class="form-select" required>
					<option value="Baixa">Baixa (Pode aguardar)</option>
					<option value="Media">Média (Verificar no retorno)</option>
					<option value="Alta">Alta (Imediata / Risco)</option>
				</select>
			</div>

			<div class="mb-3">
				<label for="descricao_problema" class="form-label">Descrição do Problema:</label>
				<textarea id="descricao_problema" name="descricao_problema" class="form-control" rows="4" placeholder="Descreva o que notou..." required></textarea>
			</div>

			<div class="d-grid gap-2">
				<button type="submit" class="btn btn-primary btn-full-width">Enviar Relatório de Revisão</button>
				<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary">Cancelar</a>
			</div>
		</form>
	</div>
</div>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>