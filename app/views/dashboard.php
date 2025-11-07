<?php 
$pageTitle = "Dashboard de Monitoramento";
require_once 'partials/header.php'; 
?>

<div class="container-fluid">
	
	<div class="row mb-4">
		<div class="col-md-3">
			<div class="card kpi-card text-start">
				<div class="card-body">
					<i class="bi bi-people-fill kpi-icon"></i>
					<h6 class="card-subtitle mb-2 text-muted">Funcionários Ativos</h6>
					<h2 class="card-title" id="kpi-funcionarios">...</h2>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card kpi-card text-start">
				<div class="card-body">
					<i class="bi bi-truck kpi-icon"></i>
					<h6 class="card-subtitle mb-2 text-muted">Em Serviço (Boletim Aberto)</h6>
					<h2 class="card-title text-success" id="kpi-em-servico">...</h2>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card kpi-card text-start">
				<div class="card-body">
					<i class="bi bi-play-circle-fill kpi-icon"></i>
					<h6 class="card-subtitle mb-2 text-muted">Viagens em Andamento</h6>
					<h2 class="card-title text-primary" id="kpi-em-viagem">...</h2>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card kpi-card text-start">
				<div class="card-body">
					<i class="bi bi-exclamation-triangle-fill kpi-icon"></i>
					<h6 class="card-subtitle mb-2 text-muted">Revisões Urgentes</h6>
					<h2 class="card-title text-danger" id="kpi-revisoes">...</h2>
				</div>
			</div>
		</div>
	</div>
	<hr class="mb-4">

	<h3 class="mb-4">Monitoramento do Diario</h3>

	<div id="dashboard-monitor" class="row">
		<div class="col-12 text-center mt-5">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">Carregando...</span>
			</div>
			<p class="mt-2">Carregando dados do monitoramento...</p>
		</div>
	</div>
</div>

<?php 
require_once 'partials/footer.php'; 
?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const monitorContainer = document.getElementById('dashboard-monitor');
		const baseUrl = '<?= BASE_URL ?>';

		const kpiFuncionarios = document.getElementById('kpi-funcionarios');
		const kpiEmServico = document.getElementById('kpi-em-servico');
		const kpiEmViagem = document.getElementById('kpi-em-viagem');
		const kpiRevisoes = document.getElementById('kpi-revisoes');

		function buildCardHTML(item) {
			const funcionario = item.funcionario;
			const boletim = item.boletim;
			const statusInfo = item.status_info;

			let veiculoHTML = '<p class="mb-2"><strong>Veículo:</strong> ---</p>';
			let boletimHTML = '<p class="mb-0"><strong>Boletim:</strong> ---</p>';

			if (boletim) {
				veiculoHTML = `<p class="mb-2"><strong>Veículo:</strong> ${boletim.veiculo_placa}</p>`;
				boletimHTML = `<p class="mb-0"><strong>Boletim:</strong> <a href="${baseUrl}/relatorio/boletim/${boletim.id}">#${boletim.id}</a> (Aberto às ${boletim.hora_abertura.substring(0, 5)})</p>`;
			}

			return `
				<div class="col-md-6 col-lg-4 mb-4">
					<div class="card h-100 shadow-sm monitor-card">
						<div class="card-header d-flex justify-content-between align-items-center">
							<h5 class="mb-0">${funcionario.nome}</h5>
							<span class="badge ${statusInfo.badge_classe}">${statusInfo.badge_texto}</span>
						</div>
						<div class="card-body">
							<p class="mb-2"><strong>Cargo:</strong> ${funcionario.cargo}</p>
							${veiculoHTML}
							${boletimHTML}
						</div>
						<div class="card-footer text-center">
							<i class="bi ${statusInfo.status_icon} ${statusInfo.status_classe} status-icon"></i>
							<h5 class="mb-0 ${statusInfo.status_classe}">
								${statusInfo.status_texto}
							</h5>
							<small>Desde às ${statusInfo.desde.substring(0, 5)}</small>
						</div>
					</div>
				</div>
			`;
		}

		async function fetchDashboardData() {
			try {
				const response = await fetch(`${baseUrl}/dashboard/getStatus`);
				if (!response.ok) {
					throw new Error('Falha ao buscar dados do dashboard.');
				}
				const data = await response.json(); 

				kpiFuncionarios.textContent = data.kpis.total_funcionarios;
				kpiEmServico.textContent = data.kpis.em_servico;
				kpiEmViagem.textContent = data.kpis.em_viagem;
				kpiRevisoes.textContent = data.kpis.revisoes_urgentes;

				monitorContainer.innerHTML = '';
				if (data.monitoramento.length === 0) {
					monitorContainer.innerHTML = '<div class="col-12"><div class="alert alert-info">Nenhum funcionário ativo encontrado.</div></div>';
					return;
				}
				data.monitoramento.forEach(item => {
					monitorContainer.innerHTML += buildCardHTML(item);
				});

			} catch (error) {
				console.error(error);
				monitorContainer.innerHTML = '<div class="col-12"><div class="alert alert-danger">Erro ao carregar o dashboard. Tente recarregar a página.</div></div>';
			}
		}

		fetchDashboardData();
		setInterval(fetchDashboardData, 15000);
	});
</script>