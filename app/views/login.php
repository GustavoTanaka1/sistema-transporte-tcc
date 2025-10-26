<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Sistema de Transporte</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/custom.css">

	<style>
		.login-container {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: var(--content-bg);
		}
		.login-card {
			max-width: 450px;
			width: 100%;
		}
	</style>
</head>
<body>
	<div class="login-container">
		<div class="card login-card shadow-lg">
			<div class="card-body p-4 p-md-5">
				<div class="text-center mb-4">
					<i class="bi bi-truck display-4 text-primary"></i>
					<h2 class="mt-2">Gestão de Transporte</h2>
					<p class="text-muted">Por favor, entre com suas credenciais</p>
				</div>

				<form action="<?= BASE_URL ?>/login/autenticar" method="POST">
					<div class="mb-3">
						<label for="login" class="form-label">Usuário</label>
						<div class="input-group">
							<span class="input-group-text"><i class="bi bi-person"></i></span>
							<input type="text" id="login" name="login" class="form-control" placeholder="Digite seu usuário" required>
						</div>
					</div>

					<div class="mb-4">
						<label for="senha" class="form-label">Senha</label>
						<div class="input-group">
							<span class="input-group-text"><i class="bi bi-lock"></i></span>
							<input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
						</div>
					</div>

					<div class="d-grid">
						<button type="submit" class="btn btn-primary btn-lg">Entrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>