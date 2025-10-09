<?php 
$pageTitle = "Relatório de Produtividade";
require_once 'partials/header.php'; 
?>

<div class="card mb-4">
    <div class="card-header">
        Filtros do Relatório
    </div>
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/relatorio">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="data_inicio" class="form-label">Data de Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?= $_POST['data_inicio'] ?? date('Y-m-01') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="data_fim" class="form-label">Data de Fim:</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= $_POST['data_fim'] ?? date('Y-m-t') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="funcionario_id" class="form-label">Funcionário:</label>
                    <select id="funcionario_id" name="funcionario_id" class="form-select">
                        <option value="">Todos os Funcionários</option>
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <option value="<?= $funcionario['id'] ?>" <?= (isset($_POST['funcionario_id']) && $_POST['funcionario_id'] == $funcionario['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($funcionario['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-funnel-fill me-2"></i>Gerar Relatório
            </button>
        </form>
    </div>
</div>

<?php if (isset($resultados)): ?>
    <div class="card">
        <div class="card-header">
            Resultados da Busca
        </div>
        <div class="card-body">
            <?php if (empty($resultados)): ?>
                <div class="alert alert-danger" role="alert">
                    Nenhum resultado encontrado para os filtros selecionados.
                </div>
            <?php else: ?>
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
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
        </div>
    </div>
<?php endif; ?>

<?php require_once 'partials/footer.php'; ?>