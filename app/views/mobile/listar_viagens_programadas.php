<?php 
$pageTitle = "Selecionar Viagem";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php if (empty($viagensDisponiveis)): ?>
	<div class="alert alert-warning text-center">
		Nenhuma viagem programada encontrada para você no momento.
	</div>
	<div class="d-grid">
		<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary">Voltar</a>
	</div>
<?php else: ?>
	<div class="list-group">
		<?php foreach ($viagensDisponiveis as $viagem): ?>
			<a href="<?= BASE_URL ?>/mobile/iniciarViagem/<?= $viagem['id'] ?>" class="list-group-item list-group-item-action" onclick="return confirm('Deseja iniciar a viagem: <?= htmlspecialchars($viagem['titulo']) ?>?')">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1"><?= htmlspecialchars($viagem['titulo']) ?></h5>
					<small><?= date('d/m/Y H:i', strtotime($viagem['data_prevista_inicio'])) ?></small>
				</div>
				<p class="mb-1">Destino: <?= htmlspecialchars($viagem['destino'] ?? 'Não informado') ?></p>
			</a>
		<?php endforeach; ?>
	</div>
	<div class="d-grid mt-3">
		<a href="<?= BASE_URL ?>/mobile/home" class="btn btn-secondary">Cancelar</a>
	</div>
<?php endif; ?>


<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>