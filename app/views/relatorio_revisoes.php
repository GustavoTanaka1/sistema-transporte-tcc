<?php 
$pageTitle = "Relatório de Revisões";
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header">
		Filtro de Relatório de Revisões
	</div>
	<div class="card-body">
		<form method="POST" action="<?= BASE_URL ?>/relatorio/revisoes">
			<input type="hidden" name="filtro_revisoes" value="1">
			<div class="row align-items-end">
				<div class="col-md-4 mb-3">
					<label for="data_inicio" class="form-label">Data de Início (Registro):</label>
					<input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $_POST['data_inicio'] ?? date('Y-m-01') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="data_fim" class="form-label">Data de Fim (Registro):</label>
					<input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= $_POST['data_fim'] ?? date('Y-m-t') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="veiculo_id" class="form-label">Veículo:</label>
					<select id="veiculo_id" name="veiculo_id" class="form-select">
						<option value="">Todos os Veículos</option>
						<?php foreach ($veiculos as $veiculo): ?>
							<option value="<?= $veiculo['id'] ?>" <?= (isset($_POST['veiculo_id']) && $_POST['veiculo_id'] == $veiculo['id']) ? 'selected' : '' ?>>
								<?= htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['modelo']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4 mb-3">
					<label for="urgencia" class="form-label">Urgência:</label>
					<select id="urgencia" name="urgencia" class="form-select">
						<option value="">Todas</option>
						<option value="Baixa" <?= (isset($_POST['urgencia']) && $_POST['urgencia'] == 'Baixa') ? 'selected' : '' ?>>Baixa</option>
						<option value="Media" <?= (isset($_POST['urgencia']) && $_POST['urgencia'] == 'Media') ? 'selected' : '' ?>>Média</option>
						<option value="Alta" <?= (isset($_POST['urgencia']) && $_POST['urgencia'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">
				<i class="bi bi-funnel-fill me-2"></i>Gerar Relatório de Revisões
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

			<h2 class="text-center mb-3">Relatório de Revisões e Problemas</h2>

			<div class="border p-3 rounded mb-4">
				<h5 class="border-bottom pb-2">PARÂMETROS DA ANÁLISE</h5>
				<div class="row mt-3">
					<div class="col-md-6">
						<strong>Período Analisado:</strong> 
						<?= date('d/m/Y', strtotime($filtroInfo['dataInicio'])) ?> até <?= date('d/m/Y', strtotime($filtroInfo['dataFim'])) ?>
					</div>
					<div class="col-md-6">
						<strong>Veículo:</strong> 
						<?= htmlspecialchars($filtroInfo['veiculoNome']) ?>
					</div>
					<div class="col-md-6">
						<strong>Urgência:</strong> 
						<?= htmlspecialchars($filtroInfo['urgencia']) ?>
					</div>
				</div>
			</div>

			<h5 class="border-bottom pb-2">RESULTADOS</h5>
			<?php if (empty($resultados)): ?>
				<div class="alert alert-info" role="alert">
					Nenhum relatório de revisão encontrado para os filtros selecionados.
				</div>
			<?php else: ?>
				<table class="table table-striped table-hover align-middle">
					<thead class="table-dark">
						<tr>
							<th>Data</th>
							<th>Funcionário</th>
							<th>Veículo</th>
							<th>KM</th>
							<th>Tipo</th>
							<th>Urgência</th>
							<th>Descrição</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($resultados as $revisao): ?>
							<tr>
								<td><?= date('d/m/Y H:i', strtotime($revisao['data_registro'])) ?></td>
								<td><?= htmlspecialchars($revisao['funcionario_nome']) ?></td>
								<td><?= htmlspecialchars($revisao['veiculo_placa']) ?></td>
								<td><?= htmlspecialchars($revisao['km_veiculo']) ?></td>
								<td><?= htmlspecialchars($revisao['tipo_revisao']) ?></td>
								<td>
									<?php 
									$urgencia = htmlspecialchars($revisao['urgencia']);
									$badgeClass = 'bg-secondary';
									if ($urgencia == 'Media') $badgeClass = 'bg-warning text-dark';
									if ($urgencia == 'Alta') $badgeClass = 'bg-danger';
									echo "<span class='badge $badgeClass'>$urgencia</span>";
									?>
								</td>
								<td><?= htmlspecialchars($revisao['descricao_problema']) ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

		</div>
	</div>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>