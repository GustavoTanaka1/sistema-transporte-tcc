<?php 
$pageTitle = "Planejamento de Viagens";
require_once 'partials/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<a href="<?= BASE_URL ?>/viagemProgramada/create" class="btn btn-primary ms-auto">
		<i class="bi bi-plus-lg me-2"></i> Programar Nova Viagem
	</a>
</div>

<div class="card">
	<div class="card-header">
		Viagens Programadas
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Título</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Data Início</th>
					<th>Status</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($viagens as $viagem): ?>
					<?php
						$status = htmlspecialchars($viagem['status']);
						$badgeClass = 'bg-secondary';
						if ($status == 'Programada') $badgeClass = 'bg-info text-dark';
						if ($status == 'Iniciada') $badgeClass = 'bg-success';
						if ($status == 'Concluída') $badgeClass = 'bg-primary';
						if ($status == 'Cancelada') $badgeClass = 'bg-danger';
					?>
					<tr>
						<td><?= $viagem['id'] ?></td>
						<td><?= htmlspecialchars($viagem['titulo']) ?></td>
						<td><?= htmlspecialchars($viagem['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($viagem['veiculo_placa']) ?></td>
						<td><?= date('d/m/Y H:i', strtotime($viagem['data_prevista_inicio'])) ?></td>
						<td>
							<span class="badge <?= $badgeClass ?>"><?= $status ?></span>
						</td>
						<td class="text-end">
							<a href="<?= BASE_URL ?>/viagemProgramada/edit/<?= $viagem['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar">
								<i class="bi bi-pencil-square"></i>
							</a>
							<a href="<?= BASE_URL ?>/viagemProgramada/destroy/<?= $viagem['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza?');">
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