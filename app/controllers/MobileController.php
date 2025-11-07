<?php

require_once PROJECT_ROOT . '/app/dao/UsuarioDAO.php';
require_once PROJECT_ROOT . '/app/dao/FuncionarioDAO.php';
require_once PROJECT_ROOT . '/app/dao/VeiculoDAO.php';
require_once PROJECT_ROOT . '/app/dao/BoletimDAO.php';
require_once PROJECT_ROOT . '/app/dao/TipoParadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/ApontamentoDAO.php';
require_once PROJECT_ROOT . '/app/dao/ViagemProgramadaDAO.php';
require_once PROJECT_ROOT . '/app/dao/RevisaoDAO.php';
require_once PROJECT_ROOT . '/app/dao/RotaDAO.php';
require_once PROJECT_ROOT . '/app/core/FlashMessage.php';

class MobileController {

	private $usuarioDAO;
	private $funcionarioDAO;
	private $veiculoDAO;
	private $boletimDAO;
	private $tipoParadaDAO;
	private $apontamentoDAO;
	private $viagemProgramadaDAO;
	private $rotaDAO;
	private $revisaoDAO;

	public function __construct() {
		$this->usuarioDAO = new UsuarioDAO();
		$this->funcionarioDAO = new FuncionarioDAO();
		$this->veiculoDAO = new VeiculoDAO();
		$this->boletimDAO = new BoletimDAO();
		$this->tipoParadaDAO = new TipoParadaDAO();
		$this->apontamentoDAO = new ApontamentoDAO();
		$this->viagemProgramadaDAO = new ViagemProgramadaDAO();
		$this->rotaDAO = new RotaDAO();
		$this->revisaoDAO = new RevisaoDAO();

		$action = $_GET['url'] ?? '';
		$actionParts = explode('/', $action);
		$method = $actionParts[1] ?? 'index';

		if ($method !== 'index' && $method !== 'autenticar') {
			if (!isset($_SESSION['funcionario_id'])) {
				header('Location: ' . BASE_URL . '/mobile');
				exit();
			}
		}
	}

	private function getCurrentOpenActivity() {
		if (!isset($_SESSION['boletim_id'])) return null;
		return $this->apontamentoDAO->findLastOpenByBoletimId($_SESSION['boletim_id']);
	}

	private function resumePreviousViagemIfNeeded($finalizedActivityType) {
		$retomarViagemId = $_SESSION['last_viagem_programada_id'] ?? null;
		if (($finalizedActivityType == 'Parada' || $finalizedActivityType == 'Abastecimento') && $retomarViagemId) {
			$this->apontamentoDAO->createViagemApontamento($_SESSION['boletim_id'], $retomarViagemId);
			unset($_SESSION['last_viagem_programada_id']);
			FlashMessage::set('Viagem retomada automaticamente.', 'info');
		}
	}

	public function index() {
		if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 'colaborador') {
			require_once PROJECT_ROOT . '/app/views/mobile/login.php';
		} else {
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
	}

