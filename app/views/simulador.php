<?php
if (!defined('BASE_URL')) {
	define('BASE_URL', 'http://localhost/sistema_transporte');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Simulador Mobile - Tanaka Transportes</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background-color: #e9ecef;
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			padding: 2rem;
		}
		.phone-frame {
			width: 410px;
			height: 850px;
			background-color: #111;
			border-radius: 40px;
			padding: 18px;
			box-shadow: 0 10px 50px rgba(0,0,0,0.3);
			display: flex;
			flex-direction: column;
		}
		.phone-screen {
			width: 100%;
			height: 100%;
			background-color: #fff;
			border: 0;
			border-radius: 22px;
		}
	</style>
</head>
<body>

	<div class="phone-frame">
		<iframe src="<?= BASE_URL ?>/mobile/home" class="phone-screen" title="Simulador Mobile"></iframe>
	</div>

</body>
</html>