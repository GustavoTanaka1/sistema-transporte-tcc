<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= isset($veiculo) ? 'Editar' : 'Adicionar' ?> Veículo</title>
</head>
<body>
    <h1><?= isset($veiculo) ? 'Editar Veículo' : 'Adicionar Novo Veículo' ?></h1>

    <form action="<?= isset($veiculo) ? BASE_URL . '/veiculo/update/' . $veiculo['id'] : BASE_URL . '/veiculo/store' ?>" method="POST">
        <div>
            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" value="<?= $veiculo['placa'] ?? '' ?>" required>
        </div>
        <div>
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?= $veiculo['modelo'] ?? '' ?>" required>
        </div>
        <div>
            <label for="ano">Ano:</label>
            <input type="number" id="ano" name="ano" value="<?= $veiculo['ano'] ?? '' ?>" required>
        </div>
        <div>
            <label for="km_atual">Quilometragem:</label>
            <input type="number" step="0.01" id="km_atual" name="km_atual" value="<?= $veiculo['km_atual'] ?? '' ?>" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="ativo" <?= (isset($veiculo) && $veiculo['status'] == 'ativo') ? 'selected' : '' ?>>Ativo</option>
                <option value="inativo" <?= (isset($veiculo) && $veiculo['status'] == 'inativo') ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>
        <button type="submit">Salvar</button>
        <a href="<?= BASE_URL ?>/veiculo">Cancelar</a>
    </form>
</body>
</html>