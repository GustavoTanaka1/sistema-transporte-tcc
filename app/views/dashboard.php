<?php 
$pageTitle = "Dashboard Operacional | Tanaka Transportes";
require_once 'partials/header.php'; 
$baseUrlSegura = defined('BASE_URL') ? BASE_URL : '';
?>

<div class="container-fluid bg-light" style="min-height: 100vh;">
	
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 border-bottom">
		<h1 class="h2 text-dark"><i class="bi bi-speedometer2 me-2"></i>Visão Geral da Frota</h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center" onclick="window.location.reload()">
				<i class="bi bi-arrow-clockwise me-1"></i> Atualizar
			</button>
		</div>
	</div>

	<div class="row mb-4 g-3">
		<div class="col-md-3">
			<div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Motoristas Ativos</h6>
							<h2 class="mb-0 fw-bold display-6" id="kpi-funcionarios">...</h2>
						</div>
						<div class="bg-primary bg-opacity-10 p-3 rounded-3">
							<i class="bi bi-person-badge text-primary fs-3"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card border-0 shadow-sm h-100 border-start border-4 border-success">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Boletins Abertos</h6>
							<h2 class="mb-0 fw-bold display-6 text-success" id="kpi-em-servico">...</h2>
						</div>
						<div class="bg-success bg-opacity-10 p-3 rounded-3">
							<i class="bi bi-clipboard-data text-success fs-3"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Em Viagem/Rota</h6>
							<h2 class="mb-0 fw-bold display-6 text-info" id="kpi-em-viagem">...</h2>
						</div>
						<div class="bg-info bg-opacity-10 p-3 rounded-3">
							<i class="bi bi-truck text-info fs-3"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.8rem;">Revisões Pendentes</h6>
							<h2 class="mb-0 fw-bold display-6 text-danger" id="kpi-revisoes">...</h2>
						</div>
						<div class="bg-danger bg-opacity-10 p-3 rounded-3">
							<i class="bi bi-tools text-danger fs-3"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-4 g-3">
		<div class="col-lg-12">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-header bg-white py-3">
					<h6 class="card-title mb-0 fw-bold"><i class="bi bi-graph-up me-2"></i>Produtividade: Volume de Viagens Realizadas</h6>
				</div>
				<div class="card-body">
					<div style="height: 300px;">
						<canvas id="chartViagens"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-4 g-3">
		<div class="col-lg-4">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-header bg-white py-3">
					<h6 class="card-title mb-0 fw-bold">Disponibilidade da Frota</h6>
				</div>
				<div class="card-body position-relative d-flex align-items-center justify-content-center">
					<div style="height: 250px; width: 100%">
						<canvas id="chartFrota"></canvas>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-8">
			<div class="card border-0 shadow-sm h-100">
				<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
					<h6 class="card-title mb-0 fw-bold"><i class="bi bi-trophy me-2 text-warning"></i>Top 5 Motoristas (Mais Viagens)</h6>
					<span class="badge bg-light text-dark border">Geral</span>
				</div>
				<div class="card-body">
					<div style="height: 250px;">
						<canvas id="chartRanking"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="d-flex justify-content-between align-items-center mb-3">
		<h5 class="fw-bold mb-0 text-secondary">Monitoramento em Tempo Real</h5>
		<div class="d-flex align-items-center">
			<span class="badge bg-success pulse-animation me-2">● Online</span>
			<small class="text-muted" id="last-update">Atualizando...</small>
		</div>
	</div>

	<div id="dashboard-monitor" class="row g-3">
		<div class="col-12 text-center py-5">
			<div class="spinner-border text-primary" role="status"></div>
			<p class="mt-2 text-muted">Carregando dados operacionais...</p>
		</div>
	</div>
</div>

<style>
	.pulse-animation { animation: pulse 2s infinite; }
	@keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
	.card { transition: transform 0.2s ease-in-out; }
	.monitor-card:hover { transform: translateY(-3px); }
</style>

