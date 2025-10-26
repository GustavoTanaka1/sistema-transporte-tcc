<?php 
$pageTitle = "Tipos de Apontamento";
require_once 'partials/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<a href="<?= BASE_URL ?>/tipoApontamento/create" class="btn btn-primary ms-auto">
		<i class="bi bi-plus-lg me-2"></i> Adicionar Novo Tipo
	</a>
</div>

<div class="card">
	<div class="card-header">
		Lista de Tipos de Apontamento
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th>Tabela de Referência</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($tiposApontamento as $tipo): ?>
					<tr>
						<td><?= $tipo['id'] ?></td>
						<td><?= htmlspecialchars($tipo['nome']) ?></td>
						<td><?= htmlspecialchars($tipo['tabela_referencia']) ?></td>
						<td class="text-end">
							<a href="<?= BASE_URL ?>/tipoApontamento/edit/<?= $tipo['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar">
								<i class="bi bi-pencil-square"></i>
							</a>
							<a href="<?= BASE_URL ?>/tipoApontamento/destroy/<?= $tipo['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?');">
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