<?php 
$pageTitle = "Central de Relatórios";
require_once 'partials/header.php'; 
?>

<div class="row">
	<div class="col-md-4 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Relatório de Produtividade</h5>
				<p class="card-text">Analise o tempo total gasto por funcionário em cada tipo de atividade (Viagens, Paradas, etc.).</p>
				<a href="<?= BASE_URL ?>/relatorio/produtividade" class="btn btn-primary mt-auto">Acessar Relatório</a>
			</div>
		</div>
	</div>

	<div class="col-md-4 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Relatório de Consumo (KM/L)</h5>
				<p class="card-text">Calcule a média de consumo de combustível (KM/L) para cada veículo da frota em um período.</p>
				<a href="<?= BASE_URL ?>/relatorio/consumo" class="btn btn-primary mt-auto">Acessar Relatório</a>
			</div>
		</div>
	</div>
	
	<div class="col-md-4 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Relatório de Análise de Paradas</h5>
				<p class="card-text">Some o tempo total gasto e o número de ocorrências para cada motivo de parada (Refeição, Manutenção, etc.).</p>
				<a href="<?= BASE_URL ?>/relatorio/paradas" class="btn btn-primary mt-auto">Acessar Relatório</a>
			</div>
		</div>
	</div>

	<div class="col-md-4 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Relatório de Revisões/Problemas</h5>
				<p class="card-text">Liste todos os problemas mecânicos e revisões reportados pelos motoristas em campo.</p>
				<a href="<?= BASE_URL ?>/relatorio/revisoes" class="btn btn-primary mt-auto">Acessar Relatório</a>
			</div>
		</div>
	</div>
	
	<div class="col-md-4 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Relatório de Inconsistências</h5>
				<p class="card-text">Audite boletins com jornadas extensas (acima de 10h) ou paradas de refeição muito longas (acima de 1h30m).</p>
				<a href="<?= BASE_URL ?>/relatorio/inconsistencias" class="btn btn-primary mt-auto">Acessar Relatório</a>
			</div>
		</div>
	</div>

	<div class="col-md-4 mb-4">
		<div class="card h-100">
			<div class="card-body d-flex flex-column">
				<h5 class="card-title">Relatório Detalhado de Boletim</h5>
				<p class="card-text">Gere o extrato detalhado de um dia de trabalho específico selecionando um boletim.</p>
				<a href="<?= BASE_URL ?>/relatorio/boletim" class="btn btn-primary mt-auto">Acessar Relatório</a>
			</div>
		</div>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>