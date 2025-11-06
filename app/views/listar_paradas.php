<?php 
$pageTitle = "Relatório de Paradas";
require_once 'partials/header.php'; 
?>

<div class="card">
	<div class="card-header">
		Relatório de Todas as Paradas
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Funcionário</th>
					<th>Veículo</th>
					<th>Motivo</th>
					<th>Início</th>
					<th>Fim</th>
					<th>Duração</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($paradas as $parada): ?>
					<tr>
						<td><?= $parada['id'] ?></td>
						<td><?= htmlspecialchars($parada['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($parada['veiculo_placa']) ?></td>
						<td><?= htmlspecialchars($parada['tipo_parada_nome']) ?></td>
						<td><?= date('d/m/Y H:i', strtotime($parada['hora_inicio'])) ?></td>
						<td><?= $parada['hora_fim'] ? date('d/m/Y H:i', strtotime($parada['hora_fim'])) : '---' ?></td>
						<td>
							<?php
							if (!empty($parada['hora_fim'])) {
								$inicio = new DateTime($parada['hora_inicio']);
								$fim = new DateTime($parada['hora_fim']);
								if ($fim < $inicio) {
									$fim->add(new DateInterval('P1D'));
								}
								$duracao = $inicio->diff($fim);
								echo $duracao->format('%H:%I:%S');
							} else {
								echo "Em andamento";
							}
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>