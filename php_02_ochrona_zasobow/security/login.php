<?php
require_once dirname(__FILE__).'/../config.php';
session_start();

// proste uwierzytelnianie: tylko jeden uzytkownik "admin" z haslem "admin"
$user = isset($_POST['user']) ? $_POST['user'] : null;
$pass = isset($_POST['pass']) ? $_POST['pass'] : null;

if ($user === 'admin' && $pass === 'admin') {
	// zapamietaj w sesji
	$_SESSION['user'] = $user;
	// przekieruj do glownej aplikacji
	header('Location: ' . _APP_URL . '/index.php');
	exit();
} else {
	// bledne dane - powrot do formularza
	header('Location: ' . _APP_URL . '/security/login_view.php?error=1');
	exit();
}
?>