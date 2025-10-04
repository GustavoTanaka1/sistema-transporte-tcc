<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Transporte</title>
</head>
<body>
    <h2>Login</h2>
    <form action="<?= BASE_URL ?>/login/autenticar" method="POST">
        <div>
            <label for="login">Usuário:</label>
            <input type="text" id="login" name="login" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div>
            <button type="submit">Entrar</button>
        </div>
    </form>
</body>
</html>