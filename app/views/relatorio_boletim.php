<?php
if (isset($boletim)) {
	$pageTitle = "Relatório do Boletim #" . $boletim['id'];
} else {
	$pageTitle = "Relatório Detalhado de Boletim";
}
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header">
		Filtros do Relatório
	</div>
	<div class="card-body">
		<form method="POST" action="<?= BASE_URL ?>/relatorio/boletim">
			<input type="hidden" name="filtro_boletim" value="1">
			<div class="row align-items-end">
				<div class="col-md-8 mb-3">
					<label for="boletim_id" class="form-label">Selecione o Boletim:</label>
					<select id="boletim_id" name="boletim_id" class="form-select" required>
						<option value="">Selecione um boletim...</option>
						<?php foreach ($todosBoletins as $b): ?>
							<option value="<?= $b['id'] ?>" <?= (isset($boletim) && $boletim['id'] == $b['id']) ? 'selected' : '' ?>>
								Boletim #<?= $b['id'] ?> (<?= htmlspecialchars($b['funcionario_nome']) ?> - <?= date('d/m/Y', strtotime($b['data_abertura'])) ?>)
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4 mb-3">
					<button type="submit" class="btn btn-primary w-100">
						<i class="bi bi-funnel-fill me-2"></i>Gerar Relatório
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php if (isset($boletim)): ?>
<div class="card">
	<div class="card-body p-4">

		<div class="row align-items-center border-bottom pb-3 mb-3">
			<div class="col-md-6">
				<h3 class="mb-0">Tanaka Transportes</h3>
				<p class="mb-0">Rua Mozart Silva 180, Jardim Santa Lúcia, São Joaquim da Barra</p>
				<p class="mb-0">Site: tanakatransportes.com</p>
			</div>
			<div class="col-md-6 text-md-end">
				<strong>Boletim:</strong> #<?= $boletim['id'] ?><br>
				<strong>Status:</strong> <?= htmlspecialchars($boletim['status']) ?><br>
				<strong>Data de Emissão:</strong> <?= date('d/m/Y H:i:s') ?>
			</div>
		</div>

		<h2 class="text-center mb-4">RELATÓRIO DE APONTAMENTOS</h2>

		<div class="border p-3 rounded mb-4">
			<h5 class="border-bottom pb-2">DADOS DO BOLETIM</h5>
			<div class="row mt-3">
				<div class="col-md-4">
					<strong>Técnico/Motorista:</strong><br>
					<?= htmlspecialchars($boletim['funcionario_nome']) ?>
				</div>
				<div class="col-md-4">
					<strong>Veículo:</strong><br>
					<?= htmlspecialchars($boletim['veiculo_placa'] . ' - ' . $boletim['veiculo_modelo']) ?>
				</div>
				<div class="col-md-4">
					<strong>Período:</strong><br>
					<?= date('d/m/Y H:i', strtotime($boletim['data_abertura'] . ' ' . $boletim['hora_abertura'])) ?>
					<?php if($boletim['status'] == 'Fechado'): ?>
						até <?= date('d/m/Y H:i', strtotime($boletim['data_fechamento'] . ' ' . $boletim['hora_fechamento'])) ?>
					<?php endif; ?>
				</div>
				<div class="col-md-4 mt-3">
					<strong>KM Inicial:</strong> <?= htmlspecialchars($boletim['km_inicial'] ?? 'N/A') ?>
				</div>
				<div class="col-md-4 mt-3">
					<strong>KM Final:</strong> <?= htmlspecialchars($boletim['km_final'] ?? 'N/A') ?>
				</div>
				<div class="col-md-4 mt-3">
					<strong>KM Percorrido:</strong> 
					<?= ($boletim['km_final'] && $boletim['km_inicial']) ? ($boletim['km_final'] - $boletim['km_inicial']) . ' KM' : 'N/A' ?>
				</div>
			</div>
		</div>

		<h5 class="border-bottom pb-2 mt-4">LINHA DO TEMPO (ATIVIDADES PRINCIPAIS)</h5>
		<table class="table table-sm table-striped">
			<thead class="table-dark">
				<tr>
					<th>Tipo</th>
					<th>Data/Hora Início</th>
					<th>Data/Hora Fim</th>
					<th>Duração</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($apontamentos)): ?>
					<tr><td colspan="4" class="text-center">Nenhum apontamento principal registrado.</td></tr>
				<?php else: ?>
					<?php foreach($apontamentos as $ap): ?>
					<?php
						$dataBase = $boletim['data_abertura'];
						$dataInicio = new DateTime($dataBase . ' ' . $ap['hora_inicio']);
					?>
					<tr>
						<td><?= htmlspecialchars($ap['tipo_apontamento_nome']) ?></td>
						<td><?= $dataInicio->format('d/m/Y H:i') ?></td>
						<td>
							<?php
							if (!empty($ap['hora_fim'])) {
								$dataFim = new DateTime($dataBase . ' ' . $ap['hora_fim']);
								if ($dataFim < $dataInicio) {
									$dataFim->add(new DateInterval('P1D'));
								}
								echo $dataFim->format('d/m/Y H:i');
							} else {
								echo '---';
							}
							?>
						</td>
						<td>
							<?php
							if (!empty($ap['hora_fim'])) {
								$duracao = $dataInicio->diff($dataFim);
								echo $duracao->format('%H:%I:%S');
							} else {
								echo "Em andamento";
							}
							?>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<h5 class="border-bottom pb-2 mt-4">ROTAS / ENTREGAS</h5>
		<table class="table table-sm table-striped">
			<thead class="table-dark">
				<tr>
					<th>Data/Hora</th>
					<th>Destino/Local</th>
					<th>Status</th>
					<th>Observação</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($rotas)): ?>
					<tr><td colspan="4" class="text-center">Nenhuma rota/entrega registrada.</td></tr>
				<?php else: ?>
					<?php foreach($rotas as $rota): ?>
					<tr>
						<td><?= date('d/m/Y H:i', strtotime($rota['data_registro'])) ?></td>
						<td><?= htmlspecialchars($rota['destino']) ?></td>
						<td><?= htmlspecialchars($rota['status_entrega']) ?></td>
						<td><?= htmlspecialchars($rota['observacao']) ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

		<h5 class="border-bottom pb-2 mt-4">ABASTECIMENTOS</h5>
		<table class="table table-sm table-striped">
			<thead class="table-dark">
				<tr>
					<th>Data/Hora</th>
					<th>Local</th>
					<th>Litros</th>
					<th>Valor (R$)</th>
					<th>KM</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($abastecimentos)): ?>
					<tr><td colspan="5" class="text-center">Nenhum abastecimento registrado.</td></tr>
				<?php else: ?>
					<?php foreach($abastecimentos as $abs): ?>
					<?php
						$dataInicioAbs = new DateTime($boletim['data_abertura'] . ' ' . $abs['hora_inicio']);
						if (!empty($abs['hora_fim']) && $abs['hora_fim'] < $abs['hora_inicio']) {
							$dataInicioAbs->add(new DateInterval('P1D'));
						}
					?>
					<tr>
						<td><?= $dataInicioAbs->format('d/m/Y H:i') ?></td>
						<td><?= htmlspecialchars($abs['local'] ?? 'N/D') ?></td>
						<td><?= htmlspecialchars($abs['litros'] ?? '0.00') ?> L</td>
						<td>R$ <?= number_format($abs['valor'] ?? 0, 2, ',', '.') ?></td>
						<td><?= htmlspecialchars($abs['km'] ?? 'N/D') ?> KM</td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
		
		<h5 class="border-bottom pb-2 mt-4">REVISÕES / PROBLEMAS REPORTADOS</h5>
		<table class="table table-sm table-striped">
			<thead class="table-dark">
				<tr>
					<th>Data/Hora</th>
					<th>Tipo</th>
					<th>Urgência</th>
					<th>KM</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
				<?php if(empty($revisoes)): ?>
					<tr><td colspan="5" class="text-center">Nenhuma revisão reportada.</td></tr>
				<?php else: ?>
					<?php foreach($revisoes as $rev): ?>
					<tr>
						<td><?= date('d/m/Y H:i', strtotime($rev['data_registro'])) ?></td>
						<td><?= htmlspecialchars($rev['tipo_revisao']) ?></td>
						<td><?= htmlspecialchars($rev['urgencia']) ?></td>
						<td><?= htmlspecialchars($rev['km_veiculo']) ?> KM</td>
						<td><?= htmlspecialchars($rev['descricao_problema']) ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>

	</div>
</div>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>