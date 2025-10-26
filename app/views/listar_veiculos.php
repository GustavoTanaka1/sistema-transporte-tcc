<?php 
$pageTitle = "Gerenciar Veículos";
require_once 'partials/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<a href="<?= BASE_URL ?>/veiculo/create" class="btn btn-primary ms-auto">
		<i class="bi bi-plus-lg me-2"></i> Adicionar Novo Veículo
	</a>
</div>

<div class="card">
	<div class="card-header">
		Frota de Veículos
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Placa</th>
					<th>Modelo</th>
					<th>Ano</th>
					<th>KM Atual</th>
					<th>Status</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($veiculos as $veiculo): ?>
					<tr>
						<td><?= $veiculo['id'] ?></td>
						<td><?= htmlspecialchars($veiculo['placa']) ?></td>
						<td><?= htmlspecialchars($veiculo['modelo']) ?></td>
						<td><?= htmlspecialchars($veiculo['ano']) ?></td>
						<td><?= htmlspecialchars($veiculo['km_atual']) ?></td>
						<td>
							<span class="badge <?= $veiculo['status'] == 'ativo' ? 'bg-success' : 'bg-danger' ?>">
								<?= ucfirst(htmlspecialchars($veiculo['status'])) ?>
							</span>
						</td>
						<td class="text-end">
							<a href="<?= BASE_URL ?>/veiculo/edit/<?= $veiculo['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar">
								<i class="bi bi-pencil-square"></i>
							</a>
							<a href="<?= BASE_URL ?>/veiculo/destroy/<?= $veiculo['id'] ?>" class="btn btn-sm btn-outline-danger" title="Inativar" onclick="return confirm('Tem certeza?');">
								<i class="bi bi-trash3"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>