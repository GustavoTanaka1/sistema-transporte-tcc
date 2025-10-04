<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= isset($apontamento) ? 'Editar' : 'Lançar' ?> Apontamento</title>
</head>
<body>
    <h1><?= isset($apontamento) ? 'Editar Apontamento' : 'Lançar Novo Apontamento' ?></h1>

    <form action="<?= isset($apontamento) ? BASE_URL . '/apontamento/update/' . $apontamento['id'] : BASE_URL . '/apontamento/store' ?>" method="POST">

        <div>
            <label for="funcionario_id">Funcionário:</label>
            <select id="funcionario_id" name="funcionario_id" required>
                <option value="">Selecione um funcionário</option>
                <?php foreach ($funcionarios as $funcionario): ?>
                    <?php if ($funcionario['status'] == 'ativo'): ?>
                        <option value="<?= $funcionario['id'] ?>" <?= (isset($apontamento) && $apontamento['funcionario_id'] == $funcionario['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($funcionario['nome']) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="veiculo_id">Veículo:</label>
            <select id="veiculo_id" name="veiculo_id" required>
                <option value="">Selecione um veículo</option>
                <?php foreach ($veiculos as $veiculo): ?>
                     <?php if ($veiculo['status'] == 'ativo'): ?>
                        <option value="<?= $veiculo['id'] ?>" <?= (isset($apontamento) && $apontamento['veiculo_id'] == $veiculo['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['modelo']) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?= $apontamento['data'] ?? '' ?>" required>
        </div>

        <div>
            <label for="hora_inicio">Hora de Início:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" value="<?= $apontamento['hora_inicio'] ?? '' ?>" required>
        </div>

        <div>
            <label for="hora_fim">Hora de Fim:</label>
            <input type="time" id="hora_fim" name="hora_fim" value="<?= $apontamento['hora_fim'] ?? '' ?>" required>
        </div>

        <div>
            <label for="observacao">Observação:</label>
            <textarea id="observacao" name="observacao" rows="4"><?= $apontamento['observacao'] ?? '' ?></textarea>
        </div>

        <button type="submit">Salvar</button>
        <a href="<?= BASE_URL ?>/apontamento">Cancelar</a>
    </form>
</body>
</html>