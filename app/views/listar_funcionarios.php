<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Funcionários</title>
</head>
<body>
    <h1>Gerenciamento de Funcionários</h1>
    <a href="<?= BASE_URL ?>/dashboard">Voltar ao Dashboard</a>
    <a href="<?= BASE_URL ?>/funcionario/create" style="float: right;">Adicionar Novo Funcionário</a>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Cargo</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($funcionarios)): ?>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <tr>
                        <td><?= htmlspecialchars($funcionario['nome']) ?></td>
                        <td><?= htmlspecialchars($funcionario['cargo']) ?></td>
                        <td><?= htmlspecialchars($funcionario['cpf']) ?></td>
                        <td><?= htmlspecialchars($funcionario['telefone']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($funcionario['status'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/funcionario/edit/<?= $funcionario['id'] ?>">Editar</a>
                            <a href="<?= BASE_URL ?>/funcionario/destroy/<?= $funcionario['id'] ?>" onclick="return confirm('Tem certeza que deseja inativar este funcionário?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum funcionário cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>