<?php 
$pageTitle = isset($viagemProgramada) ? "Editar Viagem" : "Programar Nova Viagem";
require_once 'partials/header.php'; 

$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
	<div class="card-header">
		<?= $pageTitle ?>
	</div>
	<div class="card-body">
		<form action="<?= isset($viagemProgramada) ? BASE_URL . '/viagemProgramada/update/' . $viagemProgramada['id'] : BASE_URL . '/viagemProgramada/store' ?>" method="POST">
			<div class="mb-3">
				<label for="titulo" class="form-label">Título da Viagem:</label>
				<input type="text" id="titulo" name="titulo" class="form-control" value="<?= $formData['titulo'] ?? $viagemProgramada['titulo'] ?? '' ?>" placeholder="Ex: Entregas em São Paulo" required>
			</div>

			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="origem" class="form-label">Origem:</label>
					<input type="text" id="origem" name="origem" class="form-control" value="<?= $formData['origem'] ?? $viagemProgramada['origem'] ?? '' ?>" placeholder="Ex: Centro de Distribuição">
				</div>
				<div class="col-md-6 mb-3">
					<label for="destino" class="form-label">Destino Principal:</label>
					<input type="text" id="destino" name="destino" class="form-control" value="<?= $formData['destino'] ?? $viagemProgramada['destino'] ?? '' ?>" placeholder="Ex: Cliente Final">
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 mb-3">
					<label for="data_prevista_inicio" class="form-label">Data e Hora de Início:</label>
					<input type="datetime-local" id="data_prevista_inicio" name="data_prevista_inicio" class="form-control" value="<?= isset($viagemProgramada['data_prevista_inicio']) ? date('Y-m-d\TH:i', strtotime($viagemProgramada['data_prevista_inicio'])) : ($formData['data_prevista_inicio'] ?? '') ?>" required>
				</div>
				<div class="col-md-6 mb-3">
					<label for="data_prevista_fim" class="form-label">Data e Hora de Fim (Prevista):</label>
					<input type="datetime-local" id="data_prevista_fim" name="data_prevista_fim" class="form-control" value="<?= isset($viagemProgramada['data_prevista_fim']) ? date('Y-m-d\TH:i', strtotime($viagemProgramada['data_prevista_fim'])) : ($formData['data_prevista_fim'] ?? '') ?>">
				</div>
			</div>

			<div class="row">
				<div class="col-md-4 mb-3">
					<label for="funcionario_id" class="form-label">Funcionário (Técnico):</label>
					<select id="funcionario_id" name="funcionario_id" class="form-select" required>
						<option value="">Selecione...</option>
						<?php foreach($funcionarios as $f): ?>
							<option value="<?= $f['id'] ?>" <?= (($formData['funcionario_id'] ?? $viagemProgramada['funcionario_id'] ?? '') == $f['id']) ? 'selected' : '' ?>><?= $f['nome'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4 mb-3">
					<label for="veiculo_id" class="form-label">Veículo:</label>
					<select id="veiculo_id" name="veiculo_id" class="form-select" required>
						<option value="">Selecione...</option>
						<?php foreach($veiculos as $v): ?>
							<option value="<?= $v['id'] ?>" <?= (($formData['veiculo_id'] ?? $viagemProgramada['veiculo_id'] ?? '') == $v['id']) ? 'selected' : '' ?>><?= $v['placa'] . ' - ' . $v['modelo'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4 mb-3">
					<label for="tipo_viagem_id" class="form-label">Tipo de Viagem:</label>
					<select id="tipo_viagem_id" name="tipo_viagem_id" class="form-select">
						<option value="">Selecione...</option>
						<?php foreach($tiposViagem as $tv): ?>
							<option value="<?= $tv['id'] ?>" <?= (($formData['tipo_viagem_id'] ?? $viagemProgramada['tipo_viagem_id'] ?? '') == $tv['id']) ? 'selected' : '' ?>><?= $tv['nome'] ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<input type="hidden" name="status" value="Programada">
			<button type="submit" class="btn btn-primary">Salvar Programação</button>
			<a href="<?= BASE_URL ?>/viagemProgramada" class="btn btn-secondary">Cancelar</a>
		</form>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>