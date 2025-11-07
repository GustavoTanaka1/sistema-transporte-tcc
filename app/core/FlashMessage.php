<?php

class FlashMessage {
	
	public static function set($message, $type = 'success') {
		$_SESSION['flash_message'] = [
			'message' => $message,
			'type' => $type
		];
	}

	public static function display() {
		if (isset($_SESSION['flash_message'])) {
			$flash = $_SESSION['flash_message'];
			$message = htmlspecialchars($flash['message']);
			$type = htmlspecialchars($flash['type']);
			
			$icon = 'info-circle-fill';
			$headerClass = 'text-bg-secondary';

			if ($type == 'success') {
				$icon = 'check-circle-fill';
				$headerClass = 'text-bg-success';
			} elseif ($type == 'danger') {
				$icon = 'exclamation-triangle-fill';
				$headerClass = 'text-bg-danger';
			} elseif ($type == 'warning') {
				$icon = 'exclamation-triangle-fill';
				$headerClass = 'text-bg-warning text-dark';
			} elseif ($type == 'info') {
				$headerClass = 'text-bg-info text-dark';
			}

			echo "
			<div class='toast align-items-center' role='alert' aria-live='assertive' aria-atomic='true' data-bs-delay='5000'>
				<div class='toast-header {$headerClass}'>
					<i class='bi bi-{$icon} me-2'></i>
					<strong class='me-auto'>Notificação</strong>
					<small>agora</small>
					<button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
				</div>
				<div class='toast-body'>
					{$message}
				</div>
			</div>
			";
			
			unset($_SESSION['flash_message']);
		}
	}
}