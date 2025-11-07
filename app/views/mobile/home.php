<?php 
$pageTitle = "Boletim";
require_once PROJECT_ROOT . '/app/views/partials/mobile_header.php'; 
?>

<?php FlashMessage::display(); ?>

<?php if ($boletimAberto): ?>
	
	<div class="status-card status-card-boletim">
		<i class="bi bi-check-circle-fill"></i>
		<div>
			<strong>Boletim #<?= $boletimAberto['id'] ?> Aberto</strong>
			<small>Iniciado em <?= date('d/m/Y \à\s H:i', strtotime($boletimAberto['data_abertura'] . ' ' . $boletimAberto['hora_abertura'])) ?></small>
		</div>
	</div>

	<?php if ($atividadeAtual): ?>
		<div class="status-card status-card-atividade">
			<i class="bi bi-clock-history"></i>
			<div>
				<strong><?= htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) ?></strong>
				<small>Iniciada às <?= htmlspecialchars($atividadeAtual['hora_inicio']) ?></small>
			</div>
		</div>
		
		<div class="action-buttons">
			<?php if ($atividadeAtual['tipo_apontamento_nome'] == 'Viagem Programada'): ?>
				<a href="<?= BASE_URL ?>/mobile/apontarRota" class="btn btn-info btn-full-width">Apontar Rota/Entrega</a> 
				<a href="<?= BASE_URL ?>/mobile/apontarParada" class="btn btn-primary btn-full-width">Apontar Parada</a>
				<a href="<?= BASE_URL ?>/mobile/apontarAbastecimento" class="btn btn-primary btn-full-width">Apontar Abastecimento</a>
				<a href="<?= BASE_URL ?>/mobile/apontarRevisao" class="btn btn-secondary btn-full-width">Apontar Revisão/Problema</a>
				<a href="<?= BASE_URL ?>/mobile/finalizarViagemDefinitivamente" class="btn btn-warning btn-full-width">Finalizar Viagem Definitivamente</a>
			<?php else: ?>
				<a href="<?= BASE_URL ?>/mobile/finalizarAtividadeAtual" class="btn btn-warning btn-full-width">
					<i class="bi bi-stop-circle-fill me-2"></i>
					Finalizar <?= htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) ?>
				</a>
				<a href="<?= BASE_URL ?>/mobile/apontarRevisao" class="btn btn-secondary btn-full-width">Apontar Revisão/Problema</a>
			<?php endif; ?>
			<a href="<?= BASE_URL ?>/mobile/fecharBoletim" class="btn btn-danger btn-full-width">Fechar Boletim</a>
			<a href="<?= BASE_URL ?>/mobile/logout" class="btn btn-outline-danger btn-full-width">Sair (Logout)</a>
		</div>
		
	<?php else: ?>
		<div class="action-buttons">
			<a href="<?= BASE_URL ?>/mobile/listarViagensProgramadas" class="btn btn-primary btn-full-width">Iniciar Viagem Programada</a>
			<a href="<?= BASE_URL ?>/mobile/apontarParada" class="btn btn-primary btn-full-width">Apontar Parada (Avulsa)</a>
			<a href="<?= BASE_URL ?>/mobile/apontarAbastecimento" class="btn btn-primary btn-full-width">Apontar Abastecimento (Avulso)</a>
			<a href="<?= BASE_URL ?>/mobile/apontarRevisao" class="btn btn-secondary btn-full-width">Apontar Revisão/Problema</a>
			<a href="<?= BASE_URL ?>/mobile/fecharBoletim" class="btn btn-danger btn-full-width">Fechar Boletim</a>
			<a href="<?= BASE_URL ?>/mobile/logout" class="btn btn-outline-danger btn-full-width">Sair (Logout)</a>
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
	
	<div class="d-grid gap-3 mt-3">
		<a href="<?= BASE_URL ?>/mobile/logout" class="btn btn-outline-danger btn-full-width">Sair (Logout)</a>
	</div>

<?php endif; ?>

<?php require_once PROJECT_ROOT . '/app/views/partials/mobile_footer.php'; ?>