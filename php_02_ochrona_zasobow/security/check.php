<?php
// Prost y mechanizm ochrony zasobow - sprawdza czy jest sesja z zalogowanym uzytkownikiem
session_start();

if (!isset($_SESSION['user'])) {
	// nie ma zalogowanego uzytkownika - przekieruj do formularza logowania
	header('Location: ' . _APP_URL . '/security/login_view.php');
	exit();
}
?>