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

			echo "<div class='alert alert-{$type} alert-dismissible fade show' role='alert'>
					{$message}
					<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
				</div>";

			unset($_SESSION['flash_message']);
		}
	}
}