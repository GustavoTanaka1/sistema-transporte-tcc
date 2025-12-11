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
		try {
			$pdo = Conexao::getConexao();
		} catch (Exception $e) {
			echo json_encode(['error' => 'Erro de conexão']);
			exit;
		}

		$totalFuncionarios = $pdo->query("SELECT COUNT(*) FROM funcionarios WHERE status = 'ativo'")->fetchColumn();
		$emServico = $pdo->query("SELECT COUNT(*) FROM boletins WHERE status = 'Aberto'")->fetchColumn();
		
		$sqlViagem = "SELECT COUNT(DISTINCT b.id) FROM boletins b INNER JOIN apontamentos a ON b.id = a.boletim_id WHERE b.status = 'Aberto' AND a.tipo_apontamento_id IN (1, 5)";
		$emViagem = $pdo->query($sqlViagem)->fetchColumn();
		
		$revisoes = $pdo->query("SELECT COUNT(*) FROM apontamentos_revisao WHERE status_revisao IN ('Pendente', 'Em Andamento')")->fetchColumn();

		$sqlGrafico = "
			SELECT 
				MONTH(b.data_abertura) as mes_num, 
				COUNT(a.id) as total 
			FROM apontamentos a
			JOIN boletins b ON a.boletim_id = b.id
			WHERE a.tipo_apontamento_id IN (1, 5) 
			AND b.data_abertura >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
			GROUP BY MONTH(b.data_abertura) 
			ORDER BY b.data_abertura ASC
		";
		$stmt = $pdo->query($sqlGrafico);
		$dadosGrafico = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$labelsMeses = [];
		$valoresMeses = [];
		$nomesMeses = [1=>'Jan', 2=>'Fev', 3=>'Mar', 4=>'Abr', 5=>'Mai', 6=>'Jun', 7=>'Jul', 8=>'Ago', 9=>'Set', 10=>'Out', 11=>'Nov', 12=>'Dez'];

		foreach($dadosGrafico as $d) {
			$mesNum = (int)$d['mes_num'];
			if(isset($nomesMeses[$mesNum])) {
				$labelsMeses[] = $nomesMeses[$mesNum];
				$valoresMeses[] = $d['total'];
			}
		}

		$sqlRanking = "
			SELECT f.nome, COUNT(a.id) as total_viagens
			FROM apontamentos a
			JOIN boletins b ON a.boletim_id = b.id
			JOIN funcionarios f ON b.funcionario_id = f.id
			WHERE a.tipo_apontamento_id IN (1, 5)
			GROUP BY f.id
			ORDER BY total_viagens DESC
			LIMIT 5
		";
		$stmt = $pdo->query($sqlRanking);
		$dadosRanking = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$labelsRanking = [];
		$valoresRanking = [];
		foreach($dadosRanking as $r) {
			$primeiroNome = explode(' ', trim($r['nome']))[0];
			$labelsRanking[] = $primeiroNome;
			$valoresRanking[] = $r['total_viagens'];
		}

		$stmt = $pdo->query("SELECT COUNT(*) FROM veiculos WHERE status = 'ativo'");
		$totalVeiculos = $stmt->fetchColumn();
		$livres = $totalVeiculos - $emServico; 
		$labelsFrota = ['Em Operação', 'Disponível'];
		$valoresFrota = [$emServico, ($livres < 0 ? 0 : $livres)];

		$sqlMonitor = "
			SELECT 
				f.nome as func_nome, f.cargo as func_cargo,
				v.placa as veiculo_placa, v.modelo as veiculo_modelo,
				b.id as boletim_id, b.hora_abertura,
				(SELECT tipo_apontamento_id FROM apontamentos WHERE boletim_id = b.id ORDER BY id DESC LIMIT 1) as ultimo_tipo,
				(SELECT hora_inicio FROM apontamentos WHERE boletim_id = b.id ORDER BY id DESC LIMIT 1) as hora_apontamento
			FROM boletins b
			JOIN funcionarios f ON b.funcionario_id = f.id
			JOIN veiculos v ON b.veiculo_id = v.id
			WHERE b.status = 'Aberto'
			ORDER BY b.id DESC
		";
		$stmt = $pdo->query($sqlMonitor);
		$listaRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$monitoramento = [];
		foreach($listaRaw as $row) {
			switch($row['ultimo_tipo']) {
				case 2: $badge = 'bg-warning text-dark'; $texto = 'Em Pausa'; $icon = 'bi-pause-circle'; $classe = 'text-warning'; break;
				case 3: $badge = 'bg-info text-dark'; $texto = 'Abastecendo'; $icon = 'bi-fuel-pump'; $classe = 'text-info'; break;
				case 4: $badge = 'bg-danger'; $texto = 'Manutenção'; $icon = 'bi-wrench'; $classe = 'text-danger'; break;
				default: $badge = 'bg-success'; $texto = 'Em Trânsito'; $icon = 'bi-truck'; $classe = 'text-success';
			}

			$monitoramento[] = [
				'funcionario' => ['nome' => $row['func_nome'], 'cargo' => $row['func_cargo']],
				'boletim' => [
					'id' => $row['boletim_id'], 
					'veiculo_placa' => $row['veiculo_placa'] . ' - ' . $row['veiculo_modelo'],
					'hora_abertura' => $row['hora_abertura']
				],
				'status_info' => [
					'badge_classe' => $badge, 'badge_texto' => $texto,
					'status_icon' => $icon, 'status_classe' => $classe, 'status_texto' => $texto,
					'desde' => $row['hora_apontamento'] ?? $row['hora_abertura']
				]
			];
		}

		header('Content-Type: application/json');
		echo json_encode([
			'kpis' => ['total_funcionarios' => $totalFuncionarios, 'em_servico' => $emServico, 'em_viagem' => $emViagem, 'revisoes_urgentes' => $revisoes],
			'graficos' => [
				'viagens' => ['labels' => $labelsMeses, 'dados' => $valoresMeses],
				'frota' => ['labels' => $labelsFrota, 'dados' => $valoresFrota],
				'ranking' => ['labels' => $labelsRanking, 'dados' => $valoresRanking]
			],
			'monitoramento' => $monitoramento
		]);
		exit;
	}
}