<?php 
$pageTitle = isset($apontamento) ? "Editar Apontamento" : "Lançar Apontamento";
require_once 'partials/header.php'; 

$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
    <div class="card-header">
         <?= isset($apontamento) ? 'Editar Apontamento' : 'Lançar Novo Apontamento' ?>
    </div>
    <div class="card-body">
        <form action="<?= isset($apontamento) ? BASE_URL . '/apontamento/update/' . $apontamento['id'] : BASE_URL . '/apontamento/store' ?>" method="POST">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="funcionario_id" class="form-label">Funcionário:</label>
                    <select id="funcionario_id" name="funcionario_id" class="form-select" required>
                        <option value="">Selecione um funcionário...</option>
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <?php if ($funcionario['status'] == 'ativo'): ?>
                                <option value="<?= $funcionario['id'] ?>" <?= (($formData['funcionario_id'] ?? $apontamento['funcionario_id'] ?? '') == $funcionario['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($funcionario['nome']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="veiculo_id" class="form-label">Veículo:</label>
                    <select id="veiculo_id" name="veiculo_id" class="form-select" required>
                        <option value="">Selecione um veículo...</option>
                        <?php foreach ($veiculos as $veiculo): ?>
                             <?php if ($veiculo['status'] == 'ativo'): ?>
                                <option value="<?= $veiculo['id'] ?>" <?= (($formData['veiculo_id'] ?? $apontamento['veiculo_id'] ?? '') == $veiculo['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($veiculo['placa'] . ' - ' . $veiculo['modelo']) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" id="data" name="data" class="form-control" value="<?= $formData['data'] ?? $apontamento['data'] ?? date('Y-m-d') ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="hora_inicio" class="form-label">Hora de Início:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" value="<?= $formData['hora_inicio'] ?? $apontamento['hora_inicio'] ?? '' ?>" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="hora_fim" class="form-label">Hora de Fim:</label>
                    <input type="time" id="hora_fim" name="hora_fim" class="form-control" value="<?= $formData['hora_fim'] ?? $apontamento['hora_fim'] ?? '' ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="observacao" class="form-label">Observação (Opcional):</label>
                <textarea id="observacao" name="observacao" class="form-control" rows="3" placeholder="Detalhes do serviço, rota, etc."><?= $formData['observacao'] ?? $apontamento['observacao'] ?? '' ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Apontamento</button>
            <a href="<?= BASE_URL ?>/apontamento" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>