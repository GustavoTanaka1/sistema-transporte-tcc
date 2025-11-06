<?php 
$pageTitle = "Relatório de Revisões/Problemas";
require_once 'partials/header.php'; 
?>

<div class="card">
	<div class="card-header">
		Relatório de Todas as Revisões/Problemas Reportados
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Data</th>
					<th>Tipo</th>
					<th>KM</th>
					<th>Urgência</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($revisoes as $revisao): ?>
					<tr>
						<td><?= $revisao['id'] ?></td>
						<td><?= htmlspecialchars($revisao['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($revisao['veiculo_placa']) ?></td>
						<td><?= date('d/m/Y H:i', strtotime($revisao['data_registro'])) ?></td>
						<td><?= htmlspecialchars($revisao['tipo_revisao']) ?></td>
						<td><?= htmlspecialchars($revisao['km_veiculo']) ?></td>
						<td><?= htmlspecialchars($revisao['urgencia']) ?></td>
						<td><?= htmlspecialchars($revisao['descricao_problema']) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>