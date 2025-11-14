<?php
require_once dirname(__FILE__).'/../config.php';

if (!isset($smarty)) {
	echo '<p>Brak silnika szablonów. Proszę zainstalować Smarty.</p>';
	exit();
}

if (session_status() == PHP_SESSION_NONE) session_start();
$error = isset($_GET['error']) ? true : false;
$smarty->assign('error', $error);
$smarty->display('login.tpl');
?>