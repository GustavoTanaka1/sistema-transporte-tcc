<?php 
$pageTitle = "Boletim";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<?php if ($boletimAberto): ?>
	
	<div class="alert alert-success text-center mb-4">
		<strong>Boletim #<?= $boletimAberto['id'] ?> Aberto</strong><br>
		Iniciado em <?= date('d/m/Y \à\s H:i', strtotime($boletimAberto['data_abertura'] . ' ' . $boletimAberto['hora_abertura'])) ?>
	</div>

	<?php if ($atividadeAtual): ?>
		<div class="alert alert-warning text-center mb-4">
			<strong>Atividade Atual:</strong> <?= htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) ?><br>
			Iniciada às <?= htmlspecialchars($atividadeAtual['hora_inicio']) ?>
		</div>
		
		<div class="d-grid gap-3">
			<?php if ($atividadeAtual['tipo_apontamento_nome'] == 'Viagem Programada'): ?>
				<a href="<?= BASE_URL ?>/mobile/apontarParada" class="btn btn-primary btn-full-width">Apontar Parada</a>
				<a href="<?= BASE_URL ?>/mobile/apontarAbastecimento" class="btn btn-primary btn-full-width">Apontar Abastecimento</a>
				<a href="<?= BASE_URL ?>/mobile/finalizarViagemDefinitivamente" class="btn btn-warning btn-full-width">Finalizar Viagem Definitivamente</a>
			<?php else: ?>
				<a href="<?= BASE_URL ?>/mobile/finalizarAtividadeAtual" class="btn btn-warning btn-full-width">
					<i class="bi bi-stop-circle-fill me-2"></i>
					Finalizar <?= htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) ?>
				</a>
			<?php endif; ?>
			<a href="<?= BASE_URL ?>/mobile/fecharBoletim" class="btn btn-danger btn-full-width">Fechar Boletim</a>
		</div>
		
	<?php else: ?>
		<div class="d-grid gap-3">
			<a href="<?= BASE_URL ?>/mobile/listarViagensProgramadas" class="btn btn-primary btn-full-width">Iniciar Viagem Programada</a>
			<a href="<?= BASE_URL ?>/mobile/apontarParada" class="btn btn-primary btn-full-width">Apontar Parada (Avulsa)</a>
			<a href="<?= BASE_URL ?>/mobile/apontarAbastecimento" class="btn btn-primary btn-full-width">Apontar Abastecimento (Avulso)</a>
			<a href="<?= BASE_URL ?>/mobile/fecharBoletim" class="btn btn-danger btn-full-width">Fechar Boletim</a>
		</div>
	<?php endif; ?>

<?php else: ?>

	<div class="user-card mb-4">
		<div class="info-item">
			<strong>Nome:</strong>
			<span><?= htmlspecialchars($funcionario['nome']) ?></span>
		</div>
		<div class="info-item">
			<strong>Função:</strong>
			<span><?= htmlspecialchars($funcionario['cargo']) ?></span>
		</div>
		<div class="info-item mb-0">
			<strong>Telefone:</strong>
			<span><?= htmlspecialchars($funcionario['telefone']) ?></span>
		</div>
	</div>

	<a href="<?= BASE_URL ?>/mobile/abrirBoletim" class="btn btn-primary btn-full-width">
		<i class="bi bi-play-circle-fill me-2"></i>
		Abrir Boletim
	</a>

<?php endif; ?>

<footer class="footer-mobile">
	<a href="<?= BASE_URL ?>/mobile/logout" class="btn btn-outline-danger btn-sm">Sair</a>
</footer>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>