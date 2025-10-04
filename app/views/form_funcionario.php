<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= isset($funcionario) ? 'Editar' : 'Adicionar' ?> Funcionário</title>
</head>
<body>
    <h1><?= isset($funcionario) ? 'Editar Funcionário' : 'Adicionar Novo Funcionário' ?></h1>

    <form action="<?= isset($funcionario) ? BASE_URL . '/funcionario/update/' . $funcionario['id'] : BASE_URL . '/funcionario/store' ?>" method="POST">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= $funcionario['nome'] ?? '' ?>" required>
        </div>
        <div>
            <label for="cargo">Cargo:</label>
            <input type="text" id="cargo" name="cargo" value="<?= $funcionario['cargo'] ?? '' ?>" required>
        </div>
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="<?= $funcionario['cpf'] ?? '' ?>" required>
        </div>
        <div>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?= $funcionario['telefone'] ?? '' ?>">
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="ativo" <?= (isset($funcionario) && $funcionario['status'] == 'ativo') ? 'selected' : '' ?>>Ativo</option>
                <option value="inativo" <?= (isset($funcionario) && $funcionario['status'] == 'inativo') ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>
        <button type="submit">Salvar</button>
        <a href="<?= BASE_URL ?>/funcionario">Cancelar</a>
    </form>
</body>
</html>