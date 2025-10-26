<?php 
$pageTitle = "Detalhes do Boletim #" . $boletim['id'];
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h5 class="mb-0">Resumo do Boletim</h5>
		<a href="<?= BASE_URL ?>/boletim" class="btn btn-sm btn-secondary">Voltar à Lista</a>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<strong>Funcionário:</strong>
				<p><?= htmlspecialchars($boletim['funcionario_nome']) ?></p>
			</div>
			<div class="col-md-4">
				<strong>Veículo:</strong>
				<p><?= htmlspecialchars($boletim['veiculo_placa'] . ' - ' . $boletim['veiculo_modelo']) ?></p>
			</div>
			<div class="col-md-2">
				<strong>Data Abertura:</strong>
				<p><?= date('d/m/Y', strtotime($boletim['data_abertura'])) ?></p>
			</div>
			<div class="col-md-2">
				<strong>Status:</strong>
				<p><span class="badge <?= $boletim['status'] == 'Aberto' ? 'bg-success' : 'bg-secondary' ?>"><?= htmlspecialchars($boletim['status']) ?></span></p>
			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		Linha do Tempo de Apontamentos
	</div>
	<div class="card-body">
		<table class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>Tipo</th>
					<th>Início</th>
					<th>Fim</th>
					<th>Duração</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($apontamentos)): ?>
					<?php foreach ($apontamentos as $apontamento): ?>
						<tr>
							<td><?= htmlspecialchars($apontamento['tipo_apontamento_nome']) ?></td>
							<td><?= htmlspecialchars($apontamento['hora_inicio']) ?></td>
							<td><?= htmlspecialchars($apontamento['hora_fim'] ?? '---') ?></td>
							<td>
								<?php
								if (!empty($apontamento['hora_fim'])) {
									$inicio = new DateTime($apontamento['hora_inicio']);
									$fim = new DateTime($apontamento['hora_fim']);
									$duracao = $inicio->diff($fim);
									echo $duracao->format('%H:%I:%S');
								} else {
									echo "Em andamento";
								}
								?>
							</td>
							<td class="text-end">
								<button class="btn btn-sm btn-outline-info" title="Ver Detalhes do Apontamento">
									<i class="bi bi-search"></i>
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="5" class="text-center">Nenhum apontamento registrado para este boletim.</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>