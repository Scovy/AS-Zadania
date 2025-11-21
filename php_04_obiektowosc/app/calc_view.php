<?php
require_once dirname(__FILE__) .'/../config.php';

require_once _ROOT_PATH.'/security/check.php';

if (!isset($smarty)) {
	if (session_status() == PHP_SESSION_NONE) session_start();
	echo '<p>Brak silnika szablonów. Proszę zainstalować Smarty.</p>';
	exit();
}

$smarty->assign('user', isset($_SESSION['user']) ? $_SESSION['user'] : 'gość');

if (isset($form)) {
	$smarty->assign('form', $form);
}
else {
	$vars = array('amount','years','rate','messages','result');
	foreach ($vars as $v) {
		if (isset($$v)) $smarty->assign($v, $$v);
	}
}

if (isset($res)) $smarty->assign('res', $res);
if (isset($msgs)) $smarty->assign('msgs', $msgs);

$smarty->display('calc.tpl');
?>