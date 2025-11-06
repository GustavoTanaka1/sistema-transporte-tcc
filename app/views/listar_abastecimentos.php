<?php 
$pageTitle = "Relatório de Abastecimentos";
require_once 'partials/header.php'; 
?>

<div class="card">
	<div class="card-header">
		Relatório de Todos os Abastecimentos
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Data</th>
					<th>Local</th>
					<th>Litros</th>
					<th>Valor (R$)</th>
					<th>KM</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($abastecimentos as $abs): ?>
					<tr>
						<td><?= $abs['id'] ?></td>
						<td><?= htmlspecialchars($abs['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($abs['veiculo_placa']) ?></td>
						<td><?= date('d/m/Y H:i', strtotime($abs['hora_inicio'])) ?></td>
						<td><?= htmlspecialchars($abs['local']) ?></td>
						<td><?= htmlspecialchars($abs['litros']) ?></td>
						<td><?= htmlspecialchars($abs['valor']) ?></td>
						<td><?= htmlspecialchars($abs['km']) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>