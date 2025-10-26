<?php 
$pageTitle = isset($tipoApontamento) ? "Editar Tipo de Apontamento" : "Novo Tipo de Apontamento";
require_once 'partials/header.php'; 

$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
	<div class="card-header">
		<?= $pageTitle ?>
	</div>
	<div class="card-body">
		<form action="<?= isset($tipoApontamento) ? BASE_URL . '/tipoApontamento/update/' . $tipoApontamento['id'] : BASE_URL . '/tipoApontamento/store' ?>" method="POST">
			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="nome" class="form-label">Nome:</label>
					<input type="text" id="nome" name="nome" class="form-control" value="<?= $formData['nome'] ?? $tipoApontamento['nome'] ?? '' ?>" placeholder="Ex: Parada" required>
				</div>
				<div class="col-md-6 mb-3">
					<label for="tabela_referencia" class="form-label">Tabela de Referência (Opcional):</label>
					<select id="tabela_referencia" name="tabela_referencia" class="form-select">
						<option value="">Nenhuma</option>
						<?php if (isset($tabelasDisponiveis)): ?>
							<?php foreach ($tabelasDisponiveis as $tabela): ?>
								<option value="<?= $tabela ?>" <?= (($formData['tabela_referencia'] ?? $tipoApontamento['tabela_referencia'] ?? '') == $tabela) ? 'selected' : '' ?>>
									<?= $tabela ?>
								</option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Salvar</button>
			<a href="<?= BASE_URL ?>/tipoApontamento" class="btn btn-secondary">Cancelar</a>
		</form>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>