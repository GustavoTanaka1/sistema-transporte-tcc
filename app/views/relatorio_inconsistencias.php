<?php 
$pageTitle = "Relatório de Inconsistências";
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header">
		Filtro de Análise de Inconsistências
	</div>
	<div class="card-body">
		<form method="POST" action="<?= BASE_URL ?>/relatorio/inconsistencias">
			<input type="hidden" name="filtro_inconsistencias" value="1">
			<div class="row align-items-end">
				<div class="col-md-4 mb-3">
					<label for="data_inicio" class="form-label">Data de Início (Boletim):</label>
					<input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $_POST['data_inicio'] ?? date('Y-m-01') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="data_fim" class="form-label">Data de Fim (Boletim):</label>
					<input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= $_POST['data_fim'] ?? date('Y-m-t') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<button type="submit" class="btn btn-primary w-100">
						<i class="bi bi-funnel-fill me-2"></i>Gerar Relatório de Inconsistências
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php if (isset($filtroInfo)): ?>
	<div class="card">
		<div class="card-body p-4">
			
			<div class="row align-items-center border-bottom pb-3 mb-3">
				<div class="col-md-6">
					<h3 class="mb-0">Tanaka Transportes</h3>
					<p class="mb-0">Rua Mozart Silva 180, Jardim Santa Lúcia, São Joaquim da Barra</p>
					<p class="mb-0">tanakatransportes.com</p>
				</div>
				<div class="col-md-6 text-md-end">
					<strong>Data de Emissão:</strong> <?= date('d/m/Y H:i:s') ?><br>
					<strong>Status:</strong> Finalizado
				</div>
			</div>

			<h2 class="text-center mb-3">Relatório de Auditoria de Inconsistências</h2>

			<div class="border p-3 rounded mb-4">
				<h5 class="border-bottom pb-2">PARÂMETROS DA ANÁLISE</h5>
				<div class="row mt-3">
					<div class="col-md-6">
						<strong>Período Analisado:</strong> 
						<?= date('d/m/Y', strtotime($filtroInfo['dataInicio'])) ?> até <?= date('d/m/Y', strtotime($filtroInfo['dataFim'])) ?>
					</div>
				</div>
			</div>

			<h5 class="border-bottom pb-2 mt-4">ALERTA: JORNADAS EXTENSAS (Acima de 10h)</h5>
			<?php if (empty($boletinsExtensos)): ?>
				<div class="alert alert-success" role="alert">
					Nenhum boletim com jornada extensa encontrado no período.
				</div>
			<?php else: ?>
				<table class="table table-striped table-hover align-middle">
					<thead class="table-dark">
						<tr>
							<th>Boletim #</th>
							<th>Data</th>
							<th>Funcionário</th>
							<th>Duração Total</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($boletinsExtensos as $boletim): ?>
							<tr>
								<td><?= $boletim['boletim_id'] ?></td>
								<td><?= date('d/m/Y', strtotime($boletim['data_abertura'])) ?></td>
								<td><?= htmlspecialchars($boletim['funcionario_nome']) ?></td>
								<td><strong class="text-danger"><?= htmlspecialchars($boletim['duracao_total']) ?></strong></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

			<h5 class="border-bottom pb-2 mt-4">ALERTA: PARADAS DE REFEIÇÃO (Acima de 1h30m)</h5>
			<?php if (empty($paradasLongas)): ?>
				<div class="alert alert-success" role="alert">
					Nenhuma parada de refeição extensa encontrada no período.
				</div>
			<?php else: ?>
				<table class="table table-striped table-hover align-middle">
					<thead class="table-dark">
						<tr>
							<th>Boletim #</th>
							<th>Data</th>
							<th>Funcionário</th>
							<th>Duração da Parada</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($paradasLongas as $parada): ?>
							<tr>
								<td><?= $parada['boletim_id'] ?></td>
								<td><?= date('d/m/Y', strtotime($parada['data_abertura'])) ?></td>
								<td><?= htmlspecialchars($parada['funcionario_nome']) ?></td>
								<td><strong class="text-danger"><?= htmlspecialchars($parada['duracao_parada']) ?></strong></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

		</div>
	</div>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>