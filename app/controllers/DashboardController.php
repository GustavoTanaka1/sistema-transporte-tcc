<?php

require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/dao/FuncionarioDAO.php';
require_once PROJECT_ROOT . '/app/dao/RevisaoDAO.php';

class DashboardController {

	private $boletimDAO;
	private $apontamentoDAO;
	private $funcionarioDAO;
	private $revisaoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->boletimDAO = new BoletimDAO();
		$this->apontamentoDAO = new ApontamentoDAO();
		$this->funcionarioDAO = new FuncionarioDAO();
		$this->revisaoDAO = new RevisaoDAO();
	}

	public function index() {
		require_once PROJECT_ROOT . '/app/views/dashboard.php';
	}

	public function getStatus() {
		$kpis = [
			'total_funcionarios' => $this->funcionarioDAO->countAllAtivos(),
			'em_servico' => count($this->boletimDAO->getAllAbertos()),
			'em_viagem' => $this->apontamentoDAO->countAtividadesEmAndamentoPorTipo('Viagem Programada'),
			'revisoes_urgentes' => $this->revisaoDAO->countRevisoesUrgentesPendentes()
		];

		$funcionariosAtivos = $this->funcionarioDAO->getAllAtivos();
		$monitoramento = [];

		foreach ($funcionariosAtivos as $funcionario) {
			$boletim = $this->boletimDAO->findLatestDoDiaPorFuncionario($funcionario['id']);
			$atividadeAtual = null;
			$statusInfo = [];

			if (!$boletim) {
				$statusInfo = [
					'badge_texto' => 'Fora de Serviço',
					'badge_classe' => 'bg-secondary',
					'status_texto' => 'Boletim Não Iniciado',
					'status_classe' => 'text-muted',
					'status_icon' => 'bi-x-circle-fill',
					'desde' => '---'
				];
			} elseif ($boletim['status'] == 'Fechado') {
				$statusInfo = [
					'badge_texto' => 'Ocioso',
					'badge_classe' => 'bg-secondary',
					'status_texto' => 'Boletim Fechado',
					'status_classe' => 'text-secondary',
					'status_icon' => 'bi-check-circle-fill',
					'desde' => $boletim['hora_fechamento']
				];
			} else {
				$atividadeAtual = $this->apontamentoDAO->findLastOpenByBoletimId($boletim['id']);
				
				if ($atividadeAtual) {
					$statusTexto = $atividadeAtual['tipo_apontamento_nome'];
					$statusClasse = 'text-info';
					$statusIcon = 'bi-clock-history';

					if ($statusTexto == 'Viagem Programada') {
						$statusClasse = 'text-primary';
						$statusIcon = 'bi-truck';
					}
					if ($statusTexto == 'Parada') {
						$statusClasse = 'text-warning';
						$statusIcon = 'bi-pause-circle-fill';
					}
					if ($statusTexto == 'Abastecimento') {
						$statusClasse = 'text-info';
						$statusIcon = 'bi-fuel-pump-fill';
					}

					$statusInfo = [
						'badge_texto' => 'Em Atividade',
						'badge_classe' => 'bg-success',
						'status_texto' => $statusTexto,
						'status_classe' => $statusClasse,
						'status_icon' => $statusIcon,
						'desde' => $atividadeAtual['hora_inicio']
					];
				} else {
					$statusInfo = [
						'badge_texto' => 'Em Serviço',
						'badge_classe' => 'bg-success',
						'status_texto' => 'À Disposição',
						'status_classe' => 'text-success',
						'status_icon' => 'bi-person-check-fill',
						'desde' => $boletim['hora_abertura']
					];
				}
			}
			
			$monitoramento[] = [
				'funcionario' => $funcionario,
				'boletim' => $boletim,
				'status_info' => $statusInfo
			];
		}

		header('Content-Type: application/json');
		echo json_encode([
			'kpis' => $kpis,
			'monitoramento' => $monitoramento
		]);
		exit();
	}
}