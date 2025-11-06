<?php

require_once PROJECT_ROOT . '/app/dao/RelatorioDAO.php';
require_once PROJECT_ROOT . '/app/dao/FuncionarioDAO.php';
require_once PROJECT_ROOT . '/app/dao/VeiculoDAO.php';
require_once PROJECT_ROOT . '/app/dao/TipoParadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/dao/AptParadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/AptAbastecimentoDAO.php';
require_once PROJECT_ROOT . '/app/dao/RotaDAO.php';
require_once PROJECT_ROOT . '/app/dao/RevisaoDAO.php';

class RelatorioController {
	
	private $relatorioDAO;
	private $funcionarioDAO;
	private $veiculoDAO;
	private $tipoParadaDAO;
	private $boletimDAO;
	private $apontamentoDAO;
	private $aptParadaDAO;
	private $aptAbastecimentoDAO;
	private $rotaDAO;
	private $revisaoDAO;

	public function __construct() {
		if (!isset($_SESSION['usuario_id'])) {
			header('Location: ' . BASE_URL);
			exit();
		}
		$this->relatorioDAO = new RelatorioDAO();
		$this->funcionarioDAO = new FuncionarioDAO();
		$this->veiculoDAO = new VeiculoDAO();
		$this->tipoParadaDAO = new TipoParadaDAO();
		$this->boletimDAO = new BoletimDAO();
		$this->apontamentoDAO = new ApontamentoDAO();
		$this->aptParadaDAO = new AptParadaDAO();
		$this->aptAbastecimentoDAO = new AptAbastecimentoDAO();
		$this->rotaDAO = new RotaDAO();
		$this->revisaoDAO = new RevisaoDAO();
	}

	public function index() {
		require_once PROJECT_ROOT . '/app/views/relatorio_index.php';
	}

	public function produtividade() {
		$funcionarios = $this->funcionarioDAO->getAll();
		$resultados = null;
		$filtroInfo = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_produtividade'])) {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];
			$funcionarioId = $_POST['funcionario_id'] ?: null;
			
			$funcionarioNome = "Todos os Funcionários";
			if ($funcionarioId) {
				$func = $this->funcionarioDAO->getById($funcionarioId);
				if ($func) $funcionarioNome = $func['nome'];
			}
			$filtroInfo = [
				'dataInicio' => $dataInicio,
				'dataFim' => $dataFim,
				'funcionarioNome' => $funcionarioNome
			];
			
			$resultados = $this->relatorioDAO->getTempoPorTipoApontamento($dataInicio, $dataFim, $funcionarioId);
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_produtividade.php';
	}

	public function consumo() {
		$veiculos = $this->veiculoDAO->getAll();
		$resultados = null;
		$filtroInfo = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_consumo'])) {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];
			$veiculoId = $_POST['veiculo_id'] ?: null;

			$veiculoNome = "Todos os Veículos";
			if ($veiculoId) {
				$veic = $this->veiculoDAO->getById($veiculoId);
				if ($veic) $veiculoNome = $veic['placa'] . ' - ' . $veic['modelo'];
			}
			$filtroInfo = [
				'dataInicio' => $dataInicio,
				'dataFim' => $dataFim,
				'veiculoNome' => $veiculoNome
			];

			$resultados = $this->relatorioDAO->getRelatorioConsumo($dataInicio, $dataFim, $veiculoId);
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_consumo.php';
	}

	public function paradas() {
		$tiposParada = $this->tipoParadaDAO->getAll();
		$funcionarios = $this->funcionarioDAO->getAll(); 
		$resultados = null;
		$filtroInfo = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_paradas'])) {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];
			$tipoParadaId = $_POST['tipo_parada_id'] ?: null;
			$funcionarioId = $_POST['funcionario_id'] ?: null; 

			$tipoParadaNome = "Todos os Tipos";
			if ($tipoParadaId) {
				$tipo = $this->tipoParadaDAO->getById($tipoParadaId);
				if ($tipo) $tipoParadaNome = $tipo['nome'];
			}
			
			$funcionarioNome = "Todos os Funcionários";
			if ($funcionarioId) {
				$func = $this->funcionarioDAO->getById($funcionarioId);
				if ($func) $funcionarioNome = $func['nome'];
			}

			$filtroInfo = [
				'dataInicio' => $dataInicio,
				'dataFim' => $dataFim,
				'tipoParadaNome' => $tipoParadaNome,
				'funcionarioNome' => $funcionarioNome 
			];

			$resultados = $this->relatorioDAO->getTempoTotalPorTipoParada($dataInicio, $dataFim, $tipoParadaId, $funcionarioId);
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_paradas.php';
	}