	public function autenticar() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$usuario = $this->usuarioDAO->autenticar($_POST['login'], $_POST['senha']);
			if (is_array($usuario) && 
				isset($usuario['tipo_usuario']) && $usuario['tipo_usuario'] == 'colaborador' && 
				!empty($usuario['funcionario_id'])) {
				
				$_SESSION['usuario_id'] = $usuario['id'];
				$_SESSION['usuario_login'] = $usuario['login'];
				$_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
				$_SESSION['funcionario_id'] = $usuario['funcionario_id'];
				header('Location: ' . BASE_URL . '/mobile/home');
				exit();
			} else {
				FlashMessage::set('Login, senha ou permissão inválidos.', 'danger');
				header('Location: ' . BASE_URL . '/mobile');
				exit();
			}
		}
	}

	public function home() {
		$funcionario = $this->funcionarioDAO->getById($_SESSION['funcionario_id']);
		$boletimAberto = $this->boletimDAO->getBoletimAbertoPorFuncionario($_SESSION['funcionario_id']);
		$atividadeAtual = null;

		if ($boletimAberto) {
			$_SESSION['boletim_id'] = $boletimAberto['id'];
			$atividadeAtual = $this->getCurrentOpenActivity();
		} else {
			unset($_SESSION['boletim_id']);
			unset($_SESSION['last_viagem_programada_id']);
		}

		require_once PROJECT_ROOT . '/app/views/mobile/home.php';
	}

	public function abrirBoletim() {
		$veiculos = $this->veiculoDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/mobile/abrir_boletim.php';
	}

	public function salvarBoletim() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$dados = [
				'funcionario_id' => $_SESSION['funcionario_id'],
				'veiculo_id' => $_POST['veiculo_id'],
				'km_inicial' => $_POST['km_inicial']
			];

			if (empty($dados['veiculo_id']) || empty($dados['km_inicial']) || !is_numeric($dados['km_inicial'])) {
				FlashMessage::set('Preencha todos os campos corretamente.', 'danger');
				header('Location: '. BASE_URL . '/mobile/abrirBoletim');
				exit();
			}

			$novoBoletimId = $this->boletimDAO->create($dados);

			if ($novoBoletimId) {
				$_SESSION['boletim_id'] = $novoBoletimId;
				FlashMessage::set('Boletim aberto com sucesso! Bom trabalho.', 'success');
				header('Location: ' . BASE_URL . '/mobile/home');
			} else {
				FlashMessage::set('Erro ao abrir o boletim. Tente novamente.', 'danger');
				header('Location: ' . BASE_URL . '/mobile/abrirBoletim');
			}
			exit();
		}
	}

	public function apontarParada() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Abra o boletim primeiro.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$atividadeAtual = $this->getCurrentOpenActivity();

		if ($atividadeAtual && $atividadeAtual['tipo_apontamento_nome'] != 'Viagem Programada') {
			FlashMessage::set('Finalize a atividade atual (' . htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) . ') antes de iniciar uma parada.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$tiposParada = $this->tipoParadaDAO->getAll();
		require_once PROJECT_ROOT . '/app/views/mobile/apontar_parada.php';
	}

	public function salvarParada() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$boletimId = $_SESSION['boletim_id'];
			$tipoParadaId = $_POST['tipo_parada_id'];
			$observacao = $_POST['observacao'] ?? null;

			if (empty($tipoParadaId)) {
				FlashMessage::set('Selecione o motivo da parada.', 'danger');
				header('Location: '. BASE_URL . '/mobile/apontarParada');
				exit();
			}

			$atividadeAtual = $this->getCurrentOpenActivity();
			if ($atividadeAtual && $atividadeAtual['tipo_apontamento_nome'] == 'Viagem Programada') {
				$this->apontamentoDAO->finalizeApontamento($atividadeAtual['id']);
				$_SESSION['last_viagem_programada_id'] = $atividadeAtual['viagem_programada_id'];
			}

			if ($this->apontamentoDAO->createParadaApontamento($boletimId, $tipoParadaId, $observacao)) {
				FlashMessage::set('Parada iniciada com sucesso!', 'info');
			} else {
				FlashMessage::set('Erro ao iniciar a parada.', 'danger');
			}
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
	}

	public function apontarAbastecimento() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Abra o boletim primeiro.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$atividadeAtual = $this->getCurrentOpenActivity();

		if ($atividadeAtual && $atividadeAtual['tipo_apontamento_nome'] != 'Viagem Programada') {
			FlashMessage::set('Finalize a atividade atual (' . htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) . ') antes de iniciar um abastecimento.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		require_once PROJECT_ROOT . '/app/views/mobile/apontar_abastecimento.php';
	}

	public function salvarAbastecimento() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$boletimId = $_SESSION['boletim_id'];
			$local = $_POST['local'];
			$litros = $_POST['litros'];
			$valor = $_POST['valor'];
			$km = $_POST['km'];

			if (empty($local) || empty($litros) || !is_numeric($litros) || empty($valor) || !is_numeric($valor) || empty($km) || !is_numeric($km)) {
				FlashMessage::set('Preencha todos os campos do abastecimento corretamente.', 'danger');
				header('Location: '. BASE_URL . '/mobile/apontarAbastecimento');
				exit();
			}

			$atividadeAtual = $this->getCurrentOpenActivity();
			if ($atividadeAtual && $atividadeAtual['tipo_apontamento_nome'] == 'Viagem Programada') {
				$this->apontamentoDAO->finalizeApontamento($atividadeAtual['id']);
				$_SESSION['last_viagem_programada_id'] = $atividadeAtual['viagem_programada_id'];
			}

			if ($this->apontamentoDAO->createAbastecimentoApontamento($boletimId, $local, $litros, $valor, $km)) {
				FlashMessage::set('Abastecimento registrado com sucesso!', 'info');
			} else {
				FlashMessage::set('Erro ao registrar abastecimento.', 'danger');
			}
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
	}

	public function finalizarAtividadeAtual() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$atividadeAtual = $this->getCurrentOpenActivity();

		if (!$atividadeAtual) {
			FlashMessage::set('Nenhuma atividade em andamento para finalizar.', 'warning');
		} else {
			if ($this->apontamentoDAO->finalizeApontamento($atividadeAtual['id'])) {
				FlashMessage::set(htmlspecialchars($atividadeAtual['tipo_apontamento_nome']) . ' finalizada com sucesso!', 'success');
				$this->resumePreviousViagemIfNeeded($atividadeAtual['tipo_apontamento_nome']);
			} else {
				FlashMessage::set('Erro ao finalizar a atividade.', 'danger');
			}
		}
		header('Location: ' . BASE_URL . '/mobile/home');
		exit();
	}

	public function listarViagensProgramadas() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Abra o boletim primeiro.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		$atividadeAtual = $this->getCurrentOpenActivity();
		if ($atividadeAtual) {
			FlashMessage::set('Finalize a atividade atual antes de iniciar uma viagem.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$viagensDisponiveis = $this->viagemProgramadaDAO->findByFuncionarioIdAndStatus($_SESSION['funcionario_id'], 'Programada');
		require_once PROJECT_ROOT . '/app/views/mobile/listar_viagens_programadas.php';
	}

	public function iniciarViagem($viagemProgramadaId) {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		$atividadeAtual = $this->getCurrentOpenActivity();
		if ($atividadeAtual) {
			FlashMessage::set('Finalize a atividade atual antes de iniciar outra.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$viagemIniciada = $this->viagemProgramadaDAO->updateStatus($viagemProgramadaId, 'Iniciada');
		$apontamentoCriado = $this->apontamentoDAO->createViagemApontamento($_SESSION['boletim_id'], $viagemProgramadaId);

		if ($viagemIniciada && $apontamentoCriado) {
			FlashMessage::set('Viagem iniciada com sucesso!', 'info');
			unset($_SESSION['last_viagem_programada_id']);
		} else {
			FlashMessage::set('Erro ao iniciar a viagem.', 'danger');
		}
		header('Location: ' . BASE_URL . '/mobile/home');
		exit();
	}

	public function finalizarViagemDefinitivamente() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$atividadeAtual = $this->getCurrentOpenActivity();

		if (!$atividadeAtual || $atividadeAtual['tipo_apontamento_nome'] != 'Viagem Programada') {
			FlashMessage::set('A atividade atual não é uma viagem programada.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$viagemProgramadaId = $atividadeAtual['viagem_programada_id'];
		$apontamentoFinalizado = $this->apontamentoDAO->finalizeApontamento($atividadeAtual['id']);
		$viagemConcluida = $this->viagemProgramadaDAO->updateStatus($viagemProgramadaId, 'Concluída');

		if ($apontamentoFinalizado && $viagemConcluida) {
			FlashMessage::set('Viagem programada finalizada com sucesso!', 'success');
			unset($_SESSION['last_viagem_programada_id']);
		} else {
			FlashMessage::set('Erro ao finalizar a viagem programada.', 'danger');
		}
		header('Location: ' . BASE_URL . '/mobile/home');
		exit();
	}

	public function fecharBoletim() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Nenhum boletim aberto para fechar.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$atividadeAtual = $this->getCurrentOpenActivity();
		if ($atividadeAtual) {
			FlashMessage::set('Finalize a atividade atual antes de fechar o boletim.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$boletimAberto = $this->boletimDAO->getById($_SESSION['boletim_id']);
		require_once PROJECT_ROOT . '/app/views/mobile/fechar_boletim.php';
	}

	public function salvarFechamentoBoletim() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$boletimId = $_SESSION['boletim_id'];
			$kmFinal = $_POST['km_final'];

			if (empty($kmFinal) || !is_numeric($kmFinal)) {
				FlashMessage::set('Informe a quilometragem final válida.', 'danger');
				header('Location: ' . BASE_URL . '/mobile/fecharBoletim');
				exit();
			}

			$boletimAberto = $this->boletimDAO->getById($boletimId);
			if ($kmFinal < $boletimAberto['km_inicial']) {
				FlashMessage::set('A KM final não pode ser menor que a KM inicial.', 'danger');
				header('Location: ' . BASE_URL . '/mobile/fecharBoletim');
				exit();
			}

			if ($this->boletimDAO->fecharBoletim($boletimId, $kmFinal)) {
				unset($_SESSION['boletim_id']);
				unset($_SESSION['last_viagem_programada_id']);
				FlashMessage::set('Boletim fechado com sucesso!', 'success');
				header('Location: ' . BASE_URL . '/mobile/home');
			} else {
				FlashMessage::set('Erro ao fechar o boletim.', 'danger');
				header('Location: ' . BASE_URL . '/mobile/fecharBoletim');
			}
			exit();
		}
	}

	public function logout() {
		session_start();
		session_destroy();
		header('Location: ' . BASE_URL . '/mobile');
		exit();
	}

	public function apontarRota() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Abra o boletim primeiro.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}

		$atividadeAtual = $this->getCurrentOpenActivity();
		if (!$atividadeAtual || $atividadeAtual['tipo_apontamento_nome'] != 'Viagem Programada') {
			FlashMessage::set('Você precisa estar em uma viagem para apontar uma rota/entrega.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		
		$apontamentoViagemId = $atividadeAtual['id']; 
		require_once PROJECT_ROOT . '/app/views/mobile/apontar_rota.php';
	}

	public function salvarRota() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$boletimId = $_SESSION['boletim_id'];
			$dados = [
				'boletim_id' => $boletimId,
				'apontamento_id' => $_POST['apontamento_id'],
				'destino' => $_POST['destino'],
				'status_entrega' => $_POST['status_entrega'],
				'observacao' => $_POST['observacao'] ?? null
			];

			if (empty($dados['destino'])) {
				FlashMessage::set('O campo Destino/Local é obrigatório.', 'danger');
				header('Location: ' . BASE_URL . '/mobile/apontarRota');
				exit();
			}

			if ($this->rotaDAO->create($dados)) {
				FlashMessage::set('Rota/Entrega registrada com sucesso!', 'info');
			} else {
				FlashMessage::set('Erro ao registrar a rota/entrega.', 'danger');
			}
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
	}

	public function apontarRevisao() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Abra o boletim primeiro.', 'warning');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		$boletimAberto = $this->boletimDAO->getById($_SESSION['boletim_id']);
		require_once PROJECT_ROOT . '/app/views/mobile/apontar_revisao.php';
	}

	public function salvarRevisao() {
		if (!isset($_SESSION['boletim_id'])) {
			FlashMessage::set('Sessão expirada.', 'danger');
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$boletim = $this->boletimDAO->getById($_SESSION['boletim_id']);
			$dados = [
				'boletim_id' => $_SESSION['boletim_id'],
				'veiculo_id' => $boletim['veiculo_id'],
				'km_veiculo' => $_POST['km_veiculo'],
				'tipo_revisao' => $_POST['tipo_revisao'],
				'descricao_problema' => $_POST['descricao_problema'],
				'urgencia' => $_POST['urgencia']
			];

			if (empty($dados['km_veiculo']) || empty($dados['tipo_revisao']) || empty($dados['descricao_problema'])) {
				FlashMessage::set('Preencha todos os campos obrigatórios.', 'danger');
				header('Location: ' . BASE_URL . '/mobile/apontarRevisao');
				exit();
			}

			if ($this->revisaoDAO->create($dados)) {
				FlashMessage::set('Relatório de revisão enviado com sucesso!', 'info');
			} else {
				FlashMessage::set('Erro ao enviar relatório de revisão.', 'danger');
			}
			header('Location: ' . BASE_URL . '/mobile/home');
			exit();
		}
	}
}