<?php 
$pageTitle = "Gerenciamento de Revisões";
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header">
		Filtros de Revisões
	</div>
	<div class="card-body">
		<form method="POST" action="<?= BASE_URL ?>/revisao/index">
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
				<i class="bi bi-funnel-fill me-2"></i>Filtrar Revisões
			</button>
		</form>
	</div>
</div>

<div class="card">
	<div class="card-header">
		Revisões / Problemas Reportados
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Data</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Urgência</th>
					<th>Status</th>
					<th>Descrição</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($revisoes as $revisao): ?>
					<?php
						$urgencia = htmlspecialchars($revisao['urgencia']);
						$urgBadge = 'bg-secondary';
						if ($urgencia == 'Media') $urgBadge = 'bg-warning text-dark';
						if ($urgencia == 'Alta') $urgBadge = 'bg-danger';

						$status = htmlspecialchars($revisao['status_revisao']);
						$statusBadge = 'bg-secondary';
						if ($status == 'Pendente') $statusBadge = 'bg-warning text-dark';
						if ($status == 'Em Andamento') $statusBadge = 'bg-info text-dark';
						if ($status == 'Concluída') $statusBadge = 'bg-success';
					?>
					<tr>
						<td><?= $revisao['id'] ?></td>
						<td><?= date('d/m/Y H:i', strtotime($revisao['data_registro'])) ?></td>
						<td><?= htmlspecialchars($revisao['funcionario_nome'] ?? 'N/A') ?></td>
						<td><?= htmlspecialchars($revisao['veiculo_placa']) ?></td>
						<td><span class="badge <?= $urgBadge ?>"><?= $urgencia ?></span></td>
						<td><span class="badge <?= $statusBadge ?>"><?= $status ?></span></td>
						<td><?= htmlspecialchars($revisao['descricao_problema']) ?></td>
						<td class="text-end">
							<?php if ($status == 'Pendente'): ?>
								<a href="<?= BASE_URL ?>/revisao/setStatus/<?= $revisao['id'] ?>/1" class="btn btn-sm btn-outline-primary" title="Marcar Em Andamento">
									<i class="bi bi-play-fill"></i>
								</a>
							<?php elseif ($status == 'Em Andamento'): ?>
								<a href="<?= BASE_URL ?>/revisao/setStatus/<?= $revisao['id'] ?>/2" class="btn btn-sm btn-outline-success" title="Marcar Concluída">
									<i class="bi bi-check-lg"></i>
								</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>