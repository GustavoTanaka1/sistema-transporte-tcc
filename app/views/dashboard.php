<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Bem-vindo, <?= $_SESSION['usuario_login']; ?>!</p>

    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>/veiculo">Gerenciar Veículos</a></li>
            <li><a href="<?= BASE_URL ?>/funcionario">Gerenciar Funcionários</a></li>
            <li><a href="<?= BASE_URL ?>/apontamento">Lançar Apontamentos</a></li>
            <li><a href="<?= BASE_URL ?>/relatorio">Relatórios</a></li>
        </ul>
    </nav>

    <a href="<?= BASE_URL ?>/login/logout">Sair</a>
</body>
</html>