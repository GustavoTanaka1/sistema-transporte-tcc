<?php 
$pageTitle = "Relatório de Paradas";
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header">
		Filtro de Análise de Paradas
	</div>
	<div class="card-body">
		<form method="POST" action="<?= BASE_URL ?>/relatorio/paradas">
			<input type="hidden" name="filtro_paradas" value="1">
			<div class="row align-items-end">
				<div class="col-md-4 mb-3">
					<label for="data_inicio" class="form-label">Data de Início (Boletim):</label>
					<input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $_POST['data_inicio'] ?? date('Y-m-01') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="data_fim" class="form-label">Data de Fim (Boletim):</label>
					<input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= $_POST['data_fim'] ?? date('Y-m-t') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="tipo_parada_id" class="form-label">Tipo de Parada:</label>
					<select id="tipo_parada_id" name="tipo_parada_id" class="form-select">
						<option value="">Todos os Tipos</option>
						<?php foreach ($tiposParada as $tipo): ?>
							<option value="<?= $tipo['id'] ?>" <?= (isset($_POST['tipo_parada_id']) && $_POST['tipo_parada_id'] == $tipo['id']) ? 'selected' : '' ?>>
								<?= htmlspecialchars($tipo['nome']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4 mb-3">
					<label for="funcionario_id" class="form-label">Funcionário:</label>
					<select id="funcionario_id" name="funcionario_id" class="form-select">
						<option value="">Todos os Funcionários</option>
						<?php foreach ($funcionarios as $funcionario): ?>
							<option value="<?= $funcionario['id'] ?>" <?= (isset($_POST['funcionario_id']) && $_POST['funcionario_id'] == $funcionario['id']) ? 'selected' : '' ?>>
								<?= htmlspecialchars($funcionario['nome']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">
				<i class="bi bi-funnel-fill me-2"></i>Gerar Relatório de Paradas
			</button>
		</form>
	</div>
</div>

<?php if (isset($resultados)): ?>
	<div class="card">
		<div class="card-body p-4">
			
			<div class="row align-items-center border-bottom pb-3 mb-3">
				<div class="col-md-6">
					<h3 class="mb-0">Tanaka Transportes</h3>
					<p class="mb-0">Rua Mozart Silva 180, Jardim Santa Lúcia, São Joaquim da Barra</p>
					<p class="mb-0">tanakatransportes.com</p>
				</div>
				<div class="col-md-6 text-md-end">
					<strong>Data de Emissão:</strong> <?= date('d/m/Y H:i:s') ?><br>
					<strong>Status:</strong> Finalizado
				</div>
			</div>

			<h2 class="text-center mb-3">Relatório de Análise de Paradas</h2>

			<div class="border p-3 rounded mb-4">
				<h5 class="border-bottom pb-2">PARÂMETROS DA ANÁLISE</h5>
				<div class="row mt-3">
					<div class="col-md-6">
						<strong>Período Analisado:</strong> 
						<?= date('d/m/Y', strtotime($filtroInfo['dataInicio'])) ?> até <?= date('d/m/Y', strtotime($filtroInfo['dataFim'])) ?>
					</div>
					<div class="col-md-6">
						<strong>Tipo de Parada:</strong> 
						<?= htmlspecialchars($filtroInfo['tipoParadaNome']) ?>
					</div>
					<div class="col-md-6">
						<strong>Funcionário:</strong> 
						<?= htmlspecialchars($filtroInfo['funcionarioNome']) ?>
					</div>
				</div>
			</div>

			<h5 class="border-bottom pb-2">RESULTADOS</h5>
			<?php if (empty($resultados)): ?>
				<div class="alert alert-info" role="alert">
					Nenhuma parada encontrada para os filtros selecionados.
				</div>
			<?php else: ?>
				<table class="table table-striped table-hover align-middle">
					<thead class="table-dark">
						<tr>
							<th>Motivo da Parada</th>
							<th>Nº de Ocorrências</th>
							<th>Tempo Total Gasto</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($resultados as $parada): ?>
							<tr>
								<td><?= htmlspecialchars($parada['tipo_parada_nome']) ?></td>
								<td><?= $parada['total_ocorrencias'] ?></td>
								<td><strong><?= htmlspecialchars($parada['tempo_total']) ?></strong></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

		</div>
	</div>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>