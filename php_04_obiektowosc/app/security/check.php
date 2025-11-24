<?php
global $conf;
//inicjacja mechanizmu sesji
session_start();

//pobranie roli
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

//jeśli brak parametru (niezalogowanie) to idź na stronę logowania
if ( empty($role) ){
	include $conf->root_path.'/app/security/login.php';
	//zatrzymaj dalsze przetwarzanie skryptów
	exit();
}
//jeśli ok to idź dalej