<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Apontamentos</title>
</head>
<body>
    <h1>Gerenciamento de Apontamentos</h1>
    <a href="<?= BASE_URL ?>/dashboard">Voltar ao Dashboard</a>
    <a href="<?= BASE_URL ?>/apontamento/create" style="float: right;">Lançar Novo Apontamento</a>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Veículo (Placa)</th>
                <th>Data</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Observação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($apontamentos)): ?>
                <?php foreach ($apontamentos as $apontamento): ?>
                    <tr>
                        <td><?= htmlspecialchars($apontamento['funcionario_nome']) ?></td>
                        <td><?= htmlspecialchars($apontamento['veiculo_placa']) ?></td>
                        <td><?= date('d/m/Y', strtotime($apontamento['data'])) ?></td>
                        <td><?= htmlspecialchars($apontamento['hora_inicio']) ?></td>
                        <td><?= htmlspecialchars($apontamento['hora_fim']) ?></td>
                        <td><?= htmlspecialchars($apontamento['observacao']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/apontamento/edit/<?= $apontamento['id'] ?>">Editar</a>
                            <a href="<?= BASE_URL ?>/apontamento/destroy/<?= $apontamento['id'] ?>" onclick="return confirm('Tem certeza que deseja EXCLUIR PERMANENTEMENTE este registro?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum apontamento lançado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>