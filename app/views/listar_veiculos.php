<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Veículos</title>
</head>
<body>
    <h1>Gerenciamento de Veículos</h1>
    <a href="<?= BASE_URL ?>/dashboard">Voltar ao Dashboard</a>
    <a href="<?= BASE_URL ?>/veiculo/create" style="float: right;">Adicionar Novo Veículo</a>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Placa</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>KM Atual</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($veiculos)): ?>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td><?= htmlspecialchars($veiculo['placa']) ?></td>
                        <td><?= htmlspecialchars($veiculo['modelo']) ?></td>
                        <td><?= htmlspecialchars($veiculo['ano']) ?></td>
                        <td><?= htmlspecialchars($veiculo['km_atual']) ?></td>
                        <td><?= ucfirst(htmlspecialchars($veiculo['status'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/veiculo/edit/<?= $veiculo['id'] ?>">Editar</a>
                            <a href="<?= BASE_URL ?>/veiculo/destroy/<?= $veiculo['id'] ?>" onclick="return confirm('Tem certeza que deseja inativar este veículo?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Nenhum veículo cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>