	public function revisoes() {
		$veiculos = $this->veiculoDAO->getAll();
		$resultados = null;
		$filtroInfo = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_revisoes'])) {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];
			$veiculoId = $_POST['veiculo_id'] ?: null;
			$urgencia = $_POST['urgencia'] ?: null;

			$veiculoNome = "Todos os Veículos";
			if ($veiculoId) {
				$veic = $this->veiculoDAO->getById($veiculoId);
				if ($veic) $veiculoNome = $veic['placa'] . ' - ' . $veic['modelo'];
			}
			$filtroInfo = [
				'dataInicio' => $dataInicio,
				'dataFim' => $dataFim,
				'veiculoNome' => $veiculoNome,
				'urgencia' => $urgencia ?: 'Todas'
			];

			$resultados = $this->relatorioDAO->getRelatorioRevisoes($dataInicio, $dataFim, $veiculoId, $urgencia);
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_revisoes.php';
	}

	public function boletim($id = null) {
		$todosBoletins = $this->boletimDAO->getAll();
		$boletimIdSelecionado = $id;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_boletim'])) {
			$boletimIdSelecionado = $_POST['boletim_id'] ?: null;
		}

		if ($boletimIdSelecionado) {
			$boletim = $this->boletimDAO->getById($boletimIdSelecionado);
			if (!$boletim) {
				FlashMessage::set('Boletim não encontrado.', 'danger');
				header('Location: ' . BASE_URL . '/relatorio/boletim');
				exit();
			}

			$apontamentosLog = $this->apontamentoDAO->getByBoletimId($boletimIdSelecionado);
			
			$apontamentos = [];
			$paradas = [];
			$abastecimentos = [];
			$rotas = $this->rotaDAO->getAllByBoletimId($boletimIdSelecionado);
			$revisoes = $this->revisaoDAO->getAllByBoletimId($boletimIdSelecionado);

			foreach ($apontamentosLog as $ap) {
				$apontamentos[] = $ap; 
				if ($ap['tipo_apontamento_nome'] == 'Parada') {
					$detalhes = $this->aptParadaDAO->getById($ap['apontamento_especifico_id']);
					$paradas[] = array_merge($ap, is_array($detalhes) ? $detalhes : []); 
				} elseif ($ap['tipo_apontamento_nome'] == 'Abastecimento') {
					$detalhes = $this->aptAbastecimentoDAO->getById($ap['apontamento_especifico_id']);
					$abastecimentos[] = array_merge($ap, is_array($detalhes) ? $detalhes : []);
				}
			}
		} else {
			$boletim = null;
			$apontamentos = [];
			$paradas = [];
			$abastecimentos = [];
			$rotas = [];
			$revisoes = [];
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_boletim.php';
	}

	public function inconsistencias() {
		$boletinsExtensos = null;
		$paradasLongas = null;
		$filtroInfo = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filtro_inconsistencias'])) {
			$dataInicio = $_POST['data_inicio'];
			$dataFim = $_POST['data_fim'];

			$filtroInfo = [
				'dataInicio' => $dataInicio,
				'dataFim' => $dataFim
			];

			$boletinsExtensos = $this->relatorioDAO->getJornadasExtensas($dataInicio, $dataFim);
			$paradasLongas = $this->relatorioDAO->getParadasLongas($dataInicio, $dataFim);
		}

		require_once PROJECT_ROOT . '/app/views/relatorio_inconsistencias.php';
	}
}