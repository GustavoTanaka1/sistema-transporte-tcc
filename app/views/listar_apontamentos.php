<?php 
$pageTitle = "Gerenciar Apontamentos";
require_once 'partials/header.php'; 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
	<a href="<?= BASE_URL ?>/apontamento/create" class="btn btn-primary ms-auto">
		<i class="bi bi-plus-lg me-2"></i> Lançar Novo Apontamento
	</a>
</div>

<div class="card">
	<div class="card-header">
		Histórico de Apontamentos
	</div>
	<div class="card-body">
		<table id="tabela-dados" class="table table-striped table-hover align-middle">
			<thead class="table-dark">
				<tr>
					<th>#</th>
					<th>Funcionário</th>
					<th>Veículo (Placa)</th>
					<th>Data</th>
					<th>Início</th>
					<th>Fim</th>
					<th class="text-end">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($apontamentos as $apontamento): ?>
					<tr>
						<td><?= $apontamento['id'] ?></td>
						<td><?= htmlspecialchars($apontamento['funcionario_nome']) ?></td>
						<td><?= htmlspecialchars($apontamento['veiculo_placa']) ?></td>
						<td><?= date('d/m/Y', strtotime($apontamento['data'])) ?></td>
						<td><?= htmlspecialchars($apontamento['hora_inicio']) ?></td>
						<td><?= htmlspecialchars($apontamento['hora_fim']) ?></td>
						<td class="text-end">
							<a href="<?= BASE_URL ?>/apontamento/edit/<?= $apontamento['id'] ?>" class="btn btn-sm btn-outline-warning" title="Editar">
								<i class="bi bi-pencil-square"></i>
							</a>
							<a href="<?= BASE_URL ?>/apontamento/destroy/<?= $apontamento['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Este registro será excluído permanentemente. Confirma?');">
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