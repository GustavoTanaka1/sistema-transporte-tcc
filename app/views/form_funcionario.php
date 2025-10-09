<?php 
$pageTitle = isset($funcionario) ? "Editar Funcionário" : "Adicionar Funcionário";
require_once 'partials/header.php'; 

// Pega os dados do formulário da sessão, se existirem (em caso de erro de validação)
$formData = $_SESSION['form_data'] ?? null;
unset($_SESSION['form_data']);
?>

<div class="card">
    <div class="card-header">
        <?= isset($funcionario) ? 'Editar Dados do Funcionário' : 'Adicionar Novo Funcionário' ?>
    </div>
    <div class="card-body">
        <form action="<?= isset($funcionario) ? BASE_URL . '/funcionario/update/' . $funcionario['id'] : BASE_URL . '/funcionario/store' ?>" method="POST">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="nome" class="form-label">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?= $formData['nome'] ?? $funcionario['nome'] ?? '' ?>" placeholder="Digite o nome completo" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cargo" class="form-label">Cargo:</label>
                    <input type="text" id="cargo" name="cargo" class="form-control" value="<?= $formData['cargo'] ?? $funcionario['cargo'] ?? '' ?>" placeholder="Ex: Motorista" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" value="<?= $formData['cpf'] ?? $funcionario['cpf'] ?? '' ?>" placeholder="000.000.000-00" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="telefone" class="form-label">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" value="<?= $formData['telefone'] ?? $funcionario['telefone'] ?? '' ?>" placeholder="(00) 00000-0000">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-select">
                        <option value="ativo" <?= (($formData['status'] ?? $funcionario['status'] ?? '') == 'ativo') ? 'selected' : '' ?>>Ativo</option>
                        <option value="inativo" <?= (($formData['status'] ?? $funcionario['status'] ?? '') == 'inativo') ? 'selected' : '' ?>>Inativo</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="<?= BASE_URL ?>/funcionario" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>