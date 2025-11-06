<?php 
$pageTitle = "Relatório de Consumo";
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
	<div class="card-header">
		Filtro de Consumo de Combustível (KM/L)
	</div>
	<div class="card-body">
		<form method="POST" action="<?= BASE_URL ?>/relatorio/consumo">
			<input type="hidden" name="filtro_consumo" value="1">
			<div class="row align-items-end">
				<div class="col-md-4 mb-3">
					<label for="data_inicio" class="form-label">Data de Início (Fechamento):</label>
					<input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $_POST['data_inicio'] ?? date('Y-m-01') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="data_fim" class="form-label">Data de Fim (Fechamento):</label>
					<input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= $_POST['data_fim'] ?? date('Y-m-t') ?>" required>
				</div>
				<div class="col-md-4 mb-3">
					<label for="veiculo_id" class="form-label">Veículo:</label>
					<select id="veiculo_id" name="veiculo_id" class="form-select">
						<option value="">Todos os Veículos</option>
						<?php foreach ($veiculos as $veiculo): ?>
							<option value="<?= $veiculo['id'] ?>" <?= (isset($_POST['veiculo_id']) && $_POST['veiculo_id'] == $veiculo['id']) ? 'selected' : '' ?>>
								<?= htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['modelo']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">
				<i class="bi bi-funnel-fill me-2"></i>Gerar Relatório de Consumo
			</button>
		</form>
	</div>
</div>

<?php if (isset($resultados)): ?>
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

			<h2 class="text-center mb-3">Relatório de Consumo de Combustível</h2>

			<div class="border p-3 rounded mb-4">
				<h5 class="border-bottom pb-2">PARÂMETROS DA ANÁLISE</h5>
				<div class="row mt-3">
					<div class="col-md-6">
						<strong>Período Analisado:</strong> 
						<?= date('d/m/Y', strtotime($filtroInfo['dataInicio'])) ?> até <?= date('d/m/Y', strtotime($filtroInfo['dataFim'])) ?>
					</div>
					<div class="col-md-6">
						<strong>Veículo(s):</strong> 
						<?= htmlspecialchars($filtroInfo['veiculoNome']) ?>
					</div>
				</div>
			</div>

			<h5 class="border-bottom pb-2">RESULTADOS</h5>
			<?php if (empty($resultados)): ?>
				<div class="alert alert-info" role="alert">
					Nenhum resultado encontrado. Verifique se existem boletins fechados no período.
				</div>
			<?php else: ?>
				<table class="table table-striped table-hover align-middle">
					<thead class="table-dark">
						<tr>
							<th>Veículo</th>
							<th>Placa</th>
							<th>Total KM Rodado</th>
							<th>Total Litros Abastecidos</th>
							<th>Média (KM/L)</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($resultados as $veiculo): 
							$totalKm = $veiculo['total_km_rodado'];
							$totalLitros = $veiculo['total_litros'];
							$mediaKmL = 0;
							if ($totalLitros > 0) {
								$mediaKmL = $totalKm / $totalLitros;
							}
						?>
							<tr>
								<td><?= htmlspecialchars($veiculo['modelo']) ?></td>
								<td><?= htmlspecialchars($veiculo['placa']) ?></td>
								<td><?= number_format($totalKm, 2, ',', '.') ?> KM</td>
								<td><?= number_format($totalLitros, 2, ',', '.') ?> L</td>
								<td>
									<strong>
										<?= number_format($mediaKmL, 2, ',', '.') ?> KM/L
									</strong>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>

		</div>
	</div>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>