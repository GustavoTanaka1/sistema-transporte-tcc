<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Produtividade</title>
</head>
<body>
    <h1>Relatório de Produtividade por Funcionário</h1>
    <a href="<?= BASE_URL ?>/dashboard">Voltar ao Dashboard</a>

    <form method="POST" action="<?= BASE_URL ?>/relatorio">
        <h3>Filtros</h3>
        <div>
            <label for="data_inicio">Data de Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" required>
        </div>
        <div>
            <label for="data_fim">Data de Fim:</label>
            <input type="date" id="data_fim" name="data_fim" required>
        </div>
        <div>
            <label for="funcionario_id">Funcionário:</label>
            <select id="funcionario_id" name="funcionario_id">
                <option value="">Todos os Funcionários</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <option value="<?= $funcionario['id'] ?>">
                        <?= htmlspecialchars($funcionario['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Gerar Relatório</button>
    </form>

    <?php if (isset($resultados)): ?>
        <hr>
        <h2>Resultados</h2>
        <?php if (empty($resultados)): ?>
            <p>Nenhum resultado encontrado para os filtros selecionados.</p>
        <?php else: ?>
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th>Funcionário</th>
                        <th>Total de Apontamentos</th>
                        <th>Total de Horas Trabalhadas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $resultado): ?>
                        <tr>
                            <td><?= htmlspecialchars($resultado['funcionario_nome']) ?></td>
                            <td><?= $resultado['total_apontamentos'] ?></td>
                            <td><?= $resultado['total_horas'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>