<?php require_once 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
	let rawBaseUrl = <?php echo json_encode($baseUrlSegura); ?>;
	const baseUrl = rawBaseUrl.replace(/\/$/, ""); 
	
	const monitorContainer = document.getElementById('dashboard-monitor');
	const lastUpdateEl = document.getElementById('last-update');
	
	let chartViagens = null;
	let chartFrota = null;
	let chartRanking = null;

	function initCharts() {
		const ctxViagens = document.getElementById('chartViagens').getContext('2d');
		const gradient = ctxViagens.createLinearGradient(0, 0, 0, 400);
		gradient.addColorStop(0, 'rgba(13, 29, 253, 0.5)');
		gradient.addColorStop(1, 'rgba(13, 121, 253, 0)');

		chartViagens = new Chart(ctxViagens, {
			type: 'line',
			data: {
				labels: [],
				datasets: [{
					label: 'Total de Viagens',
					data: [],
					backgroundColor: gradient,
					borderColor: '#0d6efd',
					borderWidth: 2,
					fill: true,
					tension: 0.4
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: { legend: { display: false } },
				scales: { 
					y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
					x: { grid: { display: false } }
				}
			}
		});

		const ctxFrota = document.getElementById('chartFrota').getContext('2d');
		chartFrota = new Chart(ctxFrota, {
			type: 'doughnut',
			data: {
				labels: [],
				datasets: [{
					data: [],
					backgroundColor: ['#198754', '#e9ecef'],
					hoverOffset: 4,
					borderWidth: 0
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				cutout: '70%',
				plugins: { legend: { position: 'bottom' } }
			}
		});

		const ctxRanking = document.getElementById('chartRanking').getContext('2d');
		chartRanking = new Chart(ctxRanking, {
			type: 'bar',
			data: {
				labels: [],
				datasets: [{
					label: 'Viagens Realizadas',
					data: [],
					backgroundColor: '#ffc107',
					borderRadius: 4,
					barThickness: 20
				}]
			},
			options: {
				indexAxis: 'y',
				responsive: true,
				maintainAspectRatio: false,
				plugins: { legend: { display: false } },
				scales: { 
					x: { beginAtZero: true, grid: { display: false } },
					y: { grid: { display: false } }
				}
			}
		});
	}

	async function fetchData() {
		try {
			const endpoint = `${baseUrl}/dashboard/getStatus`;
			const response = await fetch(endpoint);
			if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
			const data = await response.json();

			// KPIs
			if (data.kpis) {
				document.getElementById('kpi-funcionarios').textContent = data.kpis.total_funcionarios;
				document.getElementById('kpi-em-servico').textContent = data.kpis.em_servico;
				document.getElementById('kpi-em-viagem').textContent = data.kpis.em_viagem;
				document.getElementById('kpi-revisoes').textContent = data.kpis.revisoes_urgentes;
			}

			// Atualiza Gráficos
			if (chartViagens && data.graficos.viagens) {
				chartViagens.data.labels = data.graficos.viagens.labels;
				chartViagens.data.datasets[0].data = data.graficos.viagens.dados;
				chartViagens.update();
			}

			if (chartFrota && data.graficos.frota) {
				chartFrota.data.labels = data.graficos.frota.labels;
				chartFrota.data.datasets[0].data = data.graficos.frota.dados;
				chartFrota.update();
			}

			if (chartRanking && data.graficos.ranking) {
				chartRanking.data.labels = data.graficos.ranking.labels;
				chartRanking.data.datasets[0].data = data.graficos.ranking.dados;
				chartRanking.update();
			}

			renderMonitorCards(data.monitoramento);
			
			const now = new Date();
			lastUpdateEl.textContent = `Atualizado às ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

		} catch (error) {
			console.error("Erro Dashboard:", error);
		}
	}

	function renderMonitorCards(items) {
		monitorContainer.innerHTML = '';
		if (!items || items.length === 0) {
			monitorContainer.innerHTML = `<div class="col-12 text-center py-5 text-muted">Sem atividades recentes.</div>`;
			return;
		}

		items.forEach(item => {
			const f = item.funcionario;
			const b = item.boletim;
			const s = item.status_info;
			const hora = s.desde ? s.desde.substring(0, 5) : '--:--';

			const html = `
			<div class="col-md-6 col-lg-4 mb-3">
				<div class="card h-100 border-0 shadow-sm monitor-card">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-start mb-3">
							<div><h6 class="fw-bold mb-0 text-dark">${f.nome}</h6><small class="text-muted">${f.cargo}</small></div>
							<span class="badge ${s.badge_classe} rounded-pill">${s.badge_texto}</span>
						</div>
						<div class="bg-light p-3 rounded-3 mb-3 border">
							<div class="d-flex justify-content-between mb-1"><span class="text-secondary small">Veículo</span><span class="fw-bold text-dark small">${b.veiculo_placa}</span></div>
							<div class="d-flex justify-content-between"><span class="text-secondary small">Boletim</span><a href="${baseUrl}/relatorio/boletim/${b.id}" class="text-primary fw-bold small text-decoration-none">#${b.id}</a></div>
						</div>
						<div class="d-flex align-items-center justify-content-between pt-2 border-top">
							<div class="${s.status_classe} fw-bold small"><i class="bi ${s.status_icon} me-1"></i> ${s.status_texto}</div>
							<div class="text-muted small"><i class="bi bi-clock me-1"></i> ${hora}</div>
						</div>
					</div>
				</div>
			</div>`;
			monitorContainer.innerHTML += html;
		});
	}

	initCharts();
	fetchData(); 
	setInterval(fetchData, 100000); 
});
</script>