<?php 
$pageTitle = "Relatório de Rotas/Entregas";
require_once 'partials/header.php'; 
?>

<div class="card">
	<div class="card-header">
		Relatório de Todas as Rotas/Entregas Registradas
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Data/Hora</th>
					<th>Destino</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rotas as $rota): ?>
					<tr>
						<td><?= $rota['id'] ?></td>
						<td><?= htmlspecialchars($rota['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($rota['veiculo_placa']) ?></td>
						<td><?= date('d/m/Y H:i', strtotime($rota['data_registro'])) ?></td>
						<td><?= htmlspecialchars($rota['destino']) ?></td>
						<td><?= htmlspecialchars($rota['status_entrega']) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>