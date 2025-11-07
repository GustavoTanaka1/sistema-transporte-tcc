</main> <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const toastElList = document.querySelectorAll('.toast');
		const toastList = [...toastElList].map(toastEl => {
			const toast = new bootstrap.Toast(toastEl);
			toast.show();
		});

		const timeElement = document.getElementById('current-time');
		const dateElement = document.getElementById('current-date');
		function updateClock() {
			const now = new Date();
			const timeString = now.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
			const dateString = now.toLocaleDateString('pt-BR');
			timeElement.textContent = timeString;
			dateElement.textContent = dateString;
		}
		updateClock();
		setInterval(updateClock, 1000);

		// SCRIPT DO DATATABLES
		$(document).ready(function() {
			$('#tabela-dados').DataTable({
				language: {
					url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json',
				},
				columnDefs: [
					{ 
						targets: [0, -1],
						orderable: false,
						searchable: false
					}
				]
			});
		});
	});
</script>
</body>
</html>