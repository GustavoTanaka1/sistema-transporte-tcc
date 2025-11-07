<?php 
$pageTitle = "Dashboard de Monitoramento";
require_once 'partials/header.php'; 
?>

<div class="container-fluid">
	<h3 class="mb-4">Monitoramento em Tempo Real</h3>

	<div class="row">
		<?php if (empty($monitoramento)): ?>
			<div class="col-12">
				<div class="alert alert-info">Nenhum funcionário com boletim aberto no momento.</div>
			</div>
		<?php else: ?>
			<?php foreach ($monitoramento as $item): 
				$boletim = $item['boletim'];
				$atividade = $item['atividade_atual'];

				$statusTexto = "Ocioso";
				$statusClasse = "text-secondary";
				$statusDesde = $boletim['hora_abertura'];

				if ($atividade) {
					$statusTexto = $atividade['tipo_apontamento_nome'];
					$statusDesde = $atividade['hora_inicio'];
					if ($statusTexto == 'Viagem Programada') {
						$statusClasse = 'text-primary';
					} elseif ($statusTexto == 'Parada') {
						$statusClasse = 'text-warning';
					} else {
						$statusClasse = 'text-info';
					}
				}
			?>
				<div class="col-md-6 col-lg-4 mb-4">
					<div class="card h-100 shadow-sm">
						<div class="card-header d-flex justify-content-between align-items-center">
							<h5 class="mb-0"><?= htmlspecialchars($boletim['funcionario_nome']) ?></h5>
							<span class="badge bg-success">Boletim Aberto</span>
						</div>
						<div class="card-body">
							<p class="mb-2">
								<strong>Veículo:</strong> <?= htmlspecialchars($boletim['veiculo_placa']) ?>
							</p>
							<p class="mb-0">
								<strong>Boletim:</strong> 
								<a href="<?= BASE_URL ?>/relatorio/boletim/<?= $boletim['id'] ?>">#<?= $boletim['id'] ?></a>
								(Aberto às <?= date('H:i', strtotime($boletim['hora_abertura'])) ?>)
							</p>
						</div>
						<div class="card-footer text-center">
							<strong class="d-block text-muted">Status Atual</strong>
							<h4 class="mb-0 <?= $statusClasse ?>">
								<i class="bi bi-clock-history me-1"></i>
								<?= htmlspecialchars($statusTexto) ?>
							</h4>
							<small>Desde às <?= htmlspecialchars($statusDesde) ?></small>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>