<?php 
$pageTitle = isset($veiculo) ? "Editar Veículo" : "Adicionar Veículo";
require_once 'partials/header.php'; 

$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
    <div class="card-header">
        <?= isset($veiculo) ? 'Editar Dados do Veículo' : 'Adicionar Novo Veículo' ?>
    </div>
    <div class="card-body">
        <form action="<?= isset($veiculo) ? BASE_URL . '/veiculo/update/' . $veiculo['id'] : BASE_URL . '/veiculo/store' ?>" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="placa" class="form-label">Placa:</label>
                    <input type="text" id="placa" name="placa" class="form-control" value="<?= $formData['placa'] ?? $veiculo['placa'] ?? '' ?>" placeholder="Ex: ABC-1234" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control" value="<?= $formData['modelo'] ?? $veiculo['modelo'] ?? '' ?>" placeholder="Ex: Scania R450" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="ano" class="form-label">Ano:</label>
                    <input type="number" id="ano" name="ano" class="form-control" value="<?= $formData['ano'] ?? $veiculo['ano'] ?? '' ?>" placeholder="Ex: 2020" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="km_atual" class="form-label">Quilometragem:</label>
                    <input type="number" step="0.01" id="km_atual" name="km_atual" class="form-control" value="<?= $formData['km_atual'] ?? $veiculo['km_atual'] ?? '' ?>" placeholder="Ex: 150000.50" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-select">
                        <option value="ativo" <?= (($formData['status'] ?? $veiculo['status'] ?? '') == 'ativo') ? 'selected' : '' ?>>Ativo</option>
                        <option value="inativo" <?= (($formData['status'] ?? $veiculo['status'] ?? '') == 'inativo') ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="<?= BASE_URL ?>/veiculo" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>