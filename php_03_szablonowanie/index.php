<?php
require_once dirname(__FILE__).'/config.php';

require_once _ROOT_PATH.'/security/check.php';

if (isset($smarty)) {
	if (session_status() == PHP_SESSION_NONE) session_start();
	$smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'gość');
	$smarty->display('index.tpl');
} else {
	include _ROOT_PATH.'/app/calc_view.php';
}
?>