<?php 
$pageTitle = "Gerenciar Funcionários";
require_once 'partials/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<a href="<?= BASE_URL ?>/funcionario/create" class="btn btn-primary ms-auto">
		<i class="bi bi-plus-lg me-2"></i> Adicionar Novo Funcionário
	</a>
</div>

<div class="card">
	<div class="card-header">
		Lista de Funcionários
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th>Cargo</th>
					<th>CPF</th>
					<th>Status</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($funcionarios as $funcionario): ?>
					<tr>
						<td><?= $funcionario['id'] ?></td>
						<td><?= htmlspecialchars($funcionario['nome']) ?></td>
						<td><?= htmlspecialchars($funcionario['cargo']) ?></td>
						<td><?= htmlspecialchars($funcionario['cpf']) ?></td>
						<td>
							<span class="badge <?= $funcionario['status'] == 'ativo' ? 'bg-success' : 'bg-danger' ?>">
								<?= ucfirst(htmlspecialchars($funcionario['status'])) ?>
							</span>
						</td>
						<td class="text-end">
							<a href="<?= BASE_URL ?>/funcionario/edit/<?= $funcionario['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar">
								<i class="bi bi-pencil-square"></i>
							</a>
							<a href="<?= BASE_URL ?>/funcionario/destroy/<?= $funcionario['id'] ?>" class="btn btn-sm btn-outline-danger" title="Inativar" onclick="return confirm('Tem certeza?');">
								<i class="bi bi-trash3"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php require_once 'partials/footer.php'; ?>