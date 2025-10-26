<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login de Motorista</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/custom.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/mobile.css">
</head>
<body class="login-container">
	<div class="card login-card shadow-lg">
		<div class="card-body p-4 p-md-5">
			<div class="text-center mb-4">
				<i class="bi bi-truck-front-fill display-4 text-primary"></i>
				<h2 class="mt-2">Portal do Motorista</h2>
			</div>

			<?php FlashMessage::display(); ?>

			<form action="<?= BASE_URL ?>/mobile/autenticar" method="POST">
				<div class="mb-3">
					<label for="login" class="form-label">Usuário (Motorista)</label>
					<input type="text" id="login" name="login" class="form-control" required>
				</div>
				<div class="mb-4">
					<label for="senha" class="form-label">Senha</label>
					<input type="password" id="senha" name="senha" class="form-control" required>
				</div>
				<div class="d-grid">
					<button type="submit" class="btn btn-primary btn-full-width">Entrar</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>