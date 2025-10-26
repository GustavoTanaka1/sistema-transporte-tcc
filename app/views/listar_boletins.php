<?php 
$pageTitle = "Boletins de Viagem";
require_once 'partials/header.php'; 
?>

<div class="card">
	<div class="card-header">
		Boletins de Viagem
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Data Abertura</th>
					<th>Status</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($boletins as $boletim): ?>
					<tr>
						<td><?= $boletim['id'] ?></td>
						<td><?= htmlspecialchars($boletim['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($boletim['veiculo_placa']) ?></td>
						<td><?= date('d/m/Y H:i', strtotime($boletim['data_abertura'] . ' ' . $boletim['hora_abertura'])) ?></td>
						<td>
							<span class="badge <?= $boletim['status'] == 'Aberto' ? 'bg-success' : 'bg-secondary' ?>">
								<?= htmlspecialchars($boletim['status']) ?>
							</span>
						</td>
						<td class="text-end">
							<a href="<?= BASE_URL ?>/boletim/detalhes/<?= $boletim['id'] ?>" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
								<i class="bi bi-eye-fill"